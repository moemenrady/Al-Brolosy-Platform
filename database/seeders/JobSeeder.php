<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [

            [
                'title_ar' => 'مدير فرع',
                'title_en' => 'Branch Manager',

                'description_ar' => 'مسؤول عن إدارة وتشغيل الفرع بشكل يومي، وقيادة فريق المبيعات، ووضع وتنفيذ الخطط البيعية، ومتابعة الأداء لضمان تحقيق أهداف الشركة.',
                'description_en' => 'Responsible for the daily management and operation of the branch, leading the sales team, executing sales strategies, and ensuring business targets are achieved.',

                'location_ar' => 'المنصورة',
                'location_en' => 'Mansoura',

                'type' => 'full-time',

                'main_tasks_ar' => "• إدارة العمليات اليومية للفرع.\n• قيادة فريق العمل.\n• متابعة الأداء وتحقيق المستهدفات.\n• إعداد التقارير للإدارة.\n• تطوير جودة خدمة العملاء.",

                'main_tasks_en' => "• Manage daily branch operations.\n• Lead and motivate the sales team.\n• Monitor KPIs and sales targets.\n• Report branch performance.\n• Improve customer satisfaction.",

                'required_skills_ar' => "• خبرة لا تقل عن 5 سنوات.\n• مهارات قيادية.\n• إدارة فرق العمل.\n• القدرة على اتخاذ القرار.\n• مهارات تواصل عالية.",

                'required_skills_en' => "• 5+ years experience.\n• Leadership skills.\n• Team management.\n• Decision making.\n• Excellent communication skills.",

                'featured' => true,
                'sort_order' => 1,
            ],

            [
                'title_ar' => 'مستشار عقاري أول',
                'title_en' => 'Senior Property Consultant',

                'description_ar' => 'خبير مبيعات عقارية يمتلك خبرة قوية في إدارة العملاء، وبناء العلاقات، وتحقيق أعلى معدلات المبيعات والاستثمار.',
                'description_en' => 'Experienced real estate consultant with strong sales expertise, client management skills, and the ability to maximize investment opportunities.',

                'location_ar' => 'المنصورة',
                'location_en' => 'Mansoura',

                'type' => 'full-time',

                'main_tasks_ar' => "• إدارة العملاء الرئيسيين.\n• إغلاق الصفقات.\n• متابعة فريق المبيعات.\n• تقديم الاستشارات الاستثمارية.\n• تحقيق المستهدف الشهري.",

                'main_tasks_en' => "• Manage key clients.\n• Close property deals.\n• Mentor sales consultants.\n• Provide investment advice.\n• Achieve monthly targets.",

                'required_skills_ar' => "• خبرة بالمبيعات العقارية.\n• مهارات تفاوض.\n• إدارة علاقات العملاء.\n• العمل تحت الضغط.",

                'required_skills_en' => "• Real estate sales experience.\n• Negotiation skills.\n• CRM knowledge.\n• Ability to work under pressure.",

                'featured' => true,
                'sort_order' => 2,
            ],

            [
                'title_ar' => 'مستشار عقاري',
                'title_en' => 'Property Consultant',

                'description_ar' => 'مساعدة العملاء في اختيار أفضل الفرص العقارية، وتقديم الاستشارات ومتابعة عمليات البيع حتى إتمام التعاقد.',
                'description_en' => 'Assist clients in choosing the best investment opportunities and guide them through the entire sales process.',

                'location_ar' => 'المنصورة',
                'location_en' => 'Mansoura',

                'type' => 'full-time',

                'main_tasks_ar' => "• استقبال العملاء.\n• عرض المشروعات.\n• متابعة العملاء.\n• إتمام التعاقدات.",

                'main_tasks_en' => "• Meet clients.\n• Present projects.\n• Follow up prospects.\n• Complete sales contracts.",

                'required_skills_ar' => "• مهارات بيع.\n• تواصل ممتاز.\n• القدرة على الإقناع.",

                'required_skills_en' => "• Sales skills.\n• Strong communication.\n• Persuasion skills.",

                'featured' => false,
                'sort_order' => 3,
            ],

            [
                'title_ar' => 'مستشار مبيعات',
                'title_en' => 'Sales Advisor',

                'description_ar' => 'التواصل المباشر مع العملاء، وفهم احتياجاتهم، وتقديم الحلول العقارية المناسبة لتحقيق أعلى معدلات رضا العملاء والمبيعات.',
                'description_en' => 'Interact directly with clients, understand their needs, and recommend suitable real estate solutions.',

                'location_ar' => 'المنصورة',
                'location_en' => 'Mansoura',

                'type' => 'full-time',

                'main_tasks_ar' => "• الرد على العملاء.\n• تقديم الاستشارات.\n• متابعة العملاء.\n• تحقيق أهداف البيع.",

                'main_tasks_en' => "• Handle customer inquiries.\n• Recommend projects.\n• Follow up leads.\n• Achieve sales goals.",

                'required_skills_ar' => "• مهارات خدمة العملاء.\n• اللباقة.\n• الإقناع.\n• العمل ضمن فريق.",

                'required_skills_en' => "• Customer service.\n• Communication.\n• Persuasion.\n• Teamwork.",

                'featured' => false,
                'sort_order' => 4,
            ],

            [
                'title_ar' => 'قائد فريق',
                'title_en' => 'Team Leader',

                'description_ar' => 'قيادة وتحفيز فريق المبيعات، وتوزيع المهام، ومتابعة الأداء اليومي لضمان تحقيق الأهداف البيعية.',
                'description_en' => 'Lead, coach, and motivate the sales team while monitoring performance and achieving business targets.',

                'location_ar' => 'المنصورة',
                'location_en' => 'Mansoura',

                'type' => 'full-time',

                'main_tasks_ar' => "• إدارة الفريق.\n• التدريب.\n• متابعة الأداء.\n• إعداد التقارير.",

                'main_tasks_en' => "• Lead the team.\n• Coach members.\n• Monitor KPIs.\n• Report progress.",

                'required_skills_ar' => "• قيادة الفرق.\n• التحفيز.\n• حل المشكلات.\n• إدارة الوقت.",

                'required_skills_en' => "• Leadership.\n• Coaching.\n• Problem solving.\n• Time management.",

                'featured' => false,
                'sort_order' => 5,
            ],

            [
                'title_ar' => 'موظف استقبال',
                'title_en' => 'Receptionist',

                'description_ar' => 'استقبال العملاء والزوار، وتنظيم المواعيد، وتقديم الدعم الإداري لضمان تجربة احترافية داخل الشركة.',
                'description_en' => 'Welcome visitors, manage appointments, and provide administrative support while maintaining a professional environment.',

                'location_ar' => 'المنصورة',
                'location_en' => 'Mansoura',

                'type' => 'full-time',

                'main_tasks_ar' => "• استقبال العملاء.\n• الرد على المكالمات.\n• تنظيم المواعيد.\n• الأعمال الإدارية.",

                'main_tasks_en' => "• Welcome visitors.\n• Answer phone calls.\n• Schedule appointments.\n• Administrative tasks.",

                'required_skills_ar' => "• حسن المظهر.\n• اللباقة.\n• استخدام الحاسب.\n• مهارات التواصل.",

                'required_skills_en' => "• Professional appearance.\n• Communication skills.\n• Computer skills.\n• Organization.",

                'featured' => false,
                'sort_order' => 6,
            ],

        ];

        foreach ($jobs as $job) {
            Job::updateOrCreate(
                [
                    'title_en' => $job['title_en']
                ],
                $job
            );
        }
    }
}
