<?php

namespace App\Services;

use App\Models\Client;
use App\Models\ClientHistory;
use Illuminate\Database\Eloquent\Collection;

class ClientHistoryService
{
    public function create(array $data): ClientHistory
    {
        return ClientHistory::create($data);
    }

    public function timeline(Client $client): Collection
    {
        return $client->histories()->with(['employee', 'smartCard'])->latest('created_at')->get();
    }

    public function latest(Client $client, int $limit = 10): Collection
    {
        return $client->histories()->latest('created_at')->limit($limit)->get();
    }

    public function statistics(Client $client): array
    {
        return [
            'total' => $client->histories()->count(),
            'follow_ups' => $client->histories()->where('type', 'follow_up')->count(),
            'notes' => $client->histories()->where('type', 'note')->count(),
        ];
    }

    public function notes(Client $client): Collection
    {
        return $client->histories()->where('type', 'note')->latest()->get();
    }

    public function calls(Client $client): Collection
    {
        return $client->histories()->whereIn('type', ['phone_call', 'whatsapp'])->latest()->get();
    }

    public function meetings(Client $client): Collection
    {
        return $client->histories()->where('type', 'meeting')->latest()->get();
    }

    public function visits(Client $client): Collection
    {
        return $client->histories()->where('type', 'visit')->latest()->get();
    }

    public function payments(Client $client): Collection
    {
        return $client->histories()->where('type', 'payment')->latest()->get();
    }

    public function contracts(Client $client): Collection
    {
        return $client->histories()->whereIn('type', ['contract', 'contract_signed'])->latest()->get();
    }

    public function smartCards(Client $client): Collection
    {
        return $client->histories()->whereNotNull('smart_card_id')->latest()->get();
    }

    public function followUps(Client $client): Collection
    {
        return $client->histories()->where('type', 'follow_up')->latest()->get();
    }
}
