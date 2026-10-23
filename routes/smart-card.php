<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SmartCardController;
use Illuminate\Support\Facades\Route;

// Route to display the contact form
Route::get('/smart-card', [ContactController::class, 'showForm'])->name('smart-card.form');

// Route to handle the form submission and send the email
Route::post('/smart-card/apply', [SmartCardController::class, 'apply'])->name('smart-card.apply');