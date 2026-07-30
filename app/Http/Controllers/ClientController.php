<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(protected ClientService $clientService)
    {
    }

    public function index()
    {
        return response()->json($this->clientService->dashboard());
    }

    public function show(int $id)
    {
        return response()->json($this->clientService->find($id));
    }

    public function update(Request $request, int $id)
    {
        $client = $this->clientService->find($id);

        return response()->json($this->clientService->update($client, $request->all()));
    }

    public function destroy(int $id)
    {
        $client = $this->clientService->find($id);

        return response()->json(['deleted' => $this->clientService->delete($client)]);
    }
}
