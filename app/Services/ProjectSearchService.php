<?php
namespace App\Services;

use App\Models\Project;

class ProjectSearchService
{
    public function search(array $filters)
    {
        return Project::query()

            ->with([
                'sector',
                'units',
                'paymentPlans',
                'features',
                'tags'
            ])

            ->where('is_active', true)

            ->when(
                $filters['keyword'] ?? null,
                fn($q) => $this->applyKeywordSearch(
                    $q,
                    $filters['keyword']
                )
            )

            ->when(
                $filters['sector_id'] ?? null,
                fn($q) => $q->where(
                    'sector_id',
                    $filters['sector_id']
                )
            )

            ->when(
                $filters['unit_type'] ?? null,
                fn($q) => $q->whereHas(
                    'units',
                    fn($u) =>
                    $u->where(
                        'unit_type',
                        $filters['unit_type']
                    )
                )
            )

            ->when(
                $filters['area_from'] ?? null,
                fn($q) => $q->whereHas(
                    'units',
                    fn($u) =>
                    $u->where(
                        'start_area',
                        '>=',
                        $filters['area_from']
                    )
                )
            )

            ->when(
                $filters['budget_from'] ?? null,
                fn($q) => $q->where(
                    'price_budget',
                    '>=',
                    $filters['budget_from']
                )
            )

            ->orderByDesc('featured')
            ->orderBy('sort_order')
            ->paginate(12);
    }

    private function applyKeywordSearch($query, string $keyword)
    {
        $query->where(function ($q) use ($keyword) {

            $q->where('name_ar', 'like', "%{$keyword}%")
                ->orWhere('name_en', 'like', "%{$keyword}%")
                ->orWhere('description_ar', 'like', "%{$keyword}%")
                ->orWhere('description_en', 'like', "%{$keyword}%")
                ->orWhere('location_ar', 'like', "%{$keyword}%")
                ->orWhere('location_en', 'like', "%{$keyword}%")

                ->orWhereHas(
                    'sector',
                    fn($s) =>
                    $s->where('name_ar', 'like', "%{$keyword}%")
                        ->orWhere('name_en', 'like', "%{$keyword}%")
                )

                ->orWhereHas(
                    'units',
                    fn($u) =>
                    $u->where('unit_type', 'like', "%{$keyword}%")
                        ->orWhere('finishing_type', 'like', "%{$keyword}%")
                )

                ->orWhereHas(
                    'features',
                    fn($f) =>
                    $f->where('title_ar', 'like', "%{$keyword}%")
                        ->orWhere('title_en', 'like', "%{$keyword}%")
                        ->orWhere('value', 'like', "%{$keyword}%")
                )

                ->orWhereHas(
                    'tags',
                    fn($t) =>
                    $t->where('name', 'like', "%{$keyword}%")
                );
        });
    }
}