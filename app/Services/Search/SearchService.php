<?php

namespace App\Services\Search;

use App\DTO\SearchResult;
use App\Services\Search\Searchers\ProjectSearcher;
use App\Services\Search\Searchers\SectorSearcher;
use App\Services\Search\Searchers\UnitSearcher;
use App\Services\Search\Searchers\PostSearcher;
use App\Services\Search\Searchers\MediaSearcher;
use App\Services\Search\Searchers\JobSearcher;
use App\Services\Search\Searchers\SmartCardSearcher;
use App\Services\Search\Searchers\LinkSearcher;
use Illuminate\Support\Collection;

final class SearchService
{
    public function __construct(
        private ProjectSearcher $projects,
        private SectorSearcher $sectors,
        private UnitSearcher $units,
        private PostSearcher $posts,
        private MediaSearcher $media,
        private JobSearcher $jobs,
        private SmartCardSearcher $cards,
        private LinkSearcher $links,
    ) {
    }

    public function search(array $filters): array
    {
        $start = hrtime(true);

        $all = [];

        foreach ([$this->projects, $this->sectors, $this->units, $this->posts, $this->media, $this->jobs, $this->links] as $searcher) {
            try {
                $res = $searcher->search($filters);
                $all = array_merge($all, $res);
            } catch (\Throwable $e) {
                // do not break search on single searcher failure
            }
        }

        // Smart cards only if allowed (searcher handles auth check)
        try {
            $all = array_merge($all, $this->cards->search($filters));
        } catch (\Throwable $e) {
        }

        // Deduplicate by type+id keeping highest score
        $map = [];
        /** @var SearchResult $item */
        foreach ($all as $item) {
            $key = $item->type.':'.$item->id;
            if (!isset($map[$key]) || $map[$key]->score < $item->score) {
                $map[$key] = $item;
            }
        }

        $results = array_values($map);

        usort($results, fn(SearchResult $a, SearchResult $b) => $b->score <=> $a->score);

        $arr = array_map(fn(SearchResult $r) => $r->toArray(), $results);

        $execution = (int) round((hrtime(true) - $start) / 1_000_000);

        return [
            'execution_time' => $execution,
            'total' => count($arr),
            'results' => $arr,
        ];
    }
}
