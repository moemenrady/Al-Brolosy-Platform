<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Identity;
use App\Models\Project;
use App\Models\Sector;
use App\Models\User;
use App\Models\UserBehavior;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadCaptureAndBehaviorTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Sector $sector;
    protected Project $project;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'المدير التنفيذي',
            'email' => 'admin@albrolosy.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $this->sector = Sector::create([
            'name_ar' => 'قطاع سكني استثماري',
            'name_en' => 'Investment Residential',
            'slug' => 'invest-res',
            'image' => 'sectors/invest.jpg',
            'is_active' => true,
        ]);

        $this->project = Project::create([
            'sector_id' => $this->sector->id,
            'name_ar' => 'كمبوند سيتي كابيتال',
            'name_en' => 'City Capital Compound',
            'image' => 'projects/capital.jpg',
            'location_ar' => 'العاصمة الإدارية الجديدة',
            'price_budget' => '3,500,000 ج.م',
            'is_active' => true,
        ]);
    }

    /* =========================================================================
     * 1. Frictionless Concierge Quiz API (/api/v1/lead/quiz-submit)
     * ========================================================================= */

    public function test_visitor_can_submit_concierge_quiz_and_receives_matching_projects(): void
    {
        $payload = [
            'full_name' => 'محمود عبد الفتاح',
            'phone' => '01012345678',
            'purpose' => 'residential',
            'unit_type' => 'apartment',
            'project_or_city' => 'العاصمة الإدارية',
            'budget' => '4_6m',
            'payment_method' => 'installments',
        ];

        $response = $this->postJson(route('lead.quiz-submit'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonStructure([
            'success',
            'client_id',
            'message',
            'matching_projects',
        ]);

        // Assert Client was created in database
        $this->assertDatabaseHas('clients', [
            'full_name' => 'محمود عبد الفتاح',
            'phone' => '01012345678',
            'purpose' => 'residential',
            'unit_type' => 'apartment',
            'budget' => '4_6m',
            'lead_source' => 'website',
            'lead_status' => 'new',
        ]);

        // Assert UserBehavior event was recorded
        $this->assertDatabaseHas('user_behaviors', [
            'event_type' => 'quiz_complete',
            'page_title' => 'المستشار العقاري الذكي',
        ]);

        // Assert ClientHistory event was recorded
        $this->assertDatabaseHas('client_histories', [
            'type' => 'interest_registered',
            'title' => 'إكمال نموذج المستشار العقاري الذكي',
            'origin' => 'Website Concierge',
        ]);
    }

    public function test_quiz_submit_validates_required_fields(): void
    {
        $response = $this->postJson(route('lead.quiz-submit'), [
            // Missing full_name and phone
            'purpose' => 'residential',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['full_name', 'phone']);
    }

    /* =========================================================================
     * 2. Quick Inquiry API (/api/v1/lead/quick-inquiry)
     * ========================================================================= */

    public function test_visitor_can_submit_quick_inquiry_for_whatsapp_or_brochure(): void
    {
        $payload = [
            'full_name' => 'ياسر القاضي',
            'phone' => '01234567899',
            'project_id' => $this->project->id,
            'unit_type' => 'apartment',
            'inquiry_type' => 'whatsapp',
            'notes' => 'مهتم بمعرفة أنظمة التقسيط لمشروع كمبوند سيتي كابيتال',
        ];

        $response = $this->postJson(route('lead.quick-inquiry'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        // Assert Client created
        $this->assertDatabaseHas('clients', [
            'full_name' => 'ياسر القاضي',
            'phone' => '01234567899',
            'project_or_city' => 'كمبوند سيتي كابيتال',
        ]);

        // Assert Behavior event logged
        $this->assertDatabaseHas('user_behaviors', [
            'project_id' => $this->project->id,
            'event_type' => 'whatsapp_click',
        ]);
    }

    /* =========================================================================
     * 3. Behavior Tracking API (/api/v1/behavior/track)
     * ========================================================================= */

    public function test_visitor_can_track_behavior_event(): void
    {
        $payload = [
            'event_type' => 'project_view',
            'project_id' => $this->project->id,
            'page_url' => 'http://localhost/projects/' . $this->project->id,
            'page_title' => 'كمبوند سيتي كابيتال | شركة البرلسي للتطوير العقاري',
            'metadata' => [
                'time_on_page' => 45,
                'scroll_depth' => 85,
            ],
        ];

        $response = $this->postJson(route('behavior.track'), $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('user_behaviors', [
            'project_id' => $this->project->id,
            'event_type' => 'project_view',
            'page_title' => 'كمبوند سيتي كابيتال | شركة البرلسي للتطوير العقاري',
        ]);
    }

    /* =========================================================================
     * 4. Admin Analytics & Reporting Page
     * ========================================================================= */

    public function test_admin_can_access_analytics_page_with_aggregated_metrics(): void
    {
        // Seed some behaviors
        UserBehavior::create([
            'event_type' => 'whatsapp_click',
            'project_id' => $this->project->id,
            'page_url' => '/projects/' . $this->project->id,
            'device' => 'mobile',
        ]);

        UserBehavior::create([
            'event_type' => 'brochure_download',
            'project_id' => $this->project->id,
            'page_url' => '/projects/' . $this->project->id,
            'device' => 'desktop',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.analytics.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.analytics.index');
        $response->assertViewHas([
            'totalVisitors',
            'totalLeads',
            'totalEvents',
            'whatsappClicks',
            'brochureDownloads',
            'topViewedProjects',
            'highIntentLeads',
        ]);
    }

    public function test_admin_can_export_clients_data_to_csv(): void
    {
        Client::create([
            'full_name' => 'طارق شوقي',
            'phone' => '01022334455',
            'email' => 'tarek@example.com',
            'governorate' => 'القاهرة',
            'purpose' => 'investment',
            'unit_type' => 'office',
            'budget' => '10_20m',
            'lead_status' => 'qualified',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.analytics.export'));

        $response->assertStatus(200);
        $this->assertEquals('text/csv; charset=UTF-8', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('attachment; filename=', (string)$response->headers->get('Content-Disposition'));

        // Obtain streamed content
        $content = $response->streamedContent();

        // Check UTF-8 BOM
        $this->assertStringStartsWith("\xEF\xBB\xBF", $content);
        // Check contents
        $this->assertStringContainsString('طارق شوقي', $content);
        $this->assertStringContainsString('01022334455', $content);
        $this->assertStringContainsString('القاهرة', $content);
    }
}
