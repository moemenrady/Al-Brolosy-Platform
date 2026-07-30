<?php
use App\Http\Controllers\OrderController ;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// مسارات العميل
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// مسارات الأدمن
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [AdminController::class, 'ordersIndex'])->name('orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'orderShow'])->name('order.show');
});