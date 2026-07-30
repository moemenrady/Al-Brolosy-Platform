<?php

namespace App\Services\Search\Searchers;

use App\DTO\SearchResult;
use App\Models\Post;
use App\Models\PostContent;
use Illuminate\Support\Arr;

final class PostSearcher implements SearcherInterface
{
    public function search(array $filters): array
    {
        $keyword = Arr::get($filters, 'keyword');

        if (! $keyword) {
            return [];
        }

        $kw = "%{$keyword}%";

        $results = [];

        $postsTitle = Post::where('title', 'like', $kw)->limit(50)->get();
        foreach ($postsTitle as $p) {
            $results[] = new SearchResult(
                id: $p->id,
                type: 'post',
                title: $p->title,
                subtitle: null,
                description: $p->description,
                image: null,
                url: route('posts.show', $p->id),
                icon: 'file-text',
                badge: 'Post',
                score: 65,
                metadata: []
            );
        }

        $contentPostIds = PostContent::where('content', 'like', $kw)->pluck('post_id')->unique()->all();
        if (! empty($contentPostIds)) {
            $posts = Post::whereIn('id', $contentPostIds)->get();
            foreach ($posts as $p) {
                $results[] = new SearchResult(
                    id: $p->id,
                    type: 'post',
                    title: $p->title,
                    subtitle: null,
                    description: $p->description,
                    image: null,
                    url: route('posts.show', $p->id),
                    icon: 'file-text',
                    badge: 'Post',
                    score: 60,
                    metadata: []
                );
            }
        }

        return $results;
    }
}
