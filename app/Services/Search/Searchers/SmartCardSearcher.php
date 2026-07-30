<?php

namespace App\Services\Search\Searchers;

use App\DTO\SearchResult;
use App\Models\SmartCard;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

final class SmartCardSearcher implements SearcherInterface
{
    public function search(array $filters): array
    {
        // Only search smart cards for authenticated users
        $user = Auth::user();
        if (! $user) {
            return [];
        }

        $clientId = $user->identity?->client?->id ?? null;
        if (! $clientId) {
            return [];
        }

        $keyword = Arr::get($filters, 'keyword');
        $query = SmartCard::query()->where('client_id', $clientId);

        if ($keyword) {
            $kw = "%{$keyword}%";
            $query->where('card_number', 'like', $kw);
        }

        $list = $query->limit(50)->get();

        $results = [];
        foreach ($list as $c) {
            $results[] = new SearchResult(
                id: $c->id,
                type: 'smart_card',
                title: $c->card_number,
                subtitle: null,
                description: null,
                image: null,
                url: null,
                icon: 'credit-card',
                badge: 'Card',
                score: 25,
                metadata: []
            );
        }

        return $results;
    }
}
