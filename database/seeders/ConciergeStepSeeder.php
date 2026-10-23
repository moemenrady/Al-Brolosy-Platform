<?php

namespace Database\Seeders;

use App\Models\ConciergeStep;
use Illuminate\Database\Seeder;

class ConciergeStepSeeder extends Seeder
{
    public function run(): void
    {
        if (ConciergeStep::count() > 0) {
            return;
        }

        $steps = [
            [
                'step_number' => 1,
                'sort_order' => 1,
                'title_ar' => 'ما هو غرضك الأساسي من البحث؟',
                'title_en' => 'What is your primary property purpose?',
                'subtitle_ar' => 'اختر ما يناسب تطلعاتك لنرشح لك الفرص الأكثر دقة وربحية.',
                'subtitle_en' => 'Select what fits your vision so we match the best opportunities.',
                'step_type' => 'options_grid',
                'target_field' => 'purpose',
                'is_required' => true,
                'is_active' => true,
                'options' => [
                    [
                        'title_ar' => 'سكن فاخر',
                        'title_en' => 'Luxury Residence',
                        'value' => 'residential',
                        'icon' => '🏡',
                        'extra_values' => ['unit_type' => 'apartment'],
                    ],
                    [
                        'title_ar' => 'استثمار تجاري',
                        'title_en' => 'Commercial Investment',
                        'value' => 'investment',
                        'icon' => '📈',
                        'extra_values' => ['unit_type' => 'shop'],
                    ],
                    [
                        'title_ar' => 'عيادة طبية',
                        'title_en' => 'Medical Clinic',
                        'value' => 'clinic',
                        'icon' => '🩺',
                        'extra_values' => ['unit_type' => 'clinic'],
                    ],
                    [
                        'title_ar' => 'مقر إداري',
                        'title_en' => 'Administrative Office',
                        'value' => 'office',
                        'icon' => '💼',
                        'extra_values' => ['unit_type' => 'office'],
                    ],
                    [
                        'title_ar' => 'مصيف وساحلي',
                        'title_en' => 'Coastal & Summer',
                        'value' => 'summer',
                        'icon' => '🏖️',
                        'extra_values' => ['unit_type' => 'chalet'],
                    ],
                ],
            ],
            [
                'step_number' => 2,
                'sort_order' => 2,
                'title_ar' => 'أين تفضل موقع وحدتك القادمة؟',
                'title_en' => 'Where do you prefer your upcoming unit location?',
                'subtitle_ar' => 'نغطي أفضل المواقع الاستراتيجية الواعدة بأعلى عائد استثماري.',
                'subtitle_en' => 'Covering top strategic prime spots with highest ROI.',
                'step_type' => 'options_grid',
                'target_field' => 'project_or_city',
                'is_required' => true,
                'is_active' => true,
                'options' => [
                    [
                        'title_ar' => 'القاهرة الجديدة',
                        'title_en' => 'New Cairo',
                        'value' => 'القاهرة الجديدة',
                        'icon' => '🏙️',
                    ],
                    [
                        'title_ar' => 'الشيخ زايد',
                        'title_en' => 'Sheikh Zayed',
                        'value' => 'الشيخ زايد',
                        'icon' => '🌲',
                    ],
                    [
                        'title_ar' => 'العاصمة الإدارية',
                        'title_en' => 'New Capital',
                        'value' => 'العاصمة الإدارية',
                        'icon' => '🏛️',
                    ],
                    [
                        'title_ar' => 'الساحل الشمالي',
                        'title_en' => 'North Coast',
                        'value' => 'الساحل الشمالي',
                        'icon' => '🌊',
                    ],
                    [
                        'title_ar' => 'أبراج سانا تاور',
                        'title_en' => 'Sanaa Towers',
                        'value' => 'سانا تاور',
                        'icon' => '⭐',
                    ],
                ],
            ],
            [
                'step_number' => 3,
                'sort_order' => 3,
                'title_ar' => 'ما هي الميزانية المناسبة لك؟',
                'title_en' => 'What is your suitable budget range?',
                'subtitle_ar' => 'تسهيلات سداد مريحة بدون فوائد مع مرونة كاملة في الدفعات.',
                'subtitle_en' => 'Flexible interest-free payment terms tailored for you.',
                'step_type' => 'options_grid',
                'target_field' => 'budget',
                'is_required' => true,
                'is_active' => true,
                'options' => [
                    [
                        'title_ar' => '2 - 4 مليون',
                        'title_en' => '2 - 4 Million EGP',
                        'value' => '2_4m',
                        'icon' => '💵',
                    ],
                    [
                        'title_ar' => '4 - 6 مليون',
                        'title_en' => '4 - 6 Million EGP',
                        'value' => '4_6m',
                        'icon' => '💰',
                    ],
                    [
                        'title_ar' => '6 - 10 مليون',
                        'title_en' => '6 - 10 Million EGP',
                        'value' => '6_10m',
                        'icon' => '💎',
                    ],
                    [
                        'title_ar' => '10 - 20 مليون',
                        'title_en' => '10 - 20 Million EGP',
                        'value' => '10_20m',
                        'icon' => '👑',
                    ],
                    [
                        'title_ar' => 'أكثر من 20 مليون',
                        'title_en' => '+20 Million EGP',
                        'value' => 'gt_20m',
                        'icon' => '🏛️',
                    ],
                ],
            ],
            [
                'step_number' => 4,
                'sort_order' => 4,
                'title_ar' => 'وجدنا وحدات مطابقة لمواصفاتك تماماً!',
                'title_en' => 'We matched units tailored to your needs!',
                'subtitle_ar' => 'أدخل اسمك ورقم هاتفك لنرسل لك ملف ترشيحات الوحدات المتاحة فوراً.',
                'subtitle_en' => 'Enter your name and WhatsApp phone to receive the matched units catalog.',
                'step_type' => 'lead_form',
                'target_field' => 'contact_info',
                'is_required' => true,
                'is_active' => true,
                'options' => null,
            ],
        ];

        foreach ($steps as $step) {
            ConciergeStep::create($step);
        }
    }
}
