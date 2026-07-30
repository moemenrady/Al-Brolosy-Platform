<?php

namespace App\Services\Search\Searchers;

interface SearcherInterface
{
    /**
     * @return array<int, \App\DTO\SearchResult>
     */
    public function search(array $filters): array;
}
