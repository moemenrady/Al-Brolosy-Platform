<?php

namespace App\Services\Search\Searchers;

use App\DTO\SearchResult;
use App\Models\MediaPost;
use App\Models\MediaContent;
use Illuminate\Support\Arr;

final class MediaSearcher implements SearcherInterface
{
    public function search(array $filters): array
    {
        $keyword = Arr::get($filters, 'keyword');

        if (! $keyword) {
            return [];
        }

        $kw = "%{$keyword}%";

        $results = [];

        $posts = MediaPost::where('title_ar', 'like', $kw)
            ->orWhere('title_en', 'like', $kw)
            ->orWhere('short_description_ar', 'like', $kw)
            ->orWhere('short_description_en', 'like', $kw)
            ->limit(50)
            ->get();

        foreach ($posts as $p) {
            $results[] = new SearchResult(
                id: $p->id,
                type: 'media',
                title: $p->title,
                subtitle: null,
                description: $p->short_description,
                image: $p->cover_image ?? null,
                url: route('media.show', $p->id),
                icon: 'image',
                badge: 'Media',
                score: 55,
                metadata: []
            );
        }

        $mediaPostIds = MediaContent::where('content_ar', 'like', $kw)
            ->orWhere('content_en', 'like', $kw)
            ->pluck('media_post_id')
            ->unique()
            ->all();

        if (! empty($mediaPostIds)) {
            $posts = MediaPost::whereIn('id', $mediaPostIds)->get();
            foreach ($posts as $p) {
                $results[] = new SearchResult(
                    id: $p->id,
                    type: 'media',
                    title: $p->title,
                    subtitle: null,
                    description: $p->short_description,
                    image: $p->cover_image ?? null,
                    url: route('media.show', $p->id),
                    icon: 'image',
                    badge: 'Media',
                    score: 50,
                    metadata: []
                );
            }
        }

        return $results;
    }
}
