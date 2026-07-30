<?php

use App\Http\Controllers\ClientInterestController;
use Illuminate\Support\Facades\Route;

Route::post('/api/v1/client/register-interest', [ClientInterestController::class, 'store'])
    ->middleware(\App\Http\Middleware\IdentifyUser::class);
Route::get('/client/profile', [ClientInterestController::class, 'show'])
    ->middleware(\App\Http\Middleware\IdentifyUser::class)->name('client.profile');
