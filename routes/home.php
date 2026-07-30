<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/search/results', [HomeController::class, 'results'])->name('search.results');