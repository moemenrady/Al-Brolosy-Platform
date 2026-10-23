<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\ProjectFeature;
use App\Models\ProjectPaymentPlan;
use App\Models\ProjectUnit;
use App\Models\ProjectUnitType;
use App\Models\Sector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectNewArchitectureCompatibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_supports_new_unit_type_and_unit_relationships_with_legacy_compatibility(): void
    {
        $sector = Sector::create([
            'name_ar' => 'سكني',
            'name_en' => 'Residential',
            'slug' => 'residential',
            'image' => 'sector.jpg',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $project = Project::create([
            'sector_id' => $sector->id,
            'name_ar' => 'Sana Tower',
            'name_en' => 'Sana Tower',
            'image' => 'project.jpg',
            'status' => 'under_construction',
            'is_active' => true,
        ]);

        $unitType = ProjectUnitType::create([
            'project_id' => $project->id,
            'name_ar' => 'وحدات سكنية',
            'name_en' => 'Residential Units',
            'unit_type' => 'Residential',
            'floor' => 'Ground',
            'area' => 120,
            'price_per_meter' => 55000,
            'unit_price' => 6600000,
            'finishing_type' => 'semi finishing',
            'total_units' => 1,
        ]);

        ProjectUnit::create([
            'project_id' => $project->id,
            'project_unit_type_id' => $unitType->id,
            'unit_number' => 'RES-GRD-001',
            'area' => 120,
            'price_per_meter' => 55000,
            'unit_price' => 6600000,
            'status' => 'available',
        ]);

        ProjectPaymentPlan::create([
            'project_id' => $project->id,
            'down_payment' => '10%',
            'installment_years' => '5 years',
            'maintenance' => '5%',
        ]);

        ProjectFeature::create([
            'project_id' => $project->id,
            'title_ar' => 'الموقع',
            'title_en' => 'Location',
            'value' => 'Sea View',
        ]);

        $this->assertSame(1, $project->unitTypes()->count());
        $this->assertSame(1, $project->actualUnits()->count());
        $this->assertSame(1, $project->units()->count());
        $this->assertSame('120.00', (string) $project->units->first()->start_area);
        $this->assertNotNull($project->paymentPlan());
        $this->assertSame(1, $project->features()->count());
    }
}
