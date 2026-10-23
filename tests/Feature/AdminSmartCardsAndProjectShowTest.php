<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\PlatformSetting;
use App\Models\Project;
use App\Models\Sector;
use App\Models\SmartCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSmartCardsAndProjectShowTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Sector $sector;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->sector = Sector::create([
            'name_ar' => 'سكني',
            'name_en' => 'Residential',
            'slug' => 'residential',
            'image' => 'sectors/residential.jpg',
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }

    public function test_admin_can_access_project_create_page()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.projects.create'));

        $response->assertStatus(200);
        $response->assertSee('إضافة مشروع عقاري جديد');
        $response->assertSee('booking_phone');
    }

    public function test_admin_can_store_project_from_scratch_with_booking_phone_units_and_plans()
    {
        $data = [
            'sector_id' => $this->sector->id,
            'name_ar' => 'مشروع كمبوند النرجس الفاخر',
            'name_en' => 'Al Narges Luxury Compound',
            'price_budget' => 'يبدأ من 5,000,000 ج.م',
            'booking_phone' => '01011122233',
            'status' => 'launched',
            'delivery_time' => '2027',
            'sort_order' => 1,
            'is_active' => 1,
            'featured' => 1,
            'units' => [
                [
                    'unit_type' => 'شقة فاخرة',
                    'start_area' => '160 م²',
                    'floor' => 'الأول',
                    'price_per_meter' => '35,000 ج.م',
                    'unit_price' => '5,600,000 ج.م',
                    'finishing_type' => 'سوبر لوكس',
                ]
            ],
            'plans' => [
                [
                    'down_payment' => '10%',
                    'installment_years' => '8 سنوات',
                    'maintenance' => '8%',
                    'notes' => 'أقساط متساوية',
                ]
            ],
            'features' => [
                [
                    'title_ar' => 'حمامات سباحة خاصة',
                    'title_en' => 'Private Pools',
                    'value' => 'متوفرة',
                ]
            ],
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.projects.store'), $data);

        $response->assertRedirect(route('admin.projects.index'));

        $this->assertDatabaseHas('projects', [
            'name_ar' => 'مشروع كمبوند النرجس الفاخر',
            'booking_phone' => '01011122233',
        ]);

        $project = Project::where('name_ar', 'مشروع كمبوند النرجس الفاخر')->first();
        $this->assertEquals(1, $project->unitTypes()->count());
        $this->assertEquals(1, $project->paymentPlans()->count());
        $this->assertEquals(1, $project->features()->count());
    }

    public function test_admin_can_access_project_edit_page_and_update()
    {
        $project = Project::create([
            'sector_id' => $this->sector->id,
            'name_ar' => 'مشروع البرلسي بلازا',
            'name_en' => 'Albrolosy Plaza',
            'image' => 'projects/default.jpg',
            'booking_phone' => '01099988877',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.projects.edit', $project->id));
        $response->assertStatus(200);
        $response->assertSee('تعديل مشروع: مشروع البرلسي بلازا');
        $response->assertSee('01099988877');

        // Update project
        $updateData = [
            'sector_id' => $this->sector->id,
            'name_ar' => 'مشروع البرلسي بلازا المطور',
            'name_en' => 'Albrolosy Plaza Updated',
            'booking_phone' => '01055544433',
            'price_budget' => '6,000,000 ج.م',
            'status' => 'launched',
        ];

        $updateResponse = $this->actingAs($this->admin)->put(route('admin.projects.update', $project->id), $updateData);
        $updateResponse->assertRedirect(route('admin.projects.index'));

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name_ar' => 'مشروع البرلسي بلازا المطور',
            'booking_phone' => '01055544433',
        ]);
    }

    public function test_project_effective_booking_phone_falls_back_to_platform_setting()
    {
        PlatformSetting::set('booking_whatsapp_number', '201099999999');

        $projectWithoutPhone = Project::create([
            'sector_id' => $this->sector->id,
            'name_ar' => 'مشروع بدون رقم مخصص',
            'name_en' => 'Project Without Phone',
            'image' => 'projects/default.jpg',
            'booking_phone' => null,
            'is_active' => true,
        ]);

        $this->assertEquals('201099999999', $projectWithoutPhone->effective_booking_phone);

        $projectWithCustomPhone = Project::create([
            'sector_id' => $this->sector->id,
            'name_ar' => 'مشروع برقم مخصص',
            'name_en' => 'Project With Phone',
            'image' => 'projects/default.jpg',
            'booking_phone' => '01012345678',
            'is_active' => true,
        ]);

        $this->assertEquals('01012345678', $projectWithCustomPhone->effective_booking_phone);
    }

    public function test_frontend_project_show_page_renders_with_effective_booking_phone()
    {
        $project = Project::create([
            'sector_id' => $this->sector->id,
            'name_ar' => 'مشروع البرلسي لاكشري',
            'name_en' => 'Albrolosy Luxury',
            'image' => 'projects/default.jpg',
            'booking_phone' => '01032550422',
            'price_budget' => '7,000,000 ج.م',
            'is_active' => true,
        ]);

        $response = $this->get(route('projects.show', $project->id));

        $response->assertStatus(200);
        $response->assertSee('01032550422');
        $response->assertSee('sticky-booking-bar');
    }

    public function test_admin_can_view_smart_cards_and_assign_to_client()
    {
        $client = Client::create([
            'full_name' => 'الأستاذ عماد عبد الرحمن',
            'phone' => '01088776655',
            'email' => 'emad@example.com',
        ]);

        $card = SmartCard::create([
            'card_number' => 'ALB-VIP-99901',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.smart-cards'));
        $response->assertStatus(200);
        $response->assertSee('ALB-VIP-99901');

        // Assign and activate card for client
        $assignResponse = $this->actingAs($this->admin)->post(route('admin.smart-cards.assign'), [
            'client_id' => $client->id,
            'card_id' => $card->id,
            'status_note' => 'تم التسليم باليد',
        ]);

        $assignResponse->assertRedirect(route('admin.smart-cards.index'));

        $this->assertDatabaseHas('smart_cards', [
            'id' => $card->id,
            'client_id' => $client->id,
            'status' => 'active',
        ]);
    }

    public function test_admin_can_update_smart_card_status_and_unlink()
    {
        $client = Client::create([
            'full_name' => 'د. هاني شاكر',
            'phone' => '01122334455',
        ]);

        $card = SmartCard::create([
            'card_number' => 'ALB-VIP-77701',
            'status' => 'active',
            'client_id' => $client->id,
        ]);

        // Update status to blocked
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.smart-cards.update', $card->id), [
            'status' => 'blocked',
            'status_note' => 'حظر مؤقت بناء على طلب الإدارة',
        ]);

        $updateResponse->assertSessionHas('success');
        $this->assertEquals('blocked', $card->fresh()->status);

        // Unlink card
        $unlinkResponse = $this->actingAs($this->admin)->post(route('admin.smart-cards.unlink', $card->id));
        $unlinkResponse->assertSessionHas('success');

        $freshCard = $card->fresh();
        $this->assertNull($freshCard->client_id);
        $this->assertEquals('pending', $freshCard->status);
    }

    public function test_admin_can_generate_bulk_smart_cards()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.smart-cards.generate'), [
            'count' => 5,
            'prefix' => 'ALB-TEST',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals(5, SmartCard::where('card_number', 'like', 'ALB-TEST-%')->count());
    }
}
