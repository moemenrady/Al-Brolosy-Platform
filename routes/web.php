<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'create']);
Route::get('collection/{id}', [CollectionController::class, 'collection'])->name('collection.show');
Route::get('search/', [HomeController::class, 'search'])->name('search');

// استدعاء ملف الـ product routes

require __DIR__ . '/home.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/user.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/order.php';
require __DIR__ . '/projects.php';
require __DIR__ . '/media.php';
require __DIR__ . '/jobs.php';
require __DIR__ . '/job-applications.php';
require __DIR__ . '/clients.php';
require __DIR__ . '/smart-card.php';
require __DIR__ . '/admin-projects.php';
require __DIR__ . '/founders.php';
require __DIR__ . '/contact.php';
