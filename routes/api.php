<?php

use App\Http\Controllers\Api\ClientCrmController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/search', [SearchController::class, 'search']);

Route::middleware(['web'])->group(function () {
    Route::get('/me/client', [ClientCrmController::class, 'profile']);
    Route::put('/me/client', [ClientCrmController::class, 'update']);
    Route::get('/me/history', [ClientCrmController::class, 'history']);
    Route::get('/me/statistics', [ClientCrmController::class, 'statistics']);
    Route::get('/me/smart-card', [ClientCrmController::class, 'smartCard']);
    Route::get('/me/smart-card/status', [ClientCrmController::class, 'smartCardStatus']);
    Route::get('/me/smart-card/history', [ClientCrmController::class, 'smartCardHistory']);
    Route::get('/me/smart-card/can-request', [ClientCrmController::class, 'canRequestCard']);
    Route::post('/me/smart-card/request', [ClientCrmController::class, 'requestCard']);
    Route::delete('/me/smart-card/request', [ClientCrmController::class, 'cancelCardRequest']);
});

Route::middleware(['web'])->prefix('admin')->group(function () {
    Route::get('/clients', [\App\Http\Controllers\ClientController::class, 'index']);
    Route::get('/clients/search', [\App\Http\Controllers\AdminClientController::class, 'search']);
    Route::get('/clients/statistics', [\App\Http\Controllers\AdminClientController::class, 'index']);
    Route::get('/cards', [\App\Http\Controllers\AdminSmartCardController::class, 'index']);
    Route::get('/cards/pending', [\App\Http\Controllers\AdminSmartCardController::class, 'pending']);
    Route::get('/cards/under-review', [\App\Http\Controllers\AdminSmartCardController::class, 'underReview']);
    Route::get('/cards/approved', [\App\Http\Controllers\AdminSmartCardController::class, 'approved']);
    Route::get('/cards/active', [\App\Http\Controllers\AdminSmartCardController::class, 'active']);
    Route::get('/cards/rejected', [\App\Http\Controllers\AdminSmartCardController::class, 'rejected']);
    Route::get('/cards/blocked', [\App\Http\Controllers\AdminSmartCardController::class, 'blocked']);
    Route::get('/cards/expired', [\App\Http\Controllers\AdminSmartCardController::class, 'expired']);
    Route::get('/cards/cancelled', [\App\Http\Controllers\AdminSmartCardController::class, 'cancelled']);
    Route::get('/cards/{card}', [\App\Http\Controllers\AdminSmartCardController::class, 'show']);
    Route::patch('/cards/{card}/review', [\App\Http\Controllers\AdminSmartCardController::class, 'review']);
    Route::patch('/cards/{card}/approve', [\App\Http\Controllers\AdminSmartCardController::class, 'approve']);
    Route::patch('/cards/{card}/activate', [\App\Http\Controllers\AdminSmartCardController::class, 'activate']);
    Route::patch('/cards/{card}/reject', [\App\Http\Controllers\AdminSmartCardController::class, 'reject']);
    Route::patch('/cards/{card}/block', [\App\Http\Controllers\AdminSmartCardController::class, 'block']);
    Route::patch('/cards/{card}/unblock', [\App\Http\Controllers\AdminSmartCardController::class, 'unblock']);
    Route::patch('/cards/{card}/expire', [\App\Http\Controllers\AdminSmartCardController::class, 'expire']);
    Route::patch('/cards/{card}/cancel', [\App\Http\Controllers\AdminSmartCardController::class, 'cancel']);
    Route::delete('/cards/{card}', [\App\Http\Controllers\AdminSmartCardController::class, 'destroy']);
});