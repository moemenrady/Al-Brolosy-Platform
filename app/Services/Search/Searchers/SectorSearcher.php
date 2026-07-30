<?php

namespace App\Services\Search\Searchers;

use App\DTO\SearchResult;
use App\Models\Sector;
use Illuminate\Support\Arr;

final class SectorSearcher implements SearcherInterface
{
    public function search(array $filters): array
    {
        $keyword = Arr::get($filters, 'keyword');

        $query = Sector::query()->where('is_active', true);

        if ($keyword) {
            $kw = "%{$keyword}%";
            $query->where(function ($q) use ($kw) {
                $q->where('name_ar', 'like', $kw)
                    ->orWhere('name_en', 'like', $kw)
                    ->orWhere('description_ar', 'like', $kw)
                    ->orWhere('description_en', 'like', $kw)
                    ->orWhere('slug', 'like', $kw);
            });
        }

        if (isset($filters['sector'])) {
            $query->where('id', $filters['sector']);
        }

        $list = $query->limit(50)->get();

        $results = [];
        foreach ($list as $s) {
            $results[] = new SearchResult(
                id: $s->id,
                type: 'sector',
                title: $s->getNameAttribute() ?? ($s->name_en ?: $s->name_ar),
                subtitle: null,
                description: $s->getDescriptionAttribute(),
                image: $s->image ?? $s->cover_image ?? null,
                url: route('sectors.show', $s->id),
                icon: 'layer-group',
                badge: 'Sector',
                score: 90,
                metadata: []
            );
        }

        return $results;
    }
}
