<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientHistory;
use App\Models\Consultation;
use App\Models\Identity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminCrmTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $sales;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->sales = User::create([
            'name' => 'مسؤول المبيعات أحمد',
            'email' => 'sales@test.com',
            'password' => bcrypt('password'),
            'role' => 'sales',
        ]);
    }

    /* =========================================================================
     * 1. Leads Pipeline & Filters
     * ========================================================================= */

    public function test_admin_can_view_leads_pipeline(): void
    {
        $identity = Identity::create(['guest_id' => (string) Str::uuid()]);

        Client::create([
            'identity_id' => $identity->id,
            'full_name' => 'محمد الشناوي',
            'phone' => '01011112222',
            'lead_status' => 'new',
            'purpose' => 'residential',
            'budget' => '4_6m',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.leads.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.crm.leads');
        $response->assertSee('محمد الشناوي');
        $response->assertSee('01011112222');
        $response->assertViewHas('stats');
    }

    public function test_admin_can_filter_leads_by_status_and_purpose(): void
    {
        $identity1 = Identity::create(['guest_id' => (string) Str::uuid()]);
        $identity2 = Identity::create(['guest_id' => (string) Str::uuid()]);

        Client::create([
            'identity_id' => $identity1->id,
            'full_name' => 'عميل سكني مؤهل',
            'phone' => '01000000001',
            'lead_status' => 'qualified',
            'purpose' => 'residential',
        ]);

        Client::create([
            'identity_id' => $identity2->id,
            'full_name' => 'عميل تجاري للتفاوض',
            'phone' => '01000000002',
            'lead_status' => 'negotiation',
            'purpose' => 'clinic',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.leads.index', [
            'status' => 'qualified',
            'purpose' => 'residential',
        ]));

        $response->assertStatus(200);
        $response->assertSee('عميل سكني مؤهل');
        $response->assertDontSee('عميل تجاري للتفاوض');
    }

    /* =========================================================================
     * 2. Customers View (Won Deals)
     * ========================================================================= */

    public function test_admin_can_view_won_customers(): void
    {
        $identity = Identity::create(['guest_id' => (string) Str::uuid()]);

        Client::create([
            'identity_id' => $identity->id,
            'full_name' => 'المهندس كريم حامد',
            'phone' => '01122334455',
            'lead_status' => 'won',
            'purpose' => 'residential',
            'payment_method' => 'cash',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.customers.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.crm.customers');
        $response->assertSee('المهندس كريم حامد');
        $response->assertViewHas('stats');
    }

    /* =========================================================================
     * 3. Contact Requests & Consultations
     * ========================================================================= */

    public function test_admin_can_view_consultations_and_toggle_status(): void
    {
        $consultation = Consultation::create([
            'name' => 'د. سمير النجار',
            'phone' => '01234567890',
            'preferred_contact' => 'whatsapp',
            'message' => 'أرغب في حجز موعد لمعاينة فيلا النرجس',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.consultations.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.crm.contact_requests');
        $response->assertSee('د. سمير النجار');

        // Toggle status to contacted
        $toggleResponse = $this->actingAs($this->admin)
            ->from(route('admin.consultations.index'))
            ->patch(route('admin.consultations.toggle', $consultation));

        $toggleResponse->assertRedirect(route('admin.consultations.index'));
        $this->assertEquals('contacted', $consultation->fresh()->status);
        $this->assertNotNull($consultation->fresh()->contacted_at);
    }

    public function test_admin_can_delete_consultation(): void
    {
        $consultation = Consultation::create([
            'name' => 'مستخدم للاختبار',
            'phone' => '01111111111',
            'preferred_contact' => 'phone',
            'message' => 'استفسار تجريبي',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)
            ->from(route('admin.consultations.index'))
            ->delete(route('admin.consultations.destroy', $consultation));

        $response->assertRedirect(route('admin.consultations.index'));
        $this->assertDatabaseMissing('consultations', ['id' => $consultation->id]);
    }

    /* =========================================================================
     * 4. CRM Client Actions: Status, Assignment, History, Direct Entry
     * ========================================================================= */

    public function test_admin_can_update_client_status_with_automatic_history_log(): void
    {
        $client = Client::create([
            'full_name' => 'حسن عبد الحميد',
            'phone' => '01099887766',
            'lead_status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)
            ->from(route('admin.leads.index'))
            ->patch(route('admin.clients.status', $client), [
                'lead_status' => 'qualified',
                'notes' => 'تم التواصل والتأكد من جدية الميزانية والتوقيت',
            ]);

        $response->assertRedirect(route('admin.leads.index'));
        $this->assertEquals('qualified', $client->fresh()->lead_status);

        $this->assertDatabaseHas('client_histories', [
            'client_id' => $client->id,
            'type' => 'status_changed',
            'employee_id' => $this->admin->id,
        ]);
    }

    public function test_admin_can_assign_client_to_sales_employee(): void
    {
        $client = Client::create([
            'full_name' => 'منى زكي',
            'phone' => '01512345678',
            'lead_status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)
            ->from(route('admin.leads.index'))
            ->patch(route('admin.clients.assign', $client), [
                'assigned_employee_id' => $this->sales->id,
            ]);

        $response->assertRedirect(route('admin.leads.index'));
        $this->assertEquals($this->sales->id, $client->fresh()->assigned_employee_id);

        $this->assertDatabaseHas('client_histories', [
            'client_id' => $client->id,
            'title' => 'إسناد العميل لمسؤول المبيعات',
            'employee_id' => $this->admin->id,
        ]);
    }

    public function test_admin_can_add_custom_history_to_client(): void
    {
        $client = Client::create([
            'full_name' => 'طارق الدسوقي',
            'phone' => '01299998888',
            'lead_status' => 'contacted',
        ]);

        $response = $this->actingAs($this->admin)
            ->from(route('admin.leads.index'))
            ->post(route('admin.clients.history', $client), [
                'type' => 'phone_call',
                'title' => 'مكالمة متابعة متقدمة',
                'description' => 'العميل مهتم بوحدات التجمع الخامس ويرغب في زيارة يوم الجمعة',
                'priority' => 'high',
                'follow_up_at' => now()->addDays(2)->format('Y-m-d H:i:s'),
            ]);

        $response->assertRedirect(route('admin.leads.index'));

        $this->assertDatabaseHas('client_histories', [
            'client_id' => $client->id,
            'type' => 'phone_call',
            'priority' => 'high',
            'title' => 'مكالمة متابعة متقدمة',
        ]);

        $this->assertNotNull($client->fresh()->next_follow_up_at);
    }

    public function test_admin_can_store_new_client_directly(): void
    {
        $payload = [
            'full_name' => 'أحمد إبراهيم المباشر',
            'phone' => '01055554444',
            'email' => 'ahmed.direct@example.com',
            'purpose' => 'investment',
            'unit_type' => 'shop',
            'budget' => '6_10m',
            'lead_source' => 'walk_in',
            'lead_status' => 'new',
            'assigned_employee_id' => $this->sales->id,
        ];

        $response = $this->actingAs($this->admin)
            ->from(route('admin.leads.index'))
            ->post(route('admin.clients.store'), $payload);

        $response->assertRedirect(route('admin.leads.index'));

        $this->assertDatabaseHas('clients', [
            'full_name' => 'أحمد إبراهيم المباشر',
            'phone' => '01055554444',
            'purpose' => 'investment',
            'unit_type' => 'shop',
            'assigned_employee_id' => $this->sales->id,
        ]);
    }

    public function test_admin_can_update_and_delete_client(): void
    {
        $client = Client::create([
            'full_name' => 'عميل للتعديل',
            'phone' => '01144443333',
            'lead_status' => 'new',
        ]);

        // Update
        $updateResponse = $this->actingAs($this->admin)
            ->from(route('admin.leads.index'))
            ->put(route('admin.clients.update', $client), [
                'full_name' => 'عميل تم تعديله',
                'phone' => '01144443333',
                'purpose' => 'summer',
                'unit_type' => 'chalet',
                'lead_status' => 'contacted',
            ]);

        $updateResponse->assertRedirect(route('admin.leads.index'));
        $this->assertEquals('عميل تم تعديله', $client->fresh()->full_name);
        $this->assertEquals('summer', $client->fresh()->purpose);

        // Delete
        $deleteResponse = $this->actingAs($this->admin)
            ->from(route('admin.leads.index'))
            ->delete(route('admin.clients.destroy', $client));

        $deleteResponse->assertRedirect(route('admin.leads.index'));
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}
