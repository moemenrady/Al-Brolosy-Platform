<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'sales',
        ]);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $this->assertTrue(in_array($response->getStatusCode(), [302, 403]));
    }

    public function test_non_admin_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->regularUser)->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_dashboard_and_receives_all_kpi_data(): void
    {
        $sector = Sector::create([
            'name_ar' => 'سكني',
            'name_en' => 'Residential',
            'slug' => 'residential',
            'image' => 'sector.jpg',
            'is_active' => true,
        ]);

        Project::create([
            'sector_id' => $sector->id,
            'name_ar' => 'مشروع تجريبي',
            'name_en' => 'Test Project',
            'image' => 'proj.jpg',
            'is_active' => true,
        ]);

        Client::create([
            'full_name' => 'عميل تجريبي',
            'phone' => '01012345678',
            'lead_status' => 'new',
            'purpose' => 'residential',
            'budget' => '4_6m',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
        $response->assertViewHas([
            'totalProjects',
            'totalUnits',
            'totalLeads',
            'funnelStages',
            'monthlyLeads',
            'budgetDistribution',
            'purposeDistribution',
            'topProjects',
            'recentClients',
            'recentBehaviors',
        ]);
        $response->assertSee('لوحة قيادة إدارة منصة البرلسي العقارية');
    }
}
