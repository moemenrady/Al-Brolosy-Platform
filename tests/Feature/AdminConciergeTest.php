<?php

namespace Tests\Feature;

use App\Models\ConciergeStep;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminConciergeTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $sales;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@albrolosy.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $this->sales = User::create([
            'name' => 'مسؤول المبيعات',
            'email' => 'sales@albrolosy.com',
            'password' => bcrypt('password123'),
            'role' => 'sales',
        ]);
    }

    public function test_admin_can_view_concierge_steps_index(): void
    {
        ConciergeStep::create([
            'step_number' => 1,
            'sort_order' => 1,
            'title_ar' => 'ما هو غرضك الأساسي؟',
            'title_en' => 'What is your primary purpose?',
            'step_type' => 'options_grid',
            'target_field' => 'purpose',
            'options' => [
                ['title_ar' => 'سكني', 'value' => 'residential', 'icon' => '🏡'],
            ],
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.concierge-steps.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.concierge.index');
        $response->assertSee('ما هو غرضك الأساسي؟');
        $response->assertSee('منشئ ومحرر المستشار العقاري الذكي');
        $response->assertViewHas('steps');
        $response->assertViewHas('stats');
    }

    public function test_admin_can_create_new_concierge_step_with_options(): void
    {
        $payload = [
            'title_ar' => 'ما هي المدينة المفضلة لديك؟',
            'title_en' => 'What is your preferred city?',
            'subtitle_ar' => 'اختر النطاق الجغرافي للاستثمار',
            'step_type' => 'options_grid',
            'target_field' => 'project_or_city',
            'options_json' => json_encode([
                ['title_ar' => 'التجمع الخامس', 'title_en' => 'Fifth Settlement', 'value' => 'new_cairo', 'icon' => '🏙️'],
                ['title_ar' => 'الشيخ زايد', 'title_en' => 'Zayed', 'value' => 'sheikh_zayed', 'icon' => '🌲'],
            ]),
            'is_active' => '1',
            'is_required' => '1',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.concierge-steps.store'), $payload);

        $response->assertRedirect(route('admin.concierge-steps.index'));

        $this->assertDatabaseHas('concierge_steps', [
            'title_ar' => 'ما هي المدينة المفضلة لديك؟',
            'target_field' => 'project_or_city',
            'step_type' => 'options_grid',
            'is_active' => 1,
        ]);

        $step = ConciergeStep::where('title_ar', 'ما هي المدينة المفضلة لديك؟')->first();
        $this->assertIsArray($step->options);
        $this->assertCount(2, $step->options);
        $this->assertEquals('التجمع الخامس', $step->options[0]['title_ar']);
    }

    public function test_admin_can_update_concierge_step(): void
    {
        $step = ConciergeStep::create([
            'step_number' => 1,
            'sort_order' => 1,
            'title_ar' => 'عنوان قديم',
            'step_type' => 'options_grid',
            'target_field' => 'purpose',
            'is_active' => true,
        ]);

        $payload = [
            'title_ar' => 'عنوان محدث ومطور',
            'title_en' => 'Updated Title',
            'step_type' => 'options_grid',
            'target_field' => 'purpose',
            'options_json' => json_encode([
                ['title_ar' => 'سكن فاخر', 'value' => 'residential', 'icon' => '👑'],
            ]),
            'is_active' => '1',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.concierge-steps.update', $step), $payload);

        $response->assertRedirect(route('admin.concierge-steps.index'));

        $this->assertDatabaseHas('concierge_steps', [
            'id' => $step->id,
            'title_ar' => 'عنوان محدث ومطور',
        ]);
    }

    public function test_admin_can_toggle_step_active_state(): void
    {
        $step = ConciergeStep::create([
            'step_number' => 1,
            'sort_order' => 1,
            'title_ar' => 'خطوة للاختبار',
            'step_type' => 'options_grid',
            'target_field' => 'budget',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)
            ->from(route('admin.concierge-steps.index'))
            ->patch(route('admin.concierge-steps.toggle-active', $step));

        $response->assertRedirect(route('admin.concierge-steps.index'));
        $this->assertFalse((bool)$step->fresh()->is_active);

        // Toggle back to active
        $this->actingAs($this->admin)
            ->from(route('admin.concierge-steps.index'))
            ->patch(route('admin.concierge-steps.toggle-active', $step));

        $this->assertTrue((bool)$step->fresh()->is_active);
    }

    public function test_admin_can_delete_concierge_step(): void
    {
        $step = ConciergeStep::create([
            'step_number' => 1,
            'sort_order' => 1,
            'title_ar' => 'خطوة للحذف',
            'step_type' => 'options_grid',
            'target_field' => 'custom',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.concierge-steps.destroy', $step));

        $response->assertRedirect(route('admin.concierge-steps.index'));
        $this->assertDatabaseMissing('concierge_steps', ['id' => $step->id]);
    }

    public function test_admin_can_reorder_concierge_steps(): void
    {
        $step1 = ConciergeStep::create([
            'step_number' => 1,
            'sort_order' => 1,
            'title_ar' => 'الخطوة الأولى',
            'step_type' => 'options_grid',
            'target_field' => 'field1',
            'is_active' => true,
        ]);

        $step2 = ConciergeStep::create([
            'step_number' => 2,
            'sort_order' => 2,
            'title_ar' => 'الخطوة الثانية',
            'step_type' => 'options_grid',
            'target_field' => 'field2',
            'is_active' => true,
        ]);

        // Reverse order
        $response = $this->actingAs($this->admin)
            ->from(route('admin.concierge-steps.index'))
            ->post(route('admin.concierge-steps.reorder'), [
                'step_ids' => [$step2->id, $step1->id],
            ]);

        $response->assertRedirect(route('admin.concierge-steps.index'));

        $this->assertEquals(1, $step2->fresh()->sort_order);
        $this->assertEquals(2, $step1->fresh()->sort_order);
    }
}
