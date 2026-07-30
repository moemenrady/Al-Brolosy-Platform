<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientInterestController;

use Illuminate\Support\Facades\Route;

// routes/admin

Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
  Route::get('/clients', [ClientInterestController::class, 'index'])->name('clients.index');
  Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

  Route::get('products/create', [AdminController::class, 'addProduct'])->name('products.create');
  Route::post('products/store', [AdminController::class, 'storeProduct'])->name('products.store');
  Route::get('products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
  Route::put('/admin/products/{product}', [AdminController::class, 'updateProduct'])
    ->name('admin.products.update');
  Route::put('products/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
  Route::delete('products/{id}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
  Route::get('collections/create', [AdminController::class, 'addCollection'])->name('collections.create')->middleware('admin');
  Route::post('collections/store', [AdminController::class, 'storeCollection'])->name('collections.store')->middleware('admin');
  Route::delete('/collections/{id}', [AdminController::class, 'destroyCollection'])
    ->name('collections.destroy');
  Route::get('collections/{id}', [AdminController::class, 'showCollection'])->name('collections.show')->middleware('admin');

  Route::get('/orders', [AdminController::class, 'indexOrders'])->name('orders.index');
  Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('orders.show');
  Route::put('/orders/{id}/status', [AdminController::class, 'updateStatusOrder'])->name('orders.updateStatus');

  Route::get('hero', [AdminController::class, 'editHeroImage'])
    ->name('hero.edit');
  Route::post('hero', [AdminController::class, 'updateHeroImage'])
    ->name('hero.update');
  Route::get('users/index', [AdminController::class, 'indexUsers'])->name('users.index')->middleware('admin');
  Route::delete('users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
});
