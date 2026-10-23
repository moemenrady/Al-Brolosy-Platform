<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientHistory;
use App\Models\Identity;
use App\Models\Project;
use App\Models\UserBehavior;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadCaptureController extends Controller
{
    /**
     * إرسال تفضيلات المستشار العقاري الذكي (Frictionless Concierge Quiz)
     */
    public function quizSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'purpose' => 'nullable|string|max:255',
            'unit_type' => 'nullable|string|max:255',
            'project_or_city' => 'nullable|string|max:255',
            'budget' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:255',
            'custom_answers' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'يرجى التأكد من ملء الحقول المطلوبة.',
            ], 422);
        }

        $identity = $request->attributes->get('identity');
        $validated = $validator->validated();

        // إنشاء أو تحديث العميل
        $client = null;
        if ($identity) {
            $client = Client::where('identity_id', $identity->id)->first();
        }

        if (!$client) {
            $client = Client::where('phone', $validated['phone'])->first();
        }

        $clientData = array_merge($validated, [
            'lead_source' => 'website',
            'lead_status' => $client ? $client->lead_status : 'new',
            'last_contact_at' => now(),
            'notes' => 'سجل عبر المستشار العقاري الذكي التفاعلي.',
        ]);

        if ($identity) {
            $clientData['identity_id'] = $identity->id;
        }

        if ($client) {
            $client->update($clientData);
        } else {
            $client = Client::create($clientData);
        }

        $customAnswers = $request->input('custom_answers', []);
        $metadata = array_merge([
            'purpose' => $client->purpose,
            'unit_type' => $client->unit_type,
            'budget' => $client->budget,
            'project_or_city' => $client->project_or_city,
            'payment_method' => $client->payment_method,
        ], $customAnswers);

        // تدوين الحدث السلوكي
        UserBehavior::create([
            'identity_id' => $identity?->id,
            'client_id' => $client->id,
            'event_type' => 'quiz_complete',
            'page_url' => $request->header('referer', '/'),
            'page_title' => 'المستشار العقاري الذكي',
            'metadata' => $metadata,
            'device' => $this->detectDevice($request->userAgent()),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // تدوين في سجل العميل
        ClientHistory::create([
            'client_id' => $client->id,
            'type' => 'interest_registered',
            'status' => 'completed',
            'title' => 'إكمال نموذج المستشار العقاري الذكي',
            'description' => 'حدد رغبته في ' . ($client->purpose ?? 'وحدة') . ' بميزانية ' . ($client->budget ?? 'محددة') . (!empty($customAnswers) ? ' | إجابات إضافية: ' . json_encode($customAnswers, JSON_UNESCAPED_UNICODE) : ''),
            'priority' => 'high',
            'created_by' => 'Interactive Quiz',
            'origin' => 'Website Concierge',
        ]);

        // جلب المشاريع المرشحة المتطابقة
        $matchingProjects = Project::where('is_active', true)
            ->when($client->project_or_city, function ($q, $loc) {
                $q->where(function ($sub) use ($loc) {
                    $sub->where('name_ar', 'like', "%{$loc}%")
                        ->orWhere('location_ar', 'like', "%{$loc}%")
                        ->orWhere('name_en', 'like', "%{$loc}%");
                });
            })
            ->take(3)
            ->get(['id', 'name_ar', 'name_en', 'location_ar', 'price_budget', 'image']);

        return response()->json([
            'success' => true,
            'client_id' => $client->id,
            'message' => 'تم حفظ اختياراتك بنجاح! يسعدنا تقديم ترشيحاتنا المناسبة لك.',
            'matching_projects' => $matchingProjects,
        ]);
    }

    /**
     * طلب استفسار سريع / حجز عبر واتساب أو تحميل بروشور من صفحة المشروع
     */
    public function quickInquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'project_id' => 'nullable|exists:projects,id',
            'unit_type' => 'nullable|string|max:255',
            'inquiry_type' => 'required|in:whatsapp,brochure,callback,booking',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $identity = $request->attributes->get('identity');
        $validated = $validator->validated();

        $project = !empty($validated['project_id'])
            ? Project::find($validated['project_id'])
            : null;

        // إنشاء أو تحديث العميل
        $client = null;
        if ($identity) {
            $client = Client::where('identity_id', $identity->id)->first();
        }
        if (!$client) {
            $client = Client::where('phone', $validated['phone'])->first();
        }

        $clientData = [
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'project_or_city' => $project?->name_ar ?? $client?->project_or_city,
            'lead_source' => 'website',
            'lead_status' => $client ? $client->lead_status : 'new',
            'last_contact_at' => now(),
        ];

        if ($identity) {
            $clientData['identity_id'] = $identity->id;
        }

        if ($client) {
            $client->update($clientData);
        } else {
            $client = Client::create($clientData);
        }

        $eventType = match ($validated['inquiry_type']) {
            'brochure' => 'brochure_download',
            'whatsapp', 'booking' => 'whatsapp_click',
            default => 'consultation_request',
        };

        // تدوين الحدث السلوكي
        UserBehavior::create([
            'identity_id' => $identity?->id,
            'client_id' => $client->id,
            'project_id' => $project?->id,
            'event_type' => $eventType,
            'page_url' => $request->header('referer', '/'),
            'page_title' => $project?->name_ar ?? 'طلب سريع',
            'metadata' => [
                'unit_type' => $validated['unit_type'] ?? null,
                'inquiry_type' => $validated['inquiry_type'],
            ],
            'device' => $this->detectDevice($request->userAgent()),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // تدوين تاريخ CRM
        $historyType = $validated['inquiry_type'] === 'whatsapp' ? 'whatsapp' : 'interest_registered';
        ClientHistory::create([
            'client_id' => $client->id,
            'type' => $historyType,
            'status' => 'completed',
            'title' => 'طلب ' . ($validated['inquiry_type'] === 'brochure' ? 'كتالوج' : 'حجز ومعاينة') . ' لمشروع ' . ($project?->name_ar ?? 'عام'),
            'description' => 'نوع الوحدة المطلوبة: ' . ($validated['unit_type'] ?? 'غير محددة'),
            'priority' => 'high',
            'created_by' => 'Quick Action Form',
            'origin' => 'Project Page',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل طلبك بنجاح!',
            'client_id' => $client->id,
        ]);
    }

    private function detectDevice(?string $userAgent): string
    {
        if (!$userAgent) {
            return 'desktop';
        }
        $ua = strtolower($userAgent);
        if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
            return 'tablet';
        }
        if (str_contains($ua, 'mobile') || str_contains($ua, 'android') || str_contains($ua, 'iphone')) {
            return 'mobile';
        }
        return 'desktop';
    }
}
