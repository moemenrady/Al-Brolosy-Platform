<?php

use App\Http\Controllers\FounderController;
use Illuminate\Support\Facades\Route;

Route::get('/founders/salah', [FounderController::class,'salah'])->name('founders.salah');
Route::get('/founders/ghanem', [FounderController::class,'ghanem'])->name('founders.ghanem');