<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    /**
     * تعريف جميع أصول ووسائط المنصة القابلة للإدارة
     */
    public static function assetDefinitions(): array
    {
        return [
            'hero' => [
                'title' => 'فيديوهات وبوسترات قسم الهيرو الرئيسي (Main Hero)',
                'icon' => 'fa-solid fa-play',
                'description' => 'التحكم بالفيديوهات السينمائية والبوسترات الخاصة بالهيدر الرئيسي على أجهزة الديسكتوب والموبايل.',
                'items' => [
                    [
                        'key' => 'hero_desktop_video',
                        'label' => 'فيديو سطح المكتب (Desktop Video)',
                        'type' => 'video',
                        'default' => 'videos/d_hero.mp4',
                        'help' => 'ملف MP4 أو WebM أو رابط فيديو خارجي مباشر عالي الدقة لشاشات الكمبيوتر.',
                    ],
                    [
                        'key' => 'hero_desktop_poster',
                        'label' => 'بوستر فيديو سطح المكتب (Desktop Poster)',
                        'type' => 'image',
                        'default' => 'images/d_hero-poster.webp',
                        'help' => 'صورة تظهر فوراً قبل بدء تشغيل الفيديو لتوفير تجربة مستخدم سريعة وسلسة.',
                    ],
                    [
                        'key' => 'hero_mobile_video',
                        'label' => 'فيديو الموبايل (Mobile Video)',
                        'type' => 'video',
                        'default' => 'videos/m_hero.mp4',
                        'help' => 'فيديو عمودي أو مخصص لشاشات الهواتف الذكية بحجم خفيف.',
                    ],
                    [
                        'key' => 'hero_mobile_poster',
                        'label' => 'بوستر فيديو الموبايل (Mobile Poster)',
                        'type' => 'image',
                        'default' => 'images/d_hero-poster.webp',
                        'help' => 'صورة البوستر السريعة لشاشات الموبايل.',
                    ],
                ]
            ],
            'hero2' => [
                'title' => 'فيديوهات قسم التحفة المعمارية (Focused Masterpiece)',
                'icon' => 'fa-solid fa-gem',
                'description' => 'الوسائط الخاصة بقسم المشروع البارز أو التحفة المعمارية على الصفحة الرئيسية.',
                'items' => [
                    [
                        'key' => 'hero2_desktop_video',
                        'label' => 'فيديو التحفة المعمارية - ديسكتوب',
                        'type' => 'video',
                        'default' => 'videos/d_hero2.mp4',
                        'help' => 'الفيديو الأفقي للقسم المميز على أجهزة الكمبيوتر.',
                    ],
                    [
                        'key' => 'hero2_desktop_poster',
                        'label' => 'بوستر التحفة المعمارية - ديسكتوب',
                        'type' => 'image',
                        'default' => 'images/d_hero-poster.webp',
                        'help' => 'صورة البوستر للشاشات الكبيرة.',
                    ],
                    [
                        'key' => 'hero2_mobile_video',
                        'label' => 'فيديو التحفة المعمارية - موبايل',
                        'type' => 'video',
                        'default' => 'videos/m_hero2.mp4',
                        'help' => 'فيديو مخصص للهواتف المحمولة.',
                    ],
                    [
                        'key' => 'hero2_mobile_poster',
                        'label' => 'بوستر التحفة المعمارية - موبايل',
                        'type' => 'image',
                        'default' => 'images/d_hero-poster.webp',
                        'help' => 'صورة البوستر للموبايل.',
                    ],
                ]
            ],
            'legacy' => [
                'title' => 'قسم الإرث والرؤية وقادة المجموعة (Visionaries & Legacy)',
                'icon' => 'fa-solid fa-crown',
                'description' => 'فيديو خلفية قسم تاريخ الشركة والريادة وصور قيادات مجموعة البرلسي.',
                'items' => [
                    [
                        'key' => 'legacy_video',
                        'label' => 'فيديو خلفية قسم الإرث (Legacy Background Video)',
                        'type' => 'video',
                        'default' => 'videos/d_hero3.mp4',
                        'help' => 'الفيديو السينمائي لخلفية قسم قصة وتاريخ مجموعة البرلسي.',
                    ],
                    [
                        'key' => 'founder_ghanem_image',
                        'label' => 'صورة المؤسس - أ. غانم البرلسي',
                        'type' => 'image',
                        'default' => 'home/ghanem.png',
                        'help' => 'صورة واضحة بخلفية مفرغة (PNG أو WebP).',
                    ],
                    [
                        'key' => 'founder_salah_image',
                        'label' => 'صورة المؤسس - م. صلاح البرلسي',
                        'type' => 'image',
                        'default' => 'home/salah.png',
                        'help' => 'صورة واضحة بخلفية مفرغة (PNG أو WebP).',
                    ],
                ]
            ],
            'profile' => [
                'title' => 'خلفية الملف الشخصي للعميل (Profile Background)',
                'icon' => 'fa-solid fa-id-badge',
                'description' => 'فيديو خلفية صفحة ملف العميل وكارت الـ VIP.',
                'items' => [
                    [
                        'key' => 'profile_video',
                        'label' => 'فيديو خلفية الملف الشخصي',
                        'type' => 'video',
                        'default' => 'home/base_video_desktop.mp4',
                        'help' => 'الفيديو الجمالي الهادئ المعروض خلف بطاقة العميل.',
                    ],
                ]
            ],
            'brand' => [
                'title' => 'الهوية البصرية والعلامة التجارية (Branding & Identity)',
                'icon' => 'fa-solid fa-palette',
                'description' => 'الشعارات الرسمية، أيقونة المتصفح، ومعلومات التواصل الفوري.',
                'items' => [
                    [
                        'key' => 'site_logo',
                        'label' => 'شعار المنصة الرئيسي (Navbar Logo)',
                        'type' => 'image',
                        'default' => 'albrolosy_logo.png',
                        'help' => 'شعار مجموعة البرلسي العقارية عالي الدقة (PNG أو SVG أو WebP).',
                    ],
                    [
                        'key' => 'site_favicon',
                        'label' => 'أيقونة المتصفح (Favicon)',
                        'type' => 'image',
                        'default' => 'favicon.png',
                        'help' => 'الأيقونة التي تظهر في شريط المتصفح وجوار عنوان الموقع.',
                    ],
                    [
                        'key' => 'booking_whatsapp_number',
                        'label' => 'رقم الواتساب الموحد لحجز المشاريع والاستفسارات',
                        'type' => 'text',
                        'default' => '201032550422',
                        'help' => 'الرقم بالصيغة الدولية بدون مسافات أو علامة + (مثال: 201032550422).',
                    ],
                ]
            ],
        ];
    }

    public function index()
    {
        $sections = self::assetDefinitions();

        // تجهيز القيم الحالية وروابط العرض
        foreach ($sections as $secKey => &$section) {
            foreach ($section['items'] as &$item) {
                $savedValue = PlatformSetting::get($item['key']);
                $item['current_raw'] = $savedValue;
                $item['is_custom'] = !empty($savedValue);
                $item['effective_url'] = PlatformSetting::mediaUrl($item['key'], $item['default']);
            }
        }

        return view('admin.assets.index', compact('sections'));
    }

    public function update(Request $request)
    {
        $definitions = self::assetDefinitions();

        foreach ($definitions as $secKey => $section) {
            foreach ($section['items'] as $item) {
                $key = $item['key'];
                $label = $item['label'];
                $type = $item['type'];

                // 1. هل تم رفع ملف جديد؟
                if ($request->hasFile("file_{$key}")) {
                    $file = $request->file("file_{$key}");
                    
                    if ($type === 'video') {
                        $request->validate([
                            "file_{$key}" => 'file|mimes:mp4,webm,mov,ogg|max:102400', // حتى 100 ميجا
                        ]);
                    } elseif ($type === 'image') {
                        $request->validate([
                            "file_{$key}" => 'file|image|mimes:png,jpg,jpeg,webp,svg,gif,ico|max:20480', // حتى 20 ميجا
                        ]);
                    }

                    $ext = $file->getClientOriginalExtension();
                    $filename = "{$key}_" . Str::random(10) . ".{$ext}";
                    $storedPath = $file->storeAs('assets/' . $secKey, $filename, 'public');

                    PlatformSetting::set($key, 'storage/' . $storedPath, $label, $secKey);
                }
                // 2. أو هل تم إدخال رابط مباشر / نص؟
                elseif ($request->has("url_{$key}")) {
                    $url = trim($request->input("url_{$key}"));
                    if (!empty($url)) {
                        PlatformSetting::set($key, $url, $label, $secKey);
                    }
                }
            }
        }

        Artisan::call('view:clear');

        return redirect()->route('admin.assets.index')
            ->with('success', 'تم حفظ وتحديث وسائط وهوية المنصة بنجاح!');
    }

    public function reset(Request $request, string $key)
    {
        $setting = PlatformSetting::where('key', $key)->first();
        if ($setting) {
            // لو كان ملف مرفوع محلياً في الـ storage نحذفه للتنظيف
            if (str_starts_with($setting->value, 'storage/')) {
                $relativePath = str_replace('storage/', '', $setting->value);
                Storage::disk('public')->delete($relativePath);
            }
            $setting->delete();
        }

        Artisan::call('view:clear');

        return redirect()->route('admin.assets.index')
            ->with('success', 'تمت استعادة الأصل الافتراضي بنجاح!');
    }
}
