<?php

namespace App\Services;

use App\Models\Client;
use App\Models\ClientHistory;
use App\Models\Identity;
use App\Models\SmartCard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ClientService
{
    public function registerInterest(array $data, Identity $identity): Client
    {
        return DB::transaction(function () use ($data, $identity): Client {
            $client = Client::updateOrCreate(
                ['identity_id' => $identity->id],
                array_merge($data, ['identity_id' => $identity->id])
            );

            ClientHistory::create([
                'client_id' => $client->id,
                'type' => 'interest_registered',
                'status' => 'completed',
                'title' => 'Interest Registered',
                'description' => 'A new interest was registered.',
                'visible_to_client' => true,
                'meta' => ['source' => $data['source'] ?? 'web'],
            ]);

            return $client;
        });
    }

    public function getCurrentClient(): ?Client
    {
        $identity = request()->attributes->get('identity');

        if (! $identity) {
            return null;
        }

        return Client::query()->where('identity_id', $identity->id)->first();
    }

    public function find(int $id): Client
    {
        return Client::query()->with(['identity', 'smartCards', 'histories'])->findOrFail($id);
    }

    public function findByIdentity(int $identityId): ?Client
    {
        return Client::query()->where('identity_id', $identityId)->first();
    }

    public function findByPhone(string $phone): ?Client
    {
        return Client::query()->where('phone', $phone)->first();
    }

    public function findByEmail(string $email): ?Client
    {
        return Client::query()->where('email', $email)->first();
    }

    public function update(Client $client, array $data): Client
    {
        return DB::transaction(function () use ($client, $data): Client {
            $client->fill($data);
            $client->save();

            ClientHistory::create([
                'client_id' => $client->id,
                'type' => 'profile_updated',
                'status' => 'completed',
                'title' => 'Profile Updated',
                'description' => 'Client profile updated.',
                'visible_to_client' => true,
            ]);

            return $client;
        });
    }

    public function delete(Client $client): bool
    {
        return $client->delete();
    }

    public function timeline(Client $client): Collection
    {
        return $client->histories()->with(['employee', 'smartCard'])->get();
    }

    public function statistics(Client $client): array
    {
        return [
            'history_count' => $client->histories()->count(),
            'smart_card_count' => $client->smartCards()->count(),
            'active_smart_card' => $client->smartCards()->where('status', 'active')->exists(),
        ];
    }

    public function dashboard(): array
    {
        return [
            'clients_count' => Client::query()->count(),
            'recent_clients' => Client::query()->latest()->take(5)->get(),
        ];
    }

    public function search(string $query): Collection
    {
        return Client::query()
            ->where('full_name', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->latest()
            ->get();
    }

    public function mergeGuestToUser(Identity $identity, int $userId): Client
    {
        $client = Client::query()->where('identity_id', $identity->id)->firstOrFail();
        $identity->update(['user_id' => $userId]);

        return $client;
    }

    public function getCurrentSmartCard(Client $client): ?
    SmartCard
    {
        return $client->smartCards()->latest()->first();
    }

    public function hasCard(Client $client): bool
    {
        return $client->smartCards()->exists();
    }

    public function canRequestCard(Client $client): bool
    {
        return app(SmartCardService::class)->canRequest($client);
    }

    public function recentActivities(Client $client): Collection
    {
        return $client->histories()->latest()->take(10)->get();
    }
}
