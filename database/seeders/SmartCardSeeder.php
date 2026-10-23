<?php

namespace Database\Seeders;

use App\Models\SmartCard;
use Illuminate\Database\Seeder;

class SmartCardSeeder extends Seeder
{
    public function run(): void
    {
        $cards = [];

        for ($i = 1000; $i < 1500; $i++) {
            $cards[] = [
                'card_number' => 'ALB-SMART-' . $i,
                'status' => 'pending',
                'client_id' => null,
                'approved_at' => null,
                'activated_at' => null,
                'blocked_at' => null,
                'rejected_at' => null,
                'status_note' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (SmartCard::count() === 0) {
            SmartCard::insert($cards);
        }
    }
}
