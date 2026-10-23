<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Identity;
use App\Models\Project;
use App\Models\UserBehavior;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // 1. إحصائيات عامة
        $totalVisitors = Identity::count();
        $totalLeads = Client::count();
        $totalEvents = UserBehavior::count();

        $whatsappClicks = UserBehavior::where('event_type', 'whatsapp_click')->count();
        $brochureDownloads = UserBehavior::where('event_type', 'brochure_download')->count();
        $quizCompletions = UserBehavior::where('event_type', 'quiz_complete')->count();
        $calculatorUses = UserBehavior::where('event_type', 'calculator_calc')->count();

        // 2. نسبة التحويل الإجمالية (Visitors to Leads)
        $conversionRate = $totalVisitors > 0
            ? round(($totalLeads / $totalVisitors) * 100, 1)
            : 0;

        // 3. المشاريع الأكثر مشاهدة وتفحصاً
        $projectViews = UserBehavior::whereNotNull('project_id')
            ->select('project_id', DB::raw('count(*) as views_count'))
            ->groupBy('project_id')
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        $projectIds = $projectViews->pluck('project_id');
        $projects = Project::whereIn('id', $projectIds)->get()->keyBy('id');

        $topViewedProjects = $projectViews->map(function ($item) use ($projects) {
            $project = $projects->get($item->project_id);
            return [
                'name' => $project ? $project->name_ar : 'مشروع #' . $item->project_id,
                'views' => $item->views_count,
            ];
        });

        // 4. تحليل الأجهزة المستخدمة في التصفح (Mobile vs Desktop)
        $deviceDistribution = [
            'هاتف محمول' => UserBehavior::where('device', 'mobile')->count(),
            'كمبيوتر مكتبي' => UserBehavior::where('device', 'desktop')->count(),
            'جهاز لوحي / تابلت' => UserBehavior::where('device', 'tablet')->count(),
        ];

        // 5. نشاط الزوار والتفاعلات خلال آخر 7 أيام
        $daysLabels = [];
        $dailyEvents = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $daysLabels[] = $date->translatedFormat('l d M');
            $dailyEvents[] = UserBehavior::whereDate('created_at', $date)->count();
        }

        // 6. عملاء ذوو تفاعل واهتمام مرتفع (High-Intent Leads)
        $highIntentLeads = Client::with(['behaviors', 'assignedEmployee'])
            ->withCount('behaviors')
            ->orderByDesc('behaviors_count')
            ->take(6)
            ->get();

        // 7. آخر سجل التفاعلات السلوكية الحية في الموقع
        $liveActivities = UserBehavior::with(['project', 'client', 'identity'])
            ->latest()
            ->take(20)
            ->get();

        return view('admin.analytics.index', compact(
            'totalVisitors',
            'totalLeads',
            'totalEvents',
            'conversionRate',
            'whatsappClicks',
            'brochureDownloads',
            'quizCompletions',
            'calculatorUses',
            'topViewedProjects',
            'deviceDistribution',
            'daysLabels',
            'dailyEvents',
            'highIntentLeads',
            'liveActivities'
        ));
    }

    /**
     * تصدير التقارير بصيغة CSV تدعم اللغة العربية في Excel تماماً
     */
    public function exportReport(Request $request): StreamedResponse
    {
        $query = Client::with(['assignedEmployee', 'activeSmartCard']);

        if ($request->filled('lead_status')) {
            $query->where('lead_status', $request->lead_status);
        }

        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }

        if ($request->filled('source')) {
            $query->where('lead_source', $request->source);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $clients = $query->latest()->get();

        $filename = 'تقرير_عملاء_البرلسي_' . date('Y-m-d_H-i') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function () use ($clients) {
            $file = fopen('php://output', 'w');

            // BOM للتعامل الصحيح مع اللغة العربية في Microsoft Excel
            fputs($file, "\xEF\xBB\xBF");

            // عناوين الأعمدة
            fputcsv($file, [
                'كود العميل',
                'اسم العميل',
                'رقم الهاتف',
                'البريد الإلكتروني',
                'المحافظة',
                'المدينة',
                'الغرض العقاري',
                'نوع الوحدة',
                'المشروع المستهدف',
                'الميزانية',
                'طريقة الدفع',
                'المقدم المتوقع',
                'وقت الشراء',
                'مصدر العميل',
                'حالة العميل (CRM)',
                'الموظف المسؤول',
                'تاريخ التسجيل',
            ]);

            foreach ($clients as $client) {
                fputcsv($file, [
                    $client->id,
                    $client->full_name,
                    $client->phone,
                    $client->email ?? '-',
                    $client->governorate ?? '-',
                    $client->city ?? '-',
                    $client->purpose ?? '-',
                    $client->unit_type ?? '-',
                    $client->project_or_city ?? '-',
                    $client->budget ?? '-',
                    $client->payment_method ?? '-',
                    $client->expected_down_payment ? number_format($client->expected_down_payment) . ' ج.م' : '-',
                    $client->purchase_time ?? '-',
                    $client->lead_source ?? '-',
                    $client->lead_status,
                    $client->assignedEmployee?->name ?? 'غير مسند',
                    $client->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }
}
