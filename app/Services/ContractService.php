<?php

namespace App\Services;

class ContractService
{
    public function create(array $data): array
    {
        return ['status' => 'ready_for_future_implementation'];
    }
}
