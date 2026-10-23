<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\ProjectPaymentPlan;
use App\Models\ProjectUnit;
use App\Models\ProjectUnitType;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProjectsAndUnitsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Sector $sector;
    protected Project $project;
    protected ProjectUnitType $unitType;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->sector = Sector::create([
            'name_ar' => 'سكني فاخر',
            'name_en' => 'Luxury Residential',
            'slug' => 'luxury-residential',
            'image' => 'sectors/luxury.jpg',
            'is_active' => true,
        ]);

        $this->project = Project::create([
            'sector_id' => $this->sector->id,
            'name_ar' => 'كمبوند النرجس',
            'name_en' => 'Al Narges Compound',
            'image' => 'projects/narges.jpg',
            'location_ar' => 'التجمع الخامس',
            'is_active' => true,
        ]);

        $this->unitType = ProjectUnitType::create([
            'project_id' => $this->project->id,
            'unit_type' => 'residential',
            'name_ar' => 'شقة فاخرة',
            'name_en' => 'Luxury Apartment',
        ]);
    }

    /* =========================================================================
     * 1. Project Units CRUD & Status Toggle
     * ========================================================================= */

    public function test_admin_can_view_units_index(): void
    {
        ProjectUnit::create([
            'project_id' => $this->project->id,
            'project_unit_type_id' => $this->unitType->id,
            'unit_number' => 'A-101',
            'area' => 150,
            'price_per_meter' => 20000,
            'unit_price' => 3000000,
            'status' => 'available',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.units.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.projects.units');
        $response->assertSee('A-101');
        $response->assertSee('كمبوند النرجس');
    }

    public function test_admin_can_create_unit(): void
    {
        $payload = [
            'project_id' => $this->project->id,
            'project_unit_type_id' => $this->unitType->id,
            'unit_number' => 'B-205',
            'area' => 200,
            'price_per_meter' => 25000,
            'status' => 'available',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.units.store'), $payload);

        $response->assertRedirect(route('admin.units.index'));
        $this->assertDatabaseHas('project_units', [
            'unit_number' => 'B-205',
            'area' => 200,
            'price_per_meter' => 25000,
            'unit_price' => 5000000, // 200 * 25000
            'status' => 'available',
        ]);
    }

    public function test_admin_can_update_unit(): void
    {
        $unit = ProjectUnit::create([
            'project_id' => $this->project->id,
            'project_unit_type_id' => $this->unitType->id,
            'unit_number' => 'C-301',
            'area' => 100,
            'price_per_meter' => 15000,
            'unit_price' => 1500000,
            'status' => 'available',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.units.update', $unit), [
            'project_id' => $this->project->id,
            'project_unit_type_id' => $this->unitType->id,
            'unit_number' => 'C-301-UPDATED',
            'area' => 120,
            'price_per_meter' => 18000,
            'status' => 'reserved',
        ]);

        $response->assertRedirect(route('admin.units.index'));
        $this->assertDatabaseHas('project_units', [
            'id' => $unit->id,
            'unit_number' => 'C-301-UPDATED',
            'status' => 'reserved',
            'unit_price' => 2160000, // 120 * 18000
        ]);
    }

    public function test_admin_can_toggle_unit_status(): void
    {
        $unit = ProjectUnit::create([
            'project_id' => $this->project->id,
            'project_unit_type_id' => $this->unitType->id,
            'unit_number' => 'D-401',
            'area' => 180,
            'price_per_meter' => 20000,
            'unit_price' => 3600000,
            'status' => 'available',
        ]);

        // Update status to reserved
        $this->actingAs($this->admin)
            ->from(route('admin.units.index'))
            ->patch(route('admin.units.toggle-status', $unit), ['status' => 'reserved']);
        $this->assertEquals('reserved', $unit->fresh()->status);

        // Update status to sold
        $this->actingAs($this->admin)
            ->from(route('admin.units.index'))
            ->patch(route('admin.units.toggle-status', $unit), ['status' => 'sold']);
        $this->assertEquals('sold', $unit->fresh()->status);

        // Update status to available
        $this->actingAs($this->admin)
            ->from(route('admin.units.index'))
            ->patch(route('admin.units.toggle-status', $unit), ['status' => 'available']);
        $this->assertEquals('available', $unit->fresh()->status);
    }

    public function test_admin_can_delete_unit(): void
    {
        $unit = ProjectUnit::create([
            'project_id' => $this->project->id,
            'project_unit_type_id' => $this->unitType->id,
            'unit_number' => 'E-501',
            'area' => 100,
            'price_per_meter' => 10000,
            'unit_price' => 1000000,
            'status' => 'available',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.units.destroy', $unit));

        $response->assertRedirect(route('admin.units.index'));
        $this->assertDatabaseMissing('project_units', ['id' => $unit->id]);
    }

    /* =========================================================================
     * 2. Project Payment Plans CRUD
     * ========================================================================= */

    public function test_admin_can_view_payment_plans(): void
    {
        ProjectPaymentPlan::create([
            'project_id' => $this->project->id,
            'down_payment' => '10%',
            'installment_years' => '7 سنوات',
            'maintenance' => '8%',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.payment-plans.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.projects.payment-plans');
        $response->assertSee('10%');
        $response->assertSee('7 سنوات');
    }

    public function test_admin_can_create_payment_plan(): void
    {
        $payload = [
            'project_id' => $this->project->id,
            'down_payment' => '15%',
            'installment_years' => '8 سنوات متساوية',
            'maintenance' => '5%',
            'notes' => 'عرض خاص لفترة محدودة',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.payment-plans.store'), $payload);

        $response->assertRedirect(route('admin.payment-plans.index'));
        $this->assertDatabaseHas('project_payment_plans', [
            'project_id' => $this->project->id,
            'down_payment' => '15%',
            'installment_years' => '8 سنوات متساوية',
        ]);
    }

    public function test_admin_can_update_payment_plan(): void
    {
        $plan = ProjectPaymentPlan::create([
            'project_id' => $this->project->id,
            'down_payment' => '10%',
            'installment_years' => '5 سنوات',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.payment-plans.update', $plan), [
            'project_id' => $this->project->id,
            'down_payment' => '20%',
            'installment_years' => '6 سنوات',
            'maintenance' => '7%',
        ]);

        $response->assertRedirect(route('admin.payment-plans.index'));
        $this->assertDatabaseHas('project_payment_plans', [
            'id' => $plan->id,
            'down_payment' => '20%',
            'installment_years' => '6 سنوات',
        ]);
    }

    public function test_admin_can_delete_payment_plan(): void
    {
        $plan = ProjectPaymentPlan::create([
            'project_id' => $this->project->id,
            'down_payment' => '10%',
            'installment_years' => '5 سنوات',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.payment-plans.destroy', $plan));

        $response->assertRedirect(route('admin.payment-plans.index'));
        $this->assertDatabaseMissing('project_payment_plans', ['id' => $plan->id]);
    }

    /* =========================================================================
     * 3. Sectors CRUD & Active Toggle
     * ========================================================================= */

    public function test_admin_can_view_sectors(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.sectors.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.projects.sectors');
        $response->assertSee('سكني فاخر');
    }

    public function test_admin_can_create_sector(): void
    {
        $payload = [
            'name_ar' => 'قطاع الساحل الشمالي',
            'name_en' => 'North Coast Sector',
            'is_active' => '1',
            'sort_order' => 2,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.sectors.store'), $payload);

        $response->assertRedirect(route('admin.sectors.index'));
        $this->assertDatabaseHas('sectors', [
            'name_ar' => 'قطاع الساحل الشمالي',
            'slug' => 'north-coast-sector',
            'is_active' => 1,
        ]);
    }

    public function test_admin_can_update_sector(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.sectors.update', $this->sector), [
            'name_ar' => 'سكني راقي ومميز',
            'name_en' => 'High End Residential',
            'sort_order' => 5,
        ]);

        $response->assertRedirect(route('admin.sectors.index'));
        $this->assertDatabaseHas('sectors', [
            'id' => $this->sector->id,
            'name_ar' => 'سكني راقي ومميز',
            'name_en' => 'High End Residential',
            'sort_order' => 5,
        ]);
    }

    public function test_admin_can_toggle_sector_active(): void
    {
        $this->assertTrue($this->sector->is_active);

        $response = $this->actingAs($this->admin)
            ->from(route('admin.sectors.index'))
            ->patch(route('admin.sectors.toggle-active', $this->sector));

        $response->assertRedirect(route('admin.sectors.index'));
        $this->assertFalse((bool)$this->sector->fresh()->is_active);
    }
}
