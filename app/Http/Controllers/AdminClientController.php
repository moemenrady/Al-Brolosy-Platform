<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use Illuminate\Http\Request;

class AdminClientController extends Controller
{
    public function __construct(protected ClientService $clientService)
    {
    }

    public function index()
    {
        return response()->json($this->clientService->dashboard());
    }

    public function search(Request $request)
    {
        return response()->json($this->clientService->search($request->query('q', '')));
    }
}
