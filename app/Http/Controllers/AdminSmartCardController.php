<?php

namespace App\Http\Controllers;

use App\Models\SmartCard;
use App\Services\SmartCardService;
use Illuminate\Http\Request;

class AdminSmartCardController extends Controller
{
    public function __construct(protected SmartCardService $smartCardService)
    {
    }

    public function index()
    {
        return response()->json($this->smartCardService->all());
    }

    public function pending()
    {
        return response()->json($this->smartCardService->pending());
    }

    public function underReview()
    {
        return response()->json($this->smartCardService->underReview());
    }

    public function active()
    {
        return response()->json($this->smartCardService->active());
    }

    public function rejected()
    {
        return response()->json($this->smartCardService->rejected());
    }

    public function blocked()
    {
        return response()->json($this->smartCardService->blocked());
    }

    public function expired()
    {
        return response()->json($this->smartCardService->expired());
    }

    public function cancelled()
    {
        return response()->json($this->smartCardService->cancelled());
    }

    public function show(SmartCard $card)
    {
        return response()->json($this->smartCardService->find($card->id));
    }

    public function review(SmartCard $card)
    {
        return response()->json($this->smartCardService->startReview($card));
    }

    public function approve(SmartCard $card)
    {
        return response()->json($this->smartCardService->approve($card));
    }

    public function activate(SmartCard $card)
    {
        return response()->json($this->smartCardService->activate($card));
    }

    public function reject(SmartCard $card, Request $request)
    {
        return response()->json($this->smartCardService->reject($card, $request->input('status_note')));
    }

    public function block(SmartCard $card, Request $request)
    {
        return response()->json($this->smartCardService->block($card, $request->input('status_note')));
    }

    public function unblock(SmartCard $card, Request $request)
    {
        return response()->json($this->smartCardService->unblock($card, $request->input('status_note')));
    }

    public function expire(SmartCard $card)
    {
        return response()->json($this->smartCardService->expire($card));
    }

    public function cancel(SmartCard $card)
    {
        return response()->json($this->smartCardService->cancel($card));
    }

    public function destroy(SmartCard $card)
    {
        return response()->json(['deleted' => $this->smartCardService->delete($card->id)]);
    }
}
