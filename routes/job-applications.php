
<?php

use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::post(
        '/jobs/{job}/apply',
        [JobApplicationController::class, 'store']
    )->name('jobs.apply');

    Route::get(
        '/my-applications',
        [JobApplicationController::class, 'myApplications']
    )->name('jobs.applications');

    Route::get(
        '/my-applications/{application}',
        [JobApplicationController::class, 'show']
    )->name('jobs.application.show');
});
