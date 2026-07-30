<?php

namespace App\Http\Controllers;

use App\Services\SmartCardService;
use Illuminate\Http\Request;

class SmartCardController extends Controller
{
    public function __construct(protected SmartCardService $smartCardService)
    {
    }

    public function index()
    {
        return response()->json($this->smartCardService->all());
    }

    public function show(int $id)
    {
        return response()->json($this->smartCardService->find($id));
    }
}
