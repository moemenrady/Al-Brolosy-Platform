<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
{
    $offers = \App\Models\Offer::where('is_active', true)
                ->where(function($query) {
                    $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
                })->get();
    return view('home', compact('offers')); // بفرض أن السيكشن جزء من الهوم
}
}
