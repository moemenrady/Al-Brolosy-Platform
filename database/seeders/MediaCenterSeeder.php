<?php

namespace Database\Seeders;

use App\Models\MediaCategory;
use App\Models\MediaPost;
use Illuminate\Database\Seeder;

class MediaCenterSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $news = MediaCategory::create([
            'name_ar' => 'أخبار الشركة',
            'name_en' => 'Company News',
        ]);

        $projects = MediaCategory::create([
            'name_ar' => 'تحديثات المشروعات',
            'name_en' => 'Projects Updates',
        ]);

        $events = MediaCategory::create([
            'name_ar' => 'الفعاليات',
            'name_en' => 'Events',
        ]);

        $articles = MediaCategory::create([
            'name_ar' => 'مقالات عقارية',
            'name_en' => 'Real Estate Articles',
        ]);

        $csr = MediaCategory::create([
            'name_ar' => 'المسؤولية المجتمعية',
            'name_en' => 'Corporate Social Responsibility',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Post 1
        |--------------------------------------------------------------------------
        */

        $post1 = MediaPost::create([
            'media_category_id' => $news->id,
            'title_ar' => 'البرلسي للتطوير العقاري تعلن إطلاق مرحلة جديدة من مشروعاتها',
            'title_en' => 'Al Brolosy Development Announces a New Phase of Its Projects',
            'short_description_ar' => 'إطلاق مرحلة جديدة تضم وحدات متنوعة بمواصفات حديثة ومواقع استراتيجية.',
            'short_description_en' => 'Launching a new phase featuring modern units in strategic locations.',
            'content_ar' => 'أعلنت شركة البرلسي للتطوير العقاري عن بدء مرحلة جديدة من مشروعاتها لتلبية الطلب المتزايد على الوحدات السكنية والاستثمارية.',
            'content_en' => 'Al Brolosy Development announced the launch of a new phase of its projects to meet the increasing demand for residential and investment properties.',
            'cover_image' => 'media1.png',
            'published_at' => now()->subDays(15),
        ]);

        $post1->contents()->createMany([
            [
                'type' => 'text',
                'content_ar' => 'تأتي هذه المرحلة ضمن خطة الشركة للتوسع وتقديم مشروعات ذات جودة عالية.',
                'content_en' => 'This phase comes as part of the company expansion strategy and commitment to high-quality developments.',
                'sort_order' => 1,
            ],
            [
                'type' => 'image',
                'media_url' => 'media1-1.png',
                'sort_order' => 2,
            ],
            [
                'type' => 'image',
                'media_url' => 'media1-2.png',
                'sort_order' => 3,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Post 2
        |--------------------------------------------------------------------------
        */

        $post2 = MediaPost::create([
            'media_category_id' => $projects->id,
            'title_ar' => 'استمرار أعمال الإنشاءات وفق الجدول الزمن المحدد',
            'title_en' => 'Construction Progress Continues According to Schedule',
            'short_description_ar' => 'تحقيق نسب إنجاز متقدمة في عدد من مشروعات الشركة.',
            'short_description_en' => 'Advanced progress rates have been achieved across several projects.',
            'content_ar' => 'تواصل شركة البرلسي للتطوير العقاري تنفيذ أعمال الإنشاءات مع الالتزام بأعلى معايير الجودة.',
            'content_en' => 'Al Brolosy Development continues construction works while maintaining the highest quality standards.',
            'cover_image' => 'media2.png',
            'published_at' => now()->subDays(8),
        ]);

        $post2->contents()->createMany([
            [
                'type' => 'text',
                'content_ar' => 'تشهد مواقع المشروعات تقدمًا ملحوظًا بما يعكس التزام الشركة بتسليم الوحدات في المواعيد المحددة.',
                'content_en' => 'Project sites are witnessing remarkable progress, reflecting the company commitment to timely delivery.',
                'sort_order' => 1,
            ],
            [
                'type' => 'image',
                'media_url' => 'media2-1.png',
                'sort_order' => 2,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Post 3
        |--------------------------------------------------------------------------
        */

        $post3 = MediaPost::create([
            'media_category_id' => $events->id,
            'title_ar' => 'مشاركة البرلسي للتطوير العقاري في معرض عقارات مصر',
            'title_en' => 'Al Brolosy Development Participates in Egypt Real Estate Expo',
            'short_description_ar' => 'استعراض أحدث المشروعات والفرص الاستثمارية خلال المعرض.',
            'short_description_en' => 'Showcasing the latest projects and investment opportunities.',
            'content_ar' => 'شاركت الشركة في معرض عقارات مصر بهدف تعزيز التواصل مع العملاء والمستثمرين.',
            'content_en' => 'The company participated in Egypt Real Estate Expo to strengthen communication with clients and investors.',
            'cover_image' => 'media3.png',
            'published_at' => now()->subDays(5),
        ]);

        $post3->contents()->createMany([
            [
                'type' => 'text',
                'content_ar' => 'شهد جناح الشركة إقبالاً كبيراً من الزوار المهتمين بالاستثمار العقاري.',
                'content_en' => 'The company pavilion attracted significant interest from real estate investors.',
                'sort_order' => 1,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Post 4
        |--------------------------------------------------------------------------
        */

        $post4 = MediaPost::create([
            'media_category_id' => $articles->id,
            'title_ar' => '5 عوامل تساعدك على اختيار العقار المناسب للاستثمار',
            'title_en' => '5 Factors to Help You Choose the Right Property for Investment',
            'short_description_ar' => 'تعرف على أهم المعايير التي يجب مراعاتها قبل اتخاذ قرار الشراء.',
            'short_description_en' => 'Learn the most important criteria before making your purchase decision.',
            'content_ar' => 'يعد الموقع والخدمات والعائد الاستثماري من أهم العوامل المؤثرة في اختيار العقار المناسب.',
            'content_en' => 'Location, services, and investment return are among the key factors when selecting a property.',
            'cover_image' => 'media4.png',
            'published_at' => now()->subDays(3),
        ]);

        $post4->contents()->createMany([
            [
                'type' => 'text',
                'content_ar' => '1- الموقع الاستراتيجي.',
                'content_en' => '1- Strategic location.',
                'sort_order' => 1,
            ],
            [
                'type' => 'text',
                'content_ar' => '2- جودة التشطيبات والخدمات.',
                'content_en' => '2- Quality of finishing and services.',
                'sort_order' => 2,
            ],
            [
                'type' => 'text',
                'content_ar' => '3- العائد الاستثماري المتوقع.',
                'content_en' => '3- Expected investment return.',
                'sort_order' => 3,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Post 5
        |--------------------------------------------------------------------------
        */

        $post5 = MediaPost::create([
            'media_category_id' => $csr->id,
            'title_ar' => 'البرلسي للتطوير العقاري تدعم المبادرات المجتمعية',
            'title_en' => 'Al Brolosy Development Supports Community Initiatives',
            'short_description_ar' => 'ضمن مسؤوليتها المجتمعية تساهم الشركة في دعم المبادرات التنموية.',
            'short_description_en' => 'As part of its social responsibility, the company contributes to development initiatives.',
            'content_ar' => 'تحرص الشركة على دعم المبادرات التي تهدف إلى تنمية المجتمع وتعزيز جودة الحياة.',
            'content_en' => 'The company is committed to supporting initiatives aimed at community development and improving quality of life.',
            'cover_image' => 'media5.png',
            'published_at' => now()->subDay(),
        ]);

        $post5->contents()->createMany([
            [
                'type' => 'text',
                'content_ar' => 'تؤمن الشركة بأن النجاح الحقيقي يرتبط بالمساهمة الإيجابية في المجتمع.',
                'content_en' => 'The company believes that true success is linked to creating a positive impact on society.',
                'sort_order' => 1,
            ],
        ]);
    }
}
