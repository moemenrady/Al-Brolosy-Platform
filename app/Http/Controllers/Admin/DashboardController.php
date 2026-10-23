<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Consultation;
use App\Models\Identity;
use App\Models\Project;
use App\Models\ProjectUnit;
use App\Models\SmartCard;
use App\Models\User;
use App\Models\UserBehavior;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. KPIs الأساسية
        $totalProjects = Project::count();
        $activeProjects = Project::where('is_active', true)->count();

        $totalUnits = ProjectUnit::count();
        $availableUnits = ProjectUnit::where('status', 'available')->count();
        $reservedUnits = ProjectUnit::where('status', 'reserved')->count();
        $soldUnits = ProjectUnit::where('status', 'sold')->count();

        $totalLeads = Client::count();
        $newLeads = Client::where('lead_status', 'new')->count();
        $qualifiedLeads = Client::where('lead_status', 'qualified')->count();
        $negotiationLeads = Client::where('lead_status', 'negotiation')->count();
        $wonDeals = Client::where('lead_status', 'won')->count();
        $lostDeals = Client::where('lead_status', 'lost')->count();

        $totalConsultations = Consultation::count();
        $newConsultations = Consultation::where('status', 'new')->count();

        $activeSmartCards = SmartCard::where('status', 'active')->count();
        $totalSmartCards = SmartCard::count();

        $totalVisitors = Identity::count();
        $totalBehaviors = UserBehavior::count();
        $whatsappClicks = UserBehavior::where('event_type', 'whatsapp_click')->count();
        $brochureDownloads = UserBehavior::where('event_type', 'brochure_download')->count();
        $quizCompletions = UserBehavior::where('event_type', 'quiz_complete')->count();

        // 2. توزيع مراحل العملاء (Sales Funnel)
        $funnelStages = [
            'جديد' => $newLeads,
            'تم التواصل' => Client::where('lead_status', 'contacted')->count(),
            'مؤهل جاد' => $qualifiedLeads,
            'تفاوض' => $negotiationLeads,
            'تعاقد وبيع' => $wonDeals,
            'ملغي' => $lostDeals,
        ];

        // 3. اتجاهات العملاء خلال آخر 6 شهور
        $monthlyLeads = [];
        $monthsLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthKey = $date->format('Y-m');
            $monthsLabels[] = $date->translatedFormat('F Y');
            $monthlyLeads[] = Client::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // 4. توزيع الميزانيات المطلوبة
        $budgetDistribution = [
            '< 2M' => Client::where('budget', 'lt_2m')->count(),
            '2-4M' => Client::where('budget', '2_4m')->count(),
            '4-6M' => Client::where('budget', '4_6m')->count(),
            '6-10M' => Client::where('budget', '6_10m')->count(),
            '10-20M' => Client::where('budget', '10_20m')->count(),
            '> 20M' => Client::where('budget', 'gt_20m')->count(),
        ];

        // 5. توزيع اهتمامات الأغراض (سكني، استثماري، ساحلي، تجاري، عيادة)
        $purposeDistribution = [
            'سكني' => Client::where('purpose', 'residential')->count(),
            'استثماري' => Client::where('purpose', 'investment')->count(),
            'مصيف وسياحي' => Client::where('purpose', 'summer')->count(),
            'تجاري / محل' => Client::where('purpose', 'commercial_shop')->count(),
            'طبي / عيادة' => Client::where('purpose', 'clinic')->count(),
            'إداري / مكتب' => Client::where('purpose', 'office')->count(),
        ];

        // 6. المشاريع الأكثر طلباً وتفاعلاً
        $topProjects = Project::withCount(['actualUnits', 'actualUnits as available_units_count' => function ($q) {
            $q->where('status', 'available');
        }])
            ->with('sector')
            ->orderBy('sort_order')
            ->take(5)
            ->get();

        // 7. آخر العملاء المسجلين (Live Feed)
        $recentClients = Client::with(['assignedEmployee', 'activeSmartCard'])
            ->latest()
            ->take(8)
            ->get();

        // 8. آخر التفاعلات السلوكية الحية في الموقع
        $recentBehaviors = UserBehavior::with(['project', 'client'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalProjects',
            'activeProjects',
            'totalUnits',
            'availableUnits',
            'reservedUnits',
            'soldUnits',
            'totalLeads',
            'newLeads',
            'qualifiedLeads',
            'negotiationLeads',
            'wonDeals',
            'lostDeals',
            'totalConsultations',
            'newConsultations',
            'activeSmartCards',
            'totalSmartCards',
            'totalVisitors',
            'totalBehaviors',
            'whatsappClicks',
            'brochureDownloads',
            'quizCompletions',
            'funnelStages',
            'monthsLabels',
            'monthlyLeads',
            'budgetDistribution',
            'purposeDistribution',
            'topProjects',
            'recentClients',
            'recentBehaviors'
        ));
    }
}
