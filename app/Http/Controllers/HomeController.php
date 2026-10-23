<?php

namespace App\Http\Controllers;

use App\Models\BannarItem;
use App\Models\Client;
use App\Models\Collection;
use App\Models\Job;
use App\Models\MediaCategory;
use App\Models\MediaPost;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Sector;
use App\Models\TeamImage;
use Illuminate\Http\Request;
use App\Services\ProjectSearchService;

class HomeController extends Controller
{
  public function lunching()
  {
    return view("lunching_soon");
  }
  public function index()
  {
    $currentLang = 'ar';
    $currentTheme = 'dark';
    if (auth()->check()) {
      // افترضنا أن identity_id بيساوي id المستخدم
      $userSetting = \App\Models\UserSetting::where('identity_id', auth()->id())->first();
      if ($userSetting) {
        $currentLang = $userSetting->lang ?? 'en';
        $currentTheme = $userSetting->theme ?? 'dark';
      }
    } else {
      // لو مش مسجل دخول، نقرأ من الـ Session أو الكوكيز (لو كنت عاملها)
      $currentLang = session('lang', 'en');
      $currentTheme = session('theme', 'dark');
    }

    // إجبار التطبيق على استخدام لغة المستخدم
    app()->setLocale($currentLang);

    // ==========================================
    // باقي الداتا بتاعتك زي ما هي بدون تغيير
    // ==========================================
    $offers = \App\Models\Offer::where('is_active', true)
      ->where(function ($query) {
        $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
      })->get();

    $sectors = \App\Models\Sector::orderBy('sort_order', 'asc')->get();

    $projects = \App\Models\Project::with(['unitTypes.units', 'paymentPlan', 'sector'])
      ->where('is_active', true)->orderBy('sort_order', 'asc')->get();

    $categories = \App\Models\MediaCategory::orderBy(app()->getLocale() == 'ar' ? 'name_ar' : 'name_en')->get();

    $posts = \App\Models\MediaPost::with('category')->latest('published_at')->take(9)->get();

    $jobs = \App\Models\Job::query()->where('is_active', true)
      ->orderByDesc('featured')->orderBy('sort_order')->take(6)->get(['id', 'title_ar', 'title_en', 'description_ar', 'description_en', 'location_ar', 'location_en', 'type', 'main_tasks_ar', 'main_tasks_en', 'required_skills_ar', 'required_skills_en', 'featured']);

    $teamImages = \App\Models\TeamImage::query()->where('is_active', true)
      ->orderBy('sort_order')->get(['id', 'image_path', 'title_ar', 'title_en', 'type']);
    $unitTypes = \App\Models\ProjectUnitType::query()
      ->select('unit_type')
      ->whereNotNull('unit_type')
      ->distinct()
      ->orderBy('unit_type')
      ->pluck('unit_type');
    // نمرر الـ Theme والـ Lang لصفحة الـ View

    $identity = request()->attributes->get('identity');

    $client = Client::where('identity_id', $identity->id)->with("histories")->first();
    $focusedProject = \App\Models\Project::with([
      'unitTypes.units',
      'paymentPlan',
      'sector',
      'images',
      'features',
      'tags',
    ])
      ->where('is_active', true)
      ->find(1);

    return view('home.index', compact(
      'offers',
      'sectors',
      'projects',
      'categories',
      'posts',
      'jobs',
      'teamImages',
      'currentLang',
      'currentTheme',
      'unitTypes',
      'client',
      'focusedProject'
    ));
  }


  public function search()
  {
    $sectors = Sector::query()
      ->where('is_active', true)
      ->orderBy('sort_order')
      ->get();

    $unitTypes = \App\Models\ProjectUnitType::query()
      ->select('unit_type')
      ->distinct()
      ->pluck('unit_type');

    return view('search.index', compact(
      'sectors',
      'unitTypes'
    ));
  }

  public function results(
    Request $request,
    ProjectSearchService $searchService
  ) {
    $projects = $searchService->search(
      $request->all()
    );

    return view(
      'search.results',
      compact('projects')
    );
  }
}
