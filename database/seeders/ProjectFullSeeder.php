<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectUnit;
use App\Models\ProjectPaymentPlan;
use App\Models\ProjectFeature;
use App\Models\ProjectImage;
use App\Models\Sector;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectFullSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |-----------------------------------------
        | GET SECTORS BY SLUG (IMPORTANT FIX)
        |-----------------------------------------
        */
        $sector = fn($slug) => Sector::where('slug', $slug)->first();

        /*
        |-----------------------------------------
        | PROJECTS DATA
        |-----------------------------------------
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
                        'unit_type' => 'Residential',
                        'floor' => 'F/S/TH/FO',
                        'start_area' => '59M - 183M',
                        'price_per_meter' => '45,000 - 70,000',
                        'unit_price' => '2,650,000 to 12,850,000',
                        'finishing_type' => 'semi finishing',
                    ],
                    [
                        'unit_type' => 'Commercial',
                        'floor' => 'Ground/First',
                        'start_area' => '25M - 500M',
                        'price_per_meter' => '120,000 - 250,000',
                        'unit_price' => '3,000,000 to 18,000,000',
                        'finishing_type' => 'core and shell',
                    ],
                    [
                        'unit_type' => 'Hotel Units',
                        'floor' => 'F/S/TH/FO',
                        'start_area' => '45M - 60M',
                        'price_per_meter' => '54,000 - 70,000',
                        'unit_price' => '2,450,000 to 3,500,000',
                        'finishing_type' => 'fully finished',
                    ]
                ],

                'payment' => [
                    'down_payment' => '5% / 10% / 15% / 25%',
                    'installment_years' => '5 / 6 / 7 / 8 years',
                    'maintenance' => '10%',
                    'notes' => null
                ],

                'features' => [],
                'images_count' => 6
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
                        'unit_type' => 'Residential',
                        'floor' => 'Ground',
                        'start_area' => '127-138-142-149-150-154-156-160',
                        'price_per_meter' => '34,000 to 42,500',
                        'unit_price' => '3,700,000 to 5,928,000',
                        'finishing_type' => 'semi finishing',
                    ],
                    [
                        'unit_type' => 'Commercial',
                        'floor' => 'Typical',
                        'start_area' => '18 to 94',
                        'price_per_meter' => null,
                        'unit_price' => null,
                        'finishing_type' => 'core and shell',
                    ]
                ],

                'payment' => [
                    'down_payment' => '8%',
                    'installment_years' => '3 years',
                    'maintenance' => null,
                    'notes' => 'under construction'
                ],

                'features' => [],
                'images_count' => 45

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
                        'unit_type' => 'Administrative',
                        'floor' => 'Second',
                        'start_area' => '160-174-184',
                        'price_per_meter' => '60,000 to 75,000',
                        'unit_price' => '3,800,000 to 6,240,000',
                        'finishing_type' => 'semi finishing',
                    ]
                ],

                'payment' => [
                    'down_payment' => '20%',
                    'installment_years' => '5 years',
                    'maintenance' => '10%',
                    'notes' => null
                ],

                'features' => [],
                'images_count' => 34
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
                        'unit_type' => 'Commercial',
                        'floor' => 'Ground',
                        'start_area' => '33-40-54-122',
                        'price_per_meter' => '140,000 to 240,000',
                        'unit_price' => '2,700,000 to 15,040,000',
                        'finishing_type' => 'core and shell',
                    ]
                ],

                'payment' => [
                    'down_payment' => '25%',
                    'installment_years' => '3 years',
                    'maintenance' => '5%',
                    'notes' => null
                ],

                'features' => [],
                'images_count' => 0
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
                        'unit_type' => 'Commercial',
                        'floor' => 'Ground',
                        'start_area' => '20.4 - 27.5 - 32.25 - 48.7',
                        'price_per_meter' => '200,000 to 250,000',
                        'unit_price' => '4,160,000 to 9,740,000',
                        'finishing_type' => 'semi finishing',
                    ],

                    [
                        'unit_type' => 'Commercial',
                        'floor' => 'Mezzanine',
                        'start_area' => '12.43 - 14.97 - 17.5 - 24.75',
                        'price_per_meter' => '90,000 to 130,000',
                        'unit_price' => '859,100 to 3,211,000',
                        'finishing_type' => 'semi finishing',
                    ],

                    [
                        'unit_type' => 'Administrative',
                        'floor' => 'First - Second',
                        'start_area' => '28.13 - 32.62 - 36.0',
                        'price_per_meter' => '50,000 to 65,000',
                        'unit_price' => '1,481,000 to 3,142,800',
                        'finishing_type' => 'semi finishing',
                    ]
                ],

                'payment' => [
                    'down_payment' => '40%',
                    'installment_years' => '1.5 years',
                    'maintenance' => '5%',
                    'notes' => null
                ],

                'features' => [],

                'images_count' => 13
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
                        'unit_type' => 'Commercial',
                        'floor' => 'Ground',
                        'start_area' => '49.27',
                        'price_per_meter' => '175,000',
                        'unit_price' => '8,622,250',
                        'finishing_type' => 'core and shell',
                    ],

                    [
                        'unit_type' => 'Commercial',
                        'floor' => 'Mezzanine',
                        'start_area' => '18.3 - 22.68 - 28.8 - 34.93 - 39.91',
                        'price_per_meter' => '85,000 to 95,000',
                        'unit_price' => '1,553,800 to 3,791,450',
                        'finishing_type' => 'core and shell',
                    ],

                    [
                        'unit_type' => 'Administrative',
                        'floor' => 'First - Second',
                        'start_area' => '43.37 - 44.06 - 50.76',
                        'price_per_meter' => '50,000 to 55,000',
                        'unit_price' => '2,168,500',
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
                        'unit_type' => 'Commercial',
                        'floor' => 'Ground',
                        'start_area' => '30 - 36 - 37',
                        'price_per_meter' => '170,000 to 175,000',
                        'unit_price' => '5,100,000 to 6,300,000',
                        'finishing_type' => 'core and shell',
                    ],
                    [
                        'unit_type' => 'Commercial',
                        'floor' => 'Mezzanine',
                        'start_area' => '16.39 - 20.24 - 28 - 43',
                        'price_per_meter' => '85,000',
                        'unit_price' => '1,393,150 to 2,416,550',
                        'finishing_type' => 'core and shell',
                    ],
                    [
                        'unit_type' => 'Administrative',
                        'floor' => 'First - Second',
                        'start_area' => '50.73 - 45.81',
                        'price_per_meter' => '53,000 to 57,000',
                        'unit_price' => '2,611,170 to 2,688,690',
                        'finishing_type' => 'semi finishing',
                    ]
                ],

                'payment' => [
                    'down_payment' => '40%',
                    'installment_years' => '1.5 years',
                    'maintenance' => '5%',
                    'notes' => null
                ],

                'features' => [],
                'images_count' => 8
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
                        'unit_type' => 'Commercial',
                        'floor' => 'Ground',
                        'start_area' => '39.8 - 39.8',
                        'price_per_meter' => '175,000',
                        'unit_price' => '6,965,000',
                        'finishing_type' => 'core and shell',
                    ],
                    [
                        'unit_type' => 'Commercial',
                        'floor' => 'Mezzanine',
                        'start_area' => '15.8 - 20.92 - 28.64',
                        'price_per_meter' => '90,000',
                        'unit_price' => '1,343,000 to 2,577,600',
                        'finishing_type' => 'core and shell',
                    ],
                    [
                        'unit_type' => 'Administrative',
                        'floor' => 'First - Second',
                        'start_area' => '41.78 - 44.73 - 81.57',
                        'price_per_meter' => '46,000 - 55,000',
                        'unit_price' => '1,921,880 to 4,486,150',
                        'finishing_type' => 'semi finishing',
                    ]
                ],

                'payment' => [
                    'down_payment' => '40%',
                    'installment_years' => '1.5 years',
                    'maintenance' => '5%',
                    'notes' => null
                ],

                'features' => [],
                'images_count' => 4
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
                        'unit_type' => 'Residential',
                        'floor' => 'F/S/TH/FO',
                        'start_area' => '112M - 145M',
                        'price_per_meter' => '33,000 - 38,000',
                        'unit_price' => '3,700,000 to 5,500,000',
                        'finishing_type' => 'semi finishing',
                    ],
                    [
                        'unit_type' => 'Commercial',
                        'floor' => 'Ground',
                        'start_area' => '18M - 60M',
                        'price_per_meter' => '110,000 to 250,000',
                        'unit_price' => '2,500,000 to 12,000,000',
                        'finishing_type' => 'core and shell',
                    ],
                    [
                        'unit_type' => 'Administrative',
                        'floor' => 'F/S/TH',
                        'start_area' => '40M - 50M',
                        'price_per_meter' => '45,000 - 70,000',
                        'unit_price' => '2,000,000 to 4,500,000',
                        'finishing_type' => 'core and shell',
                    ]
                ],

                'payment' => [
                    'down_payment' => null,
                    'installment_years' => null,
                    'maintenance' => '8%',
                    'notes' => 'SOON'
                ],

                'features' => [],
                'images_count' => 9
            ],
        ];

        /*
        |-----------------------------------------
        | INSERT
        |-----------------------------------------
        */

        foreach ($projects as $data) {

            $project = Project::updateOrCreate(
                ['name_en' => $data['name_en']],
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

                    'image' => Str::of($data['name_en'])
                        ->lower()
                        ->replace(' ', '_') . '/' . Str::of($data['name_en'])
                        ->lower()
                        ->replace(' ', '_') . '1.jpg',
                    'hover_image' => Str::of($data['name_en'])
                        ->lower()
                        ->replace(' ', '_') . '/' . Str::of($data['name_en'])
                        ->lower()
                        ->replace(' ', '_') . '2.jpg',
                ]
            );

            /*
            | UNITS
            */
            foreach ($data['units'] as $unit) {
                ProjectUnit::updateOrCreate(
                    [
                        'project_id' => $project->id,
                        'unit_type' => $unit['unit_type'],
                        'floor' => $unit['floor'],
                    ],
                    $unit
                );
            }

            /*
            | PAYMENT
            */
            if (!empty($data['payment'])) {
                ProjectPaymentPlan::updateOrCreate(
                    ['project_id' => $project->id],
                    $data['payment']
                );
            }

            /*
            | FEATURES
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
            | IMAGES
            */
            $folderName = Str::of($data['name_en'])
                ->lower()
                ->replace(' ', '_');

            for ($i = 1; $i <= ($data['images_count'] ?? 0); $i++) {

                ProjectImage::updateOrCreate(
                    [
                        'project_id' => $project->id,
                        'image' => "{$folderName}/{$folderName}{$i}.jpg",
                    ],
                    [
                        'image' => "{$folderName}/{$folderName}{$i}.jpg",
                    ]
                );
            }
        }
    }
}
