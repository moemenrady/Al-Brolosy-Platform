<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $sales;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'المدير العام',
            'email' => 'admin@albrolosy.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $this->sales = User::create([
            'name' => 'مندوب مبيعات',
            'email' => 'sales@albrolosy.com',
            'password' => bcrypt('password123'),
            'role' => 'sales',
        ]);
    }

    public function test_admin_can_view_users_list_and_stats(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.administration.users');
        $response->assertSee('المدير العام');
        $response->assertSee('مندوب مبيعات');
        $response->assertViewHas('stats');
    }

    public function test_admin_can_filter_users_by_role_and_search(): void
    {
        User::create([
            'name' => 'مسؤول تسويق رقمي',
            'email' => 'marketing@albrolosy.com',
            'password' => bcrypt('password123'),
            'role' => 'staff',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.users.index', [
            'role' => 'sales',
        ]));

        $response->assertStatus(200);
        $response->assertSee('مندوب مبيعات');
        $response->assertDontSee('مسؤول تسويق رقمي');
    }

    public function test_admin_can_create_new_user(): void
    {
        $payload = [
            'name' => 'محمد مدير المبيعات',
            'email' => 'mohamed.sales@albrolosy.com',
            'password' => 'secret1234',
            'role' => 'sales',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), $payload);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'محمد مدير المبيعات',
            'email' => 'mohamed.sales@albrolosy.com',
            'role' => 'sales',
        ]);
    }

    public function test_admin_can_update_user(): void
    {
        $payload = [
            'name' => 'مندوب مبيعات متقدم',
            'email' => 'sales.updated@albrolosy.com',
            'role' => 'manager',
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.users.update', $this->sales), $payload);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $this->sales->id,
            'name' => 'مندوب مبيعات متقدم',
            'email' => 'sales.updated@albrolosy.com',
            'role' => 'manager',
        ]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $response = $this->actingAs($this->admin)
            ->from(route('admin.users.index'))
            ->delete(route('admin.users.delete', $this->admin));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_admin_can_delete_other_user(): void
    {
        $response = $this->actingAs($this->admin)
            ->from(route('admin.users.index'))
            ->delete(route('admin.users.delete', $this->sales));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $this->sales->id]);
    }
}
