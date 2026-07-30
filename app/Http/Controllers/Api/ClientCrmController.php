<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\ClientHistoryService;
use App\Services\ClientService;
use App\Services\SmartCardService;
use Illuminate\Http\Request;

class ClientCrmController extends Controller
{
    public function __construct(
        protected ClientService $clientService,
        protected SmartCardService $smartCardService,
        protected ClientHistoryService $historyService,
    ) {}

    public function profile(): \Illuminate\Http\JsonResponse
    {
        $client = $this->clientService->getCurrentClient();

        return response()->json($client ? $client->load(['smartCards', 'histories']) : null);
    }

    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $client = $this->clientService->getCurrentClient();

        if (! $client) {
            return response()->json(['message' => 'Client not found.'], 404);
        }

        return response()->json($this->clientService->update($client, $request->all()));
    }

    public function history(): \Illuminate\Http\JsonResponse
    {
        $client = $this->clientService->getCurrentClient();

        return response()->json($client ? $this->historyService->timeline($client) : []);
    }

    public function statistics(): \Illuminate\Http\JsonResponse
    {
        $client = $this->clientService->getCurrentClient();

        return response()->json($client ? $this->clientService->statistics($client) : []);
    }

    public function smartCard(): \Illuminate\Http\JsonResponse
    {
        $client = $this->clientService->getCurrentClient();

        $card = $client ? $this->smartCardService->current($client) : null;

        return response()->json([
            'card' => $card,
        ]);
    }

    public function smartCardStatus(): \Illuminate\Http\JsonResponse
    {
        $client = $this->clientService->getCurrentClient();

        return response()->json(['status' => $this->smartCardService->status($client)]);
    }

    public function smartCardHistory(): \Illuminate\Http\JsonResponse
    {
        $client = $this->clientService->getCurrentClient();

        return response()->json($client ? $this->smartCardService->timeline($client) : []);
    }

    public function canRequestCard(): \Illuminate\Http\JsonResponse
    {
        $client = $this->clientService->getCurrentClient();

        return response()->json(['can_request' => $client ? $this->clientService->canRequestCard($client) : false]);
    }

    public function requestCard(): \Illuminate\Http\JsonResponse
    {
        $client = $this->clientService->getCurrentClient();

        if (! $client) {
            return response()->json(['message' => 'Client not found.'], 404);
        }

        return response()->json($this->smartCardService->request($client));
    }

    public function cancelCardRequest(): \Illuminate\Http\JsonResponse
    {
        $client = $this->clientService->getCurrentClient();

        if (! $client) {
            return response()->json(['message' => 'Client not found.'], 404);
        }

        $card = $this->smartCardService->current($client);

        if (! $card) {
            return response()->json(['message' => 'No smart card request to cancel.'], 404);
        }

        return response()->json($this->smartCardService->cancelRequest($card));
    }
}
