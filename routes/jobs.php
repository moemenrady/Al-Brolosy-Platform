<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('jobs/index', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
