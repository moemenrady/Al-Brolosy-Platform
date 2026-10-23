<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectUnit;
use App\Models\ProjectUnitType;
use App\Models\ProjectPaymentPlan;
use App\Models\ProjectFeature;
use App\Models\ProjectImage;
use App\Models\Sector;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectFullSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | GET SECTORS BY SLUG
        |--------------------------------------------------------------------------
        */

        $sector = fn($slug) => Sector::where('slug', $slug)->first();

        /*
        |--------------------------------------------------------------------------
        | PROJECTS DATA
        |--------------------------------------------------------------------------
        */

        $projects = [

            [
                'name_ar' => 'سانا تاور',
                'name_en' => 'SANA TOWER',
                'sector_slug' => 'residential',

                'description_ar' => 'برج سكني تجاري فندقي على شاطئ البحر بالمنصورة الجديدة، قطعة 4 أمام فيلات زهرة المورق، 46 ألف متر بشاطئ خاص 25 ألف متر.',
                'description_en' => 'Residential, commercial and hotel tower on the sea.',

                'location_ar' => 'المنصورة الجديدة',
                'location_en' => 'New Mansoura',

                'latitude' => '31.435250',
                'longitude' => '31.653600',

                'price_budget' => '2,450,000 - 18,000,000',

                'status' => 'under_construction',
                'delivery_time' => '3.5 years',

                'units' => [

                    [
                        'name_ar' => 'وحدات سكنية',
                        'name_en' => 'Residential Units',

                        'unit_type' => 'Residential',
                        'floor' => 'F/S/TH/FO',

                        'area' => 120,

                        'price_per_meter' => 55000,
                        'unit_price' => 6600000,

                        'finishing_type' => 'semi finishing',
                    ],

                    [
                        'name_ar' => 'وحدات تجارية',
                        'name_en' => 'Commercial Units',

                        'unit_type' => 'Commercial',
                        'floor' => 'Ground/First',

                        'area' => 100,

                        'price_per_meter' => 180000,
                        'unit_price' => 18000000,

                        'finishing_type' => 'core and shell',
                    ],

                    [
                        'name_ar' => 'وحدات فندقية',
                        'name_en' => 'Hotel Units',

                        'unit_type' => 'Hotel Units',
                        'floor' => 'F/S/TH/FO',

                        'area' => 50,

                        'price_per_meter' => 60000,
                        'unit_price' => 3000000,

                        'finishing_type' => 'fully finished',
                    ],

                ],

                'payment' => [
                    'down_payment' => '5% / 10% / 15% / 25%',
                    'installment_years' => '5 / 6 / 7 / 8 years',
                    'maintenance' => '10%',
                    'notes' => null,
                ],

                'features' => [],
                'images_count' => 6,
            ],

            [
                'name_ar' => 'سكون',
                'name_en' => 'SOKOON',
                'sector_slug' => 'residential',

                'description_ar' => 'كمبوند سكني - فندقي - تجاري',
                'description_en' => 'Residential - Commercial - Hospitality compound',

                'location_ar' => 'دمياط الجديدة',
                'location_en' => 'New Damietta',

                'latitude' => '31.430800',
                'longitude' => '31.667370',

                'price_budget' => '3,700,000 - 5,928,000',

                'status' => 'under_construction',
                'delivery_time' => '3 years',

                'units' => [

                    [
                        'name_ar' => 'وحدات سكنية',
                        'name_en' => 'Residential Units',

                        'unit_type' => 'Residential',
                        'floor' => 'Ground',

                        'area' => 150,

                        'price_per_meter' => 40000,
                        'unit_price' => 4500000,

                        'finishing_type' => 'semi finishing',
                    ],

                    [
                        'name_ar' => 'وحدات تجارية',
                        'name_en' => 'Commercial Units',

                        'unit_type' => 'Commercial',
                        'floor' => 'Typical',

                        'area' => 50,

                        'price_per_meter' => 100000,
                        'unit_price' => 5000000,

                        'finishing_type' => 'core and shell',
                    ],

                ],

                'payment' => [
                    'down_payment' => '8%',
                    'installment_years' => '3 years',
                    'maintenance' => null,
                    'notes' => 'under construction',
                ],

                'features' => [],
                'images_count' => 45,
            ],

            [
                'name_ar' => 'سيتي سنتر',
                'name_en' => 'CITY CENTER',
                'sector_slug' => 'commercial',

                'description_ar' => 'مشروع تجاري إداري',
                'description_en' => 'Commercial Administrative Project',

                'location_ar' => 'دمياط الجديدة',
                'location_en' => 'New Damietta',

                'latitude' => '31.435250',
                'longitude' => '31.653600',

                'price_budget' => '4,224,000 - 19,264,000',

                'status' => 'under_construction',
                'delivery_time' => '3 years',

                'units' => [

                    [
                        'name_ar' => 'وحدات إدارية',
                        'name_en' => 'Administrative Units',

                        'unit_type' => 'Administrative',
                        'floor' => 'Second',

                        'area' => 170,

                        'price_per_meter' => 68000,
                        'unit_price' => 5500000,

                        'finishing_type' => 'semi finishing',
                    ],

                ],

                'payment' => [
                    'down_payment' => '20%',
                    'installment_years' => '5 years',
                    'maintenance' => '10%',
                    'notes' => null,
                ],

                'features' => [],
                'images_count' => 34,
            ],

            [
                'name_ar' => 'أركاديا',
                'name_en' => 'ARCADIA',
                'sector_slug' => 'commercial',

                'description_ar' => 'مول تجاري سكني',
                'description_en' => 'Commercial Residential Mall',

                'location_ar' => 'دمياط',
                'location_en' => 'Damietta',

                'latitude' => '31.425704',
                'longitude' => '31.660579',

                'price_budget' => '2,700,000 - 15,040,000',

                'status' => 'under_construction',
                'delivery_time' => '1 year',

                'units' => [

                    [
                        'name_ar' => 'وحدات تجارية',
                        'name_en' => 'Commercial Units',

                        'unit_type' => 'Commercial',
                        'floor' => 'Ground',

                        'area' => 54,

                        'price_per_meter' => 190000,
                        'unit_price' => 10260000,

                        'finishing_type' => 'core and shell',
                    ],

                ],

                'payment' => [
                    'down_payment' => '25%',
                    'installment_years' => '3 years',
                    'maintenance' => '5%',
                    'notes' => null,
                ],

                'features' => [],
                'images_count' => 0,
            ],

            [
                'name_ar' => 'ويست مول',
                'name_en' => 'WEST',
                'sector_slug' => 'commercial',

                'description_ar' => 'مول تجاري في الجامعة على مساحة 283م يتكون من أراضي بميزانين تجاري وأول وثاني إداري وأبراج سكنية أمامية بواجهة مباشرة على الجامعة وناصية على المدخل الغربي للمدينة والموقف الغربي.',
                'description_en' => 'Commercial mall at the university with commercial and administrative units.',

                'location_ar' => 'دمياط الجديدة',
                'location_en' => 'New Damietta',

                'latitude' => null,
                'longitude' => null,

                'price_budget' => '859,100 - 9,740,000',

                'status' => 'under_construction',
                'delivery_time' => '1 year',

                'units' => [

                    [
                        'name_ar' => 'محلات تجارية - أرضي',
                        'name_en' => 'Commercial Units - Ground',

                        'unit_type' => 'Commercial',
                        'floor' => 'Ground',

                        'area' => 32.25,

                        'price_per_meter' => 225000,
                        'unit_price' => 7256250,

                        'finishing_type' => 'semi finishing',
                    ],

                    [
                        'name_ar' => 'محلات تجارية - ميزانين',
                        'name_en' => 'Commercial Units - Mezzanine',

                        'unit_type' => 'Commercial',
                        'floor' => 'Mezzanine',

                        'area' => 17.5,

                        'price_per_meter' => 110000,
                        'unit_price' => 1925000,

                        'finishing_type' => 'semi finishing',
                    ],

                    [
                        'name_ar' => 'وحدات إدارية',
                        'name_en' => 'Administrative Units',

                        'unit_type' => 'Administrative',
                        'floor' => 'First - Second',

                        'area' => 32.62,

                        'price_per_meter' => 57500,
                        'unit_price' => 1875650,

                        'finishing_type' => 'semi finishing',
                    ],

                ],

                'payment' => [
                    'down_payment' => '40%',
                    'installment_years' => '1.5 years',
                    'maintenance' => '5%',
                    'notes' => null,
                ],

                'features' => [],
                'images_count' => 13,
            ],

            [
                'name_ar' => 'لاينز مول',
                'name_en' => 'LINES',
                'sector_slug' => 'commercial',

                'description_ar' => 'أكبر مول تجاري في الجامعة على مساحة 1700 م² يتكون من 6 قطع ضم، بواجهة على الطريق الأوسطي 25م وواجهة على جامعة دمياط مباشرة بعمق 85م وناصية على مدخل متشابك 10م، يتكون من أراضي وميزانين تجاري وأول وثاني إداري وثالث سكني.',
                'description_en' => 'The largest commercial mall at the university on an area of 1700 sqm with direct frontage on Damietta University and the middle road, featuring commercial and administrative units.',

                'location_ar' => 'دمياط الجديدة',
                'location_en' => 'New Damietta',

                'latitude' => '31.428580',
                'longitude' => '31.650350',

                'price_budget' => '1,553,800 - 8,622,250',

                'status' => 'under_construction',
                'delivery_time' => '1 year',

                'units' => [

                    [
                        'name_ar' => 'وحدات تجارية - أرضي',
                        'name_en' => 'Commercial Units - Ground',

                        'unit_type' => 'Commercial',
                        'floor' => 'Ground',

                        'area' => 49.27,

                        'price_per_meter' => 175000,
                        'unit_price' => 8622250,

                        'finishing_type' => 'core and shell',
                    ],

                    [
                        'name_ar' => 'وحدات تجارية - ميزانين',
                        'name_en' => 'Commercial Units - Mezzanine',

                        'unit_type' => 'Commercial',
                        'floor' => 'Mezzanine',

                        'area' => 28.8,

                        'price_per_meter' => 90000,
                        'unit_price' => 2592000,

                        'finishing_type' => 'core and shell',
                    ],

                    [
                        'name_ar' => 'وحدات إدارية',
                        'name_en' => 'Administrative Units',

                        'unit_type' => 'Administrative',
                        'floor' => 'First - Second',

                        'area' => 50.76,

                        'price_per_meter' => 52500,
                        'unit_price' => 2664900,

                        'finishing_type' => 'semi finishing',
                    ],

                ],

                'payment' => [
                    'down_payment' => '40%',
                    'installment_years' => '1.5 years',
                    'maintenance' => '5%',
                    'notes' => null,
                ],

                'features' => [],
                'images_count' => 10,
            ],

            [
                'name_ar' => 'زون مول',
                'name_en' => 'ZONE',
                'sector_slug' => 'commercial',

                'description_ar' => 'مول تجاري في حي الجامعة على مساحة 566م وهو قطعتان أرض ضم يتكون من أراضي وميزانين تجاري وأول وثاني إداري والثالث سكني بواجهة 30م مباشرة على الطريق الأوسط.',
                'description_en' => 'Commercial mall in the university district.',

                'location_ar' => 'دمياط الجديدة',
                'location_en' => 'New Damietta',

                'latitude' => '31.429516',
                'longitude' => '31.649912',

                'price_budget' => '1,393,150 - 6,300,000',

                'status' => 'immediate',
                'delivery_time' => 'immediate delivery',

                'units' => [

                    [
                        'name_ar' => 'وحدات تجارية - أرضي',
                        'name_en' => 'Commercial Units - Ground',

                        'unit_type' => 'Commercial',
                        'floor' => 'Ground',

                        'area' => 36,

                        'price_per_meter' => 172500,
                        'unit_price' => 6210000,

                        'finishing_type' => 'core and shell',
                    ],

                    [
                        'name_ar' => 'وحدات تجارية - ميزانين',
                        'name_en' => 'Commercial Units - Mezzanine',

                        'unit_type' => 'Commercial',
                        'floor' => 'Mezzanine',

                        'area' => 28,

                        'price_per_meter' => 85000,
                        'unit_price' => 2380000,

                        'finishing_type' => 'core and shell',
                    ],

                    [
                        'name_ar' => 'وحدات إدارية',
                        'name_en' => 'Administrative Units',

                        'unit_type' => 'Administrative',
                        'floor' => 'First - Second',

                        'area' => 50.73,

                        'price_per_meter' => 55000,
                        'unit_price' => 2790150,

                        'finishing_type' => 'semi finishing',
                    ],

                ],

                'payment' => [
                    'down_payment' => '40%',
                    'installment_years' => '1.5 years',
                    'maintenance' => '5%',
                    'notes' => null,
                ],

                'features' => [],
                'images_count' => 8,
            ],

            [
                'name_ar' => 'ميركاتو مول',
                'name_en' => 'MERCATO',
                'sector_slug' => 'commercial',

                'description_ar' => 'مول سكني تجاري في حي الجامعة على مساحة 283م يتكون من أرضي وميزانين تجاري وأول وثاني إداري ورابع سكني بواجهة مباشرة على الجامعة وثلاث قطع أرض من الموقف الغربي.',
                'description_en' => 'Commercial residential mall in the university district.',

                'location_ar' => 'دمياط الجديدة',
                'location_en' => 'New Damietta',

                'latitude' => '31.435250',
                'longitude' => '31.653600',

                'price_budget' => '1,343,000 - 6,965,000',

                'status' => 'under_construction',
                'delivery_time' => '1 year',

                'units' => [

                    [
                        'name_ar' => 'وحدات تجارية - أرضي',
                        'name_en' => 'Commercial Units - Ground',

                        'unit_type' => 'Commercial',
                        'floor' => 'Ground',

                        'area' => 39.8,

                        'price_per_meter' => 175000,
                        'unit_price' => 6965000,

                        'finishing_type' => 'core and shell',
                    ],

                    [
                        'name_ar' => 'وحدات تجارية - ميزانين',
                        'name_en' => 'Commercial Units - Mezzanine',

                        'unit_type' => 'Commercial',
                        'floor' => 'Mezzanine',

                        'area' => 28.64,

                        'price_per_meter' => 90000,
                        'unit_price' => 2577600,

                        'finishing_type' => 'core and shell',
                    ],

                    [
                        'name_ar' => 'وحدات إدارية',
                        'name_en' => 'Administrative Units',

                        'unit_type' => 'Administrative',
                        'floor' => 'First - Second',

                        'area' => 44.73,

                        'price_per_meter' => 50000,
                        'unit_price' => 2236500,

                        'finishing_type' => 'semi finishing',
                    ],

                ],

                'payment' => [
                    'down_payment' => '40%',
                    'installment_years' => '1.5 years',
                    'maintenance' => '5%',
                    'notes' => null,
                ],

                'features' => [],
                'images_count' => 4,
            ],

            [
                'name_ar' => 'جولدن سكوير',
                'name_en' => 'GOLDEN SQUARE',
                'sector_slug' => 'commercial',

                'description_ar' => 'مشروع سكني تجاري إداري طبي في قلب المركزية مساحة 21 ألف متر بواجهة مباشرة على شارع 100 وبجوار الكنيسة مباشرة.',
                'description_en' => 'Residential, commercial and administrative project.',

                'location_ar' => 'دمياط الجديدة',
                'location_en' => 'New Damietta',

                'latitude' => '31.428580',
                'longitude' => '31.650350',

                'price_budget' => '2,000,000 - 12,000,000',

                'status' => 'under_construction',
                'delivery_time' => '3 years',

                'units' => [

                    [
                        'name_ar' => 'وحدات سكنية',
                        'name_en' => 'Residential Units',

                        'unit_type' => 'Residential',
                        'floor' => 'F/S/TH/FO',

                        'area' => 145,

                        'price_per_meter' => 35500,
                        'unit_price' => 5147500,

                        'finishing_type' => 'semi finishing',
                    ],

                    [
                        'name_ar' => 'وحدات تجارية',
                        'name_en' => 'Commercial Units',

                        'unit_type' => 'Commercial',
                        'floor' => 'Ground',

                        'area' => 40,

                        'price_per_meter' => 180000,
                        'unit_price' => 7200000,

                        'finishing_type' => 'core and shell',
                    ],

                    [
                        'name_ar' => 'وحدات إدارية',
                        'name_en' => 'Administrative Units',

                        'unit_type' => 'Administrative',
                        'floor' => 'F/S/TH',

                        'area' => 45,

                        'price_per_meter' => 57500,
                        'unit_price' => 2587500,

                        'finishing_type' => 'core and shell',
                    ],

                ],

                'payment' => [
                    'down_payment' => null,
                    'installment_years' => null,
                    'maintenance' => '8%',
                    'notes' => 'SOON',
                ],

                'features' => [],
                'images_count' => 9,
            ],

        ];

        /*
        |--------------------------------------------------------------------------
        | INSERT PROJECTS
        |--------------------------------------------------------------------------
        */

        foreach ($projects as $data) {

            DB::transaction(function () use ($data, $sector) {

                /*
                |--------------------------------------------------------------------------
                | PROJECT
                |--------------------------------------------------------------------------
                */

                $folderName = Str::of($data['name_en'])
                    ->lower()
                    ->replace(' ', '_');

                $project = Project::updateOrCreate(
                    [
                        'name_en' => $data['name_en'],
                    ],
                    [
                        'sector_id' => $sector($data['sector_slug'])?->id,

                        'name_ar' => $data['name_ar'],
                        'name_en' => $data['name_en'],

                        'description_ar' => $data['description_ar'],
                        'description_en' => $data['description_en'],

                        'location_ar' => $data['location_ar'],
                        'location_en' => $data['location_en'],

                        'latitude' => $data['latitude'] ?? null,
                        'longitude' => $data['longitude'] ?? null,

                        'price_budget' => $data['price_budget'],

                        'status' => $data['status'],
                        'delivery_time' => $data['delivery_time'],

                        'image' => "{$folderName}/optimized/{$folderName}1.webp",

                        'hover_image' => "{$folderName}/optimized/{$folderName}2.webp",
                    ]
                );

                /*
                |--------------------------------------------------------------------------
                | UNIT TYPES + ACTUAL UNITS
                |--------------------------------------------------------------------------
                */

                foreach ($data['units'] as $index => $unit) {

                    /*
                    |--------------------------------------------------------------------------
                    | Unique prefix for actual unit numbers
                    |--------------------------------------------------------------------------
                    */

                    $typePrefix = match ($unit['unit_type']) {
                        'Residential' => 'RES',
                        'Commercial' => 'COM',
                        'Administrative' => 'ADM',
                        'Hotel Units' => 'HOT',
                        default => 'UNIT',
                    };

                    $floorPrefix = Str::upper(
                        Str::of($unit['floor'])
                            ->replace([' ', '/', '-'], '')
                            ->substr(0, 5)
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | UNIT TYPE
                    |--------------------------------------------------------------------------
                    */

                    $unitType = ProjectUnitType::updateOrCreate(
                        [
                            'project_id' => $project->id,
                            'unit_type' => $unit['unit_type'],
                            'floor' => $unit['floor'],
                        ],
                        [
                            'name_ar' => $unit['name_ar'],
                            'name_en' => $unit['name_en'],

                            'unit_type' => $unit['unit_type'],
                            'floor' => $unit['floor'],

                            'area' => $unit['area'],

                            'price_per_meter' => $unit['price_per_meter'],
                            'unit_price' => $unit['unit_price'],

                            'finishing_type' => $unit['finishing_type'],

                            'total_units' => 50,
                        ]
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | CREATE 50 ACTUAL UNITS
                    |--------------------------------------------------------------------------
                    */

                    for ($i = 1; $i <= 50; $i++) {

                        $unitNumber = sprintf(
                            '%s-%s-%03d',
                            $typePrefix,
                            $floorPrefix ?: 'GEN',
                            $i
                        );

                        ProjectUnit::updateOrCreate(
                            [
                                'project_id' => $project->id,
                                'unit_number' => $unitNumber,
                            ],
                            [
                                'project_unit_type_id' => $unitType->id,

                                'area' => $unit['area'],

                                'price_per_meter' => $unit['price_per_meter'],

                                'unit_price' => $unit['unit_price'],

                                'status' => 'available',
                            ]
                        );
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | PAYMENT PLAN
                |--------------------------------------------------------------------------
                */

                if (!empty($data['payment'])) {

                    ProjectPaymentPlan::updateOrCreate(
                        [
                            'project_id' => $project->id,
                        ],
                        $data['payment']
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | FEATURES
                |--------------------------------------------------------------------------
                */

                foreach ($data['features'] as $feature) {

                    ProjectFeature::updateOrCreate(
                        [
                            'project_id' => $project->id,
                            'title_en' => $feature['title_en'] ?? '',
                        ],
                        $feature
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | IMAGES
                |--------------------------------------------------------------------------
                */

                for ($i = 1; $i <= ($data['images_count'] ?? 0); $i++) {

                    $imagePath =
                        "{$folderName}/optimized/{$folderName}{$i}.webp";

                    ProjectImage::updateOrCreate(
                        [
                            'project_id' => $project->id,
                            'image' => $imagePath,
                        ],
                        [
                            'image' => $imagePath,
                        ]
                    );
                }
            });
        }
    }
}
