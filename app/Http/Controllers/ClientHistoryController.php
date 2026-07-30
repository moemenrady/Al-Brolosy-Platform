<?php

namespace App\Http\Controllers;

use App\Services\ClientHistoryService;
use Illuminate\Http\Request;

class ClientHistoryController extends Controller
{
    public function __construct(protected ClientHistoryService $historyService)
    {
    }

    public function index(Request $request)
    {
        $client = app(\App\Services\ClientService::class)->getCurrentClient();

        return response()->json($client ? $this->historyService->timeline($client) : []);
    }
}
