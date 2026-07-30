<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Client;
use App\Models\UserSetting;
use App\Services\FileUploadService;
use Exception;
use Illuminate\Support\Facades\Auth;

class ClientInterestController extends Controller
{

    public function index(Request $request)
    {
        // بناء الاستعلام مع العلاقات لتحسين الأداء وتجنب N+1 Problem
        $query = Client::with(['assignedEmployee', 'activeSmartCard', 'histories.employee']);

        // فلاتر البحث السريعة للـ CRM
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "\%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('lead_status', $request->status);
        }

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        $clients = $query->latest()->paginate(15)->appends($request->query());

        // حساب إحصائيات سريعة لبطاقات العدادات أعلى الصفحة
        $stats = [
            'total' => Client::count(),
            'new' => Client::where('lead_status', 'new')->count(),
            'negotiation' => Client::where('lead_status', 'negotiation')->count(),
            'won' => Client::where('lead_status', 'won')->count(),
        ];

        return view('admin.clients.index', compact('clients', 'stats'));
    }
    /**
     * استقبال وحفظ سجل الاهتمام وربط الـ Config والـ Identity بذكاء شديد
     */
    public function store(Request $request)
    {
        // 1. التحقق من صحة الحقول المدخلة ومطابقتها التامة للـ Migrations الحالية
        $validator = Validator::make($request->all(), [

            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',

            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'governorate' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',

            'marital_status' => 'nullable|in:single,married,divorced,widowed',

            'family_size' => 'nullable|in:1,2-3,4-5,6+',

            'purpose' => 'nullable|in:residential,investment,summer,clinic,office,commercial_shop',

            'unit_type' => 'nullable|in:apartment,villa,townhouse,twinhouse,duplex,penthouse,studio,chalet,clinic,office,shop',

            'project_or_city' => 'nullable|string|max:255',

            'required_area' => 'nullable|integer|min:1',

            'bedrooms' => 'nullable|integer|min:0|max:20',

            'budget' => 'nullable|in:lt_2m,2_4m,4_6m,6_10m,10_20m,gt_20m',

            'payment_method' => 'nullable|in:cash,installments,either',

            'expected_down_payment' => 'nullable|numeric|min:0',

            'purchase_time' => 'nullable|in:immediately,3_months,6_months,1_year,more_than_year',

            'preferred_contact' => 'nullable|in:call,whatsapp,email',

            'contact_time' => 'nullable|in:morning,afternoon,evening,anytime',

            'source' => 'nullable|string|max:255',

            'lead_source' => 'nullable|in:facebook,instagram,google,tiktok,website,whatsapp,referral,broker,walk_in,other',

            'agree_marketing' => 'nullable|boolean',

            'notes' => 'nullable|string',

            'theme' => 'required|in:light,dark',

            'lang' => 'required|in:ar,en',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
                'message' => 'البيانات المرسلة غير صالحة.'
            ], 422);
        }

        try {
            // 2. جلب الهوية المستخرجة بواسطة الـ Middleware الخاص بك (IdentifyUser)
            // حيث قمت بتخزينها باستخدام app()->instance('identity', $identity);
            $identity = $request->attributes->get('identity');

            if (!$identity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Identity not found.'
                ], 500);
            }


            // 3. تحديث بيانات الميتا الخاصة بالهوية بشكل ديناميكي (IP والـ User Agent) في حال تغيرت
            $identity->update([
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // 4. إنشاء أو تحديث سجل العميل المرتبط بهذه الهوية (كل هوية لها ملف اهتمام عميل واحد)
            $clientData = $validator->validated();
            $oldClient = Client::where('identity_id', $identity->id)->first();

            if ($request->hasFile('photo')) {

                $clientData['photo'] = FileUploadService::upload(
                    file: $request->file('photo'),
                    folder: 'images/clients',
                    oldFile: $oldClient?->photo
                );
            } elseif ($oldClient) {

                $clientData['photo'] = $oldClient->photo;
            }
            $clientData['identity_id'] = $identity->id;
            // تحويل القيمة المرسلة للموافقة التسويقية
            $clientData['agree_marketing'] = $request->input('agree_marketing', 0) == 1;

            $client = Client::updateOrCreate(

                [
                    'identity_id' => $identity->id
                ],

                $clientData

            );

            // 5. حفظ وتحديث إعدادات التهيئة (الكونفيج - اللغات والثيم) المفضلة للعميل الحالي
            UserSetting::updateOrCreate(
                ['identity_id' => $identity->id],
                [
                    'theme' => $request->input('theme', 'dark'),
                    'lang'  => $request->input('lang', 'ar')
                ]
            );

            // 6. إرجاع استجابة سينمائية سريعة تؤكد الحفظ والربط بنجاح سواء كان مستخدم أو ضيف
            return response()->json([
                'success' => true,
                'message' => 'Registered successfully.',
                'type'    => $identity->user_id ? 'Authenticated User' : 'Guest Visitor',
                'data'    => [
                    'client_id'   => $client->id,
                    'identity_id' => $identity->id
                ]
            ], 200);
        } catch (Exception $e) {
            // معالجة استثنائية لأي أخطاء تقنية غير متوقعة في السيرفر
            return response()->json([
                'success' => false,
                'message' => 'خطأ داخلي في الخادم: ' . $e->getMessage()
            ], 500);
        }
    }
    public function show(Request $request)
    {
        $identity = $request->attributes->get('identity');

        $query = Client::with([
            'activeSmartCard',
            'histories' => fn($q) => $q->where('visible_to_client', true)->latest()
        ]);

        if ($identity) {
            $query->where('identity_id', $identity->id);
        } elseif (Auth::check()) {

            $user = Auth::user();

            $query->where(function ($q) use ($user) {

                if ($user->phone) {
                    $q->where('phone', $user->phone);
                }

                if ($user->email) {
                    $q->orWhere('email', $user->email);
                }
            });
        } else {
            abort(403);
        }

        $client = $query->firstOrFail();

        return view('clients.show', compact('client'));
    }
}
