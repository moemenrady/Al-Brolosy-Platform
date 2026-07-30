<?php

namespace App\Services\Search\Searchers;

use App\DTO\SearchResult;
use App\Models\Job;
use Illuminate\Support\Arr;

final class JobSearcher implements SearcherInterface
{
    public function search(array $filters): array
    {
        $keyword = Arr::get($filters, 'keyword');

        if (! $keyword) {
            return [];
        }

        $kw = "%{$keyword}%";

        $list = Job::where('title_ar', 'like', $kw)
            ->orWhere('title_en', 'like', $kw)
            ->orWhere('description_ar', 'like', $kw)
            ->orWhere('description_en', 'like', $kw)
            ->orWhere('required_skills_ar', 'like', $kw)
            ->orWhere('required_skills_en', 'like', $kw)
            ->limit(50)
            ->get();

        $results = [];
        foreach ($list as $j) {
            $score = 40;
            // bump if title matched
            if (str_contains($j->title_ar . ' ' . $j->title_en, $keyword ?? '')) {
                $score = 40;
            }
            $results[] = new SearchResult(
                id: $j->id,
                type: 'job',
                title: $j->title,
                subtitle: $j->getLocationAttribute() ?? null,
                description: $j->getDescriptionAttribute(),
                image: null,
                url: route('jobs.show', $j->id),
                icon: 'briefcase',
                badge: 'Job',
                score: $score,
                metadata: []
            );
        }

        return $results;
    }
}
