<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('/checkout/success/{order}', fn($order) => "Order #$order created");

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.index');
Route::get('/checkout/preview', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/submit', [CheckoutController::class, 'submit'])->name('checkout.submit');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
