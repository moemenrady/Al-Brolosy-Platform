<?php

namespace App\Services\Search\Searchers;

use App\DTO\SearchResult;
use App\Models\Link;
use Illuminate\Support\Arr;

final class LinkSearcher implements SearcherInterface
{
    public function search(array $filters): array
    {
        $keyword = Arr::get($filters, 'keyword');

        $query = Link::query();

        if ($keyword) {
            $kw = "%{$keyword}%";
            $query->where('name', 'like', $kw)
                ->orWhere('url', 'like', $kw);
        }

        $list = $query->limit(50)->get();

        $results = [];
        foreach ($list as $l) {
            $results[] = new SearchResult(
                id: $l->id,
                type: 'link',
                title: $l->name,
                subtitle: null,
                description: $l->url,
                image: null,
                url: $l->url,
                icon: $l->icon ?? 'link',
                badge: 'Link',
                score: 30,
                metadata: []
            );
        }

        return $results;
    }
}
