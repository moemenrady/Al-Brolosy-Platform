<?php

namespace App\Services;

use App\Models\Client;
use App\Models\ClientHistory;
use App\Models\Consultation;
use App\Models\Identity;
use Illuminate\Support\Facades\DB;

class ConsultationService
{
    public function store(array $data): Consultation
    {
        return DB::transaction(function () use ($data): Consultation {
            return Consultation::create($data);
        });
    }

    public function contact(array $data): Consultation
    {
        return $this->store($data);
    }

    public function convertToClient(Consultation $consultation): Client
    {
        return DB::transaction(function () use ($consultation): Client {
            $client = Client::create([
                'full_name' => $consultation->name,
                'phone' => $consultation->phone,
                'preferred_contact' => $consultation->preferred_contact,
                'email' => null,
            ]);

            ClientHistory::create([
                'client_id' => $client->id,
                'type' => 'consultation',
                'status' => 'completed',
                'title' => 'Consultation Converted',
                'description' => 'Consultation converted into a client profile.',
                'visible_to_client' => true,
            ]);

            return $client;
        });
    }

    public function statistics(): array
    {
        return [
            'total' => Consultation::query()->count(),
            'contacted' => Consultation::query()->where('status', 'contacted')->count(),
        ];
    }
}
