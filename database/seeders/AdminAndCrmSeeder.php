<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientHistory;
use App\Models\Consultation;
use App\Models\Identity;
use App\Models\Project;
use App\Models\ProjectUnit;
use App\Models\ProjectUnitType;
use App\Models\User;
use App\Models\UserBehavior;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAndCrmSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin & Sales Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@albrolosy.com'],
            [
                'name' => 'مدير النظام - مجموعة البرلسي',
                'password' => Hash::make('admin123456'),
                'role' => 'admin',
            ]
        );

        $sales = User::firstOrCreate(
            ['email' => 'sales@albrolosy.com'],
            [
                'name' => 'أحمد طارق (مسؤول مبيعات)',
                'password' => Hash::make('admin123456'),
                'role' => 'sales',
            ]
        );

        // 2. Ensure some projects have units
        $projects = Project::with('unitTypes')->get();
        foreach ($projects as $project) {
            if ($project->actualUnits()->count() === 0) {
                $unitTypes = $project->unitTypes;
                if ($unitTypes->isEmpty()) {
                    $unitType = ProjectUnitType::create([
                        'project_id' => $project->id,
                        'name_ar' => 'وحدات متميزة',
                        'name_en' => 'Premium Units',
                        'unit_type' => 'Residential',
                        'floor' => 'الأول',
                        'area' => 145,
                        'price_per_meter' => 48000,
                        'unit_price' => 6960000,
                        'finishing_type' => 'تشطيب فاخر',
                        'total_units' => 10,
                    ]);
                } else {
                    $unitType = $unitTypes->first();
                }

                ProjectUnit::create([
                    'project_id' => $project->id,
                    'project_unit_type_id' => $unitType->id,
                    'unit_number' => 'UNT-' . $project->id . '-101',
                    'area' => $unitType->area ?? 130,
                    'price_per_meter' => $unitType->price_per_meter ?? 45000,
                    'unit_price' => $unitType->unit_price ?? 5850000,
                    'status' => 'available',
                ]);

                ProjectUnit::create([
                    'project_id' => $project->id,
                    'project_unit_type_id' => $unitType->id,
                    'unit_number' => 'UNT-' . $project->id . '-102',
                    'area' => ($unitType->area ?? 130) + 25,
                    'price_per_meter' => $unitType->price_per_meter ?? 45000,
                    'unit_price' => (($unitType->area ?? 130) + 25) * ($unitType->price_per_meter ?? 45000),
                    'status' => 'reserved',
                ]);

                ProjectUnit::create([
                    'project_id' => $project->id,
                    'project_unit_type_id' => $unitType->id,
                    'unit_number' => 'UNT-' . $project->id . '-103',
                    'area' => ($unitType->area ?? 130) + 50,
                    'price_per_meter' => $unitType->price_per_meter ?? 45000,
                    'unit_price' => (($unitType->area ?? 130) + 50) * ($unitType->price_per_meter ?? 45000),
                    'status' => 'sold',
                ]);
            }
        }

        // 3. Sample Clients / Leads across pipeline stages
        $sampleLeads = [
            [
                'full_name' => 'م. كريم المنشاوي',
                'phone' => '01012345678',
                'email' => 'kareem.elminshawy@gmail.com',
                'governorate' => 'القاهرة',
                'city' => 'التجمع الخامس',
                'purpose' => 'investment',
                'unit_type' => 'shop',
                'project_or_city' => 'القاهرة الجديدة',
                'required_area' => 85,
                'budget' => '6_10m',
                'payment_method' => 'installments',
                'expected_down_payment' => 1200000,
                'purchase_time' => '3_months',
                'lead_source' => 'website',
                'lead_status' => 'new',
                'notes' => 'مهتم بالمحلات التجارية ذات العائد الاستثماري المرتفع مع تسهيلات سداد.',
            ],
            [
                'full_name' => 'د. سارة عبد الرحمن',
                'phone' => '01198765432',
                'email' => 'dr.sara@hotmail.com',
                'governorate' => 'الجيزة',
                'city' => 'الشيخ زايد',
                'purpose' => 'clinic',
                'unit_type' => 'clinic',
                'project_or_city' => 'الشيخ زايد',
                'required_area' => 110,
                'budget' => '4_6m',
                'payment_method' => 'installments',
                'expected_down_payment' => 900000,
                'purchase_time' => 'immediately',
                'lead_source' => 'whatsapp',
                'lead_status' => 'qualified',
                'notes' => 'طبيبة جلدية تبحث عن عيادة في مبنى طبي متخصص مع استلام خلال عام.',
            ],
            [
                'full_name' => 'أ. حسام فؤاد الشريف',
                'phone' => '01234567890',
                'email' => 'hossam.fouad@yahoo.com',
                'governorate' => 'الإسكندرية',
                'city' => 'سموحة',
                'purpose' => 'residential',
                'unit_type' => 'duplex',
                'project_or_city' => 'العاصمة الإدارية',
                'required_area' => 220,
                'bedrooms' => 4,
                'budget' => '10_20m',
                'payment_method' => 'either',
                'expected_down_payment' => 3000000,
                'purchase_time' => 'immediately',
                'lead_source' => 'facebook',
                'lead_status' => 'negotiation',
                'notes' => 'تمت معاينة الموقع والعميل في مرحلة اختيار رقم الوحدة وجدول الأقساط.',
            ],
            [
                'full_name' => 'م. طارق عبد الحميد',
                'phone' => '01511223344',
                'email' => 'tarek.abdelhamid@outlook.com',
                'governorate' => 'القاهرة',
                'city' => 'المعادي',
                'purpose' => 'residential',
                'unit_type' => 'penthouse',
                'project_or_city' => 'سانا تاور',
                'required_area' => 280,
                'bedrooms' => 4,
                'budget' => 'gt_20m',
                'payment_method' => 'cash',
                'expected_down_payment' => 15000000,
                'purchase_time' => 'immediately',
                'lead_source' => 'referral',
                'lead_status' => 'won',
                'notes' => 'تم توقيع العقد النهائي وتسديد الدفعة الأولى بنجاح واستلام البطاقة الذكية VIP.',
            ],
            [
                'full_name' => 'أحمد عصام الدين',
                'phone' => '01055443322',
                'email' => 'ahmed.essam@gmail.com',
                'governorate' => 'الدقهلية',
                'city' => 'المنصورة',
                'purpose' => 'summer',
                'unit_type' => 'chalet',
                'project_or_city' => 'الساحل الشمالي',
                'required_area' => 120,
                'budget' => '4_6m',
                'payment_method' => 'installments',
                'purchase_time' => '6_months',
                'lead_source' => 'google',
                'lead_status' => 'contacted',
                'notes' => 'تم الاتصال هاتفياً ومراسلة تفاصيل الكتالوج على الواتساب.',
            ],
        ];

        foreach ($sampleLeads as $leadData) {
            if (Client::where('phone', $leadData['phone'])->exists()) {
                continue;
            }
            $identity = Identity::create([
                'guest_id' => (string) Str::uuid(),
                'ip' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0',
            ]);

            $leadData['identity_id'] = $identity->id;
            $leadData['assigned_employee_id'] = $sales->id;
            $leadData['agree_marketing'] = true;
            $leadData['last_contact_at'] = now()->subDays(rand(1, 10));
            $leadData['next_follow_up_at'] = now()->addDays(rand(1, 7));

            $client = Client::create($leadData);

            // History record
            ClientHistory::create([
                'client_id' => $client->id,
                'employee_id' => $sales->id,
                'type' => 'interest_registered',
                'status' => 'completed',
                'title' => 'تسجيل الاهتمام الأولي عبر المنصة',
                'description' => 'قام العميل بملء تفضيلاته العقارية لـ ' . ($client->purpose ?? 'العقار') . ' بميزانية ' . ($client->budget ?? 'محددة'),
                'priority' => 'high',
                'created_by' => 'System',
                'origin' => 'Website Concierge',
            ]);

            // Sample behavior for each lead
            UserBehavior::create([
                'identity_id' => $identity->id,
                'client_id' => $client->id,
                'project_id' => $projects->first()?->id,
                'event_type' => 'quiz_complete',
                'page_url' => '/',
                'page_title' => 'مستشارك العقاري الذكي',
                'metadata' => [
                    'purpose' => $client->purpose,
                    'budget' => $client->budget,
                    'unit_type' => $client->unit_type,
                ],
                'device' => 'mobile',
                'ip' => '127.0.0.1',
            ]);

            UserBehavior::create([
                'identity_id' => $identity->id,
                'client_id' => $client->id,
                'project_id' => $projects->first()?->id,
                'event_type' => 'whatsapp_click',
                'page_url' => '/projects/' . ($projects->first()?->id ?? 1),
                'page_title' => $projects->first()?->name_ar ?? 'مشروع',
                'metadata' => [
                    'unit_type' => $client->unit_type,
                    'action' => 'inquiry',
                ],
                'device' => 'mobile',
                'ip' => '127.0.0.1',
            ]);
        }

        // 4. Sample Consultations
        Consultation::firstOrCreate(
            ['phone' => '01099887766'],
            [
                'name' => 'محمود بدر',
                'preferred_contact' => 'whatsapp',
                'message' => 'أرغب في استشارة حول أفضل الفرص الاستثمارية في مشاريع التجمع الخامس.',
                'status' => 'new',
            ]
        );

        Consultation::firstOrCreate(
            ['phone' => '01122334455'],
            [
                'name' => 'نيرة المهدي',
                'preferred_contact' => 'phone',
                'message' => 'استفسار عن خطط السداد والأقساط المتوفرة في مشروع سانا تاور.',
                'status' => 'contacted',
                'contacted_at' => now()->subDay(),
            ]
        );
    }
}
