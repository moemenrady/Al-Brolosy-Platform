<?php

use App\Http\Controllers\ContactController;

// Route to display the contact form
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');

// Route to handle the form submission and send the email
Route::post('/contact-send-mail', [ContactController::class, 'sendEmail'])->name('contact.send');