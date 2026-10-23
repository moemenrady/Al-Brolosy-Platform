<?php

namespace App\Services\Search\Searchers;

use App\DTO\SearchResult;
use App\Models\ProjectUnitType;
use Illuminate\Support\Arr;

final class UnitSearcher implements SearcherInterface
{
    public function search(array $filters): array
    {
        $keyword = Arr::get($filters, 'keyword');

        $query = ProjectUnitType::query();

        if ($keyword) {
            $kw = "%{$keyword}%";
            $query->where(function ($q) use ($kw) {
                $q->where('unit_type', 'like', $kw)
                    ->orWhere('finishing_type', 'like', $kw)
                    ->orWhere('floor', 'like', $kw)
                    ->orWhere('area', 'like', $kw)
                    ->orWhere('unit_price', 'like', $kw)
                    ->orWhere('price_per_meter', 'like', $kw);
            });
        }

        if (isset($filters['unit_type'])) {
            $query->where('unit_type', $filters['unit_type']);
        }

        if (isset($filters['area'])) {
            $query->where('area', '<=', $filters['area']);
        }

        if (isset($filters['budget'])) {
            $query->where('unit_price', '<=', $filters['budget']);
        }

        $list = $query->with('project')->limit(100)->get();

        $results = [];
        foreach ($list as $u) {
            $title = $u->unit_type ?: ('Unit Type ' . $u->id);
            $subtitle = $u->project?->name_en ?? $u->project?->name_ar ?? null;
            $score = 85;
            $results[] = new SearchResult(
                id: $u->id,
                type: 'unit',
                title: $title,
                subtitle: $subtitle,
                description: null,
                image: null,
                url: route('units.show', $u->id),
                icon: 'home',
                badge: 'Unit',
                score: $score,
                metadata: [
                    'project_id' => $u->project_id,
                ]
            );
        }

        return $results;
    }
}
