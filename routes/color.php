<?php

use App\Http\Controllers\ColorController;

// Route to display the contact form
Route::get('/nearest-color', [ColorController::class, 'colorPick'])->name('color.pick');
Route::post('/nearest-scarves', [ColorController::class, 'nearestScarves'])
  ->name('color.nearest');
