<?php

use App\Http\Controllers\Admin\ProjectController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        Route::resource('projects', ProjectController::class);

        Route::patch(
            'projects/{project}/toggle-active',
            [ProjectController::class, 'toggleActive']
        )
            ->name('projects.toggle-active');

        Route::patch(
            'projects/{project}/toggle-featured',
            [ProjectController::class, 'toggleFeatured']
        )
            ->name('projects.toggle-featured');

        Route::post(
            'projects/reorder',
            [ProjectController::class, 'reorder']
        )
            ->name('projects.reorder');
    });
