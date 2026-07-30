<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    public function run(): void
    {
        $sectors = [

            [
                'name_ar' => 'إداري',
                'name_en' => 'Administrative',
                'slug' => 'administrative',
                'description_ar' => 'مساحات إدارية بتصميم عصري يواكب بيئات الأعمال الحديثة.',
                'description_en' => 'Modern administrative spaces designed for contemporary business environments.',
                'image' => 'administrative.jpg',
                'cover_image' => 'administrative-cover.jpg',
            ],

            [
                'name_ar' => 'تجاري',
                'name_en' => 'Commercial',
                'slug' => 'commercial',
                'description_ar' => 'مشاريع تجارية متكاملة تجمع بين الموقع الاستراتيجي والعائد الاستثماري.',
                'description_en' => 'Integrated commercial projects combining strategic locations and high investment returns.',
                'image' => 'commercial.jpg',
                'cover_image' => 'commercial-cover.jpg',
            ],

            [
                'name_ar' => 'ترفيهي',
                'name_en' => 'Entertainment',
                'slug' => 'entertainment',
                'description_ar' => 'وجهات ترفيهية مبتكرة تقدم تجربة حياة استثنائية.',
                'description_en' => 'Innovative entertainment destinations delivering exceptional lifestyle experiences.',
                'image' => 'entertainment.jpg',
                'cover_image' => 'entertainment-cover.jpg',
            ],

            [
                'name_ar' => 'تعليمي',
                'name_en' => 'Educational',
                'slug' => 'educational',
                'description_ar' => 'مشاريع تعليمية تدعم بيئات التعلم الحديثة.',
                'description_en' => 'Educational developments supporting modern learning environments.',
                'image' => 'educational.jpg',
                'cover_image' => 'educational-cover.jpg',
            ],

            [
                'name_ar' => 'خدمي',
                'name_en' => 'Service',
                'slug' => 'service',
                'description_ar' => 'مشاريع خدمية متكاملة لدعم جودة الحياة.',
                'description_en' => 'Comprehensive service projects enhancing quality of life.',
                'image' => 'service.jpg',
                'cover_image' => 'service-cover.jpg',
            ],

            [
                'name_ar' => 'دمياط الجديدة',
                'name_en' => 'New Damietta',
                'slug' => 'new-damietta',
                'description_ar' => 'تنمية عمرانية حديثة في قلب دمياط الجديدة.',
                'description_en' => 'Modern urban development in the heart of New Damietta.',
                'image' => 'new-damietta.jpg',
                'cover_image' => 'new-damietta-cover.jpg',
            ],

            [
                'name_ar' => 'سكني',
                'name_en' => 'Residential',
                'slug' => 'residential',
                'description_ar' => 'مجتمعات سكنية متكاملة توفر الراحة والرفاهية.',
                'description_en' => 'Integrated residential communities offering comfort and luxury.',
                'image' => 'residential.jpg',
                'cover_image' => 'residential-cover.jpg',
            ],

            [
                'name_ar' => 'طبي',
                'name_en' => 'Medical',
                'slug' => 'medical',
                'description_ar' => 'مرافق طبية حديثة بمعايير عالمية.',
                'description_en' => 'Modern medical facilities with international standards.',
                'image' => 'medical.jpg',
                'cover_image' => 'medical-cover.jpg',
            ],

            [
                'name_ar' => 'فندقي',
                'name_en' => 'Hospitality',
                'slug' => 'hospitality',
                'description_ar' => 'مشاريع فندقية فاخرة بتجربة ضيافة استثنائية.',
                'description_en' => 'Luxury hospitality projects offering exceptional guest experiences.',
                'image' => 'hospitality.jpg',
                'cover_image' => 'hospitality-cover.jpg',
            ],
        ];

        foreach ($sectors as $index => $sector) {

            Sector::updateOrCreate(
                ['slug' => $sector['slug']],
                [
                    'name_ar' => $sector['name_ar'],
                    'name_en' => $sector['name_en'],

                    'description_ar' => $sector['description_ar'],
                    'description_en' => $sector['description_en'],

                    'image' => 'sectors/' . $sector['image'],
                    'cover_image' => 'sectors/covers/' . $sector['cover_image'],

                    'started_at' => 2001,

                    'sort_order' => $index + 1,

                    'is_active' => true,
                ]
            );
        }
    }
}
