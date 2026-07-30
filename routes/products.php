<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('products', [ProductController::class, 'allProducts'])->name('products.all');
Route::get('products/collection/{id}', [ProductController::class, 'collectionProducts'])->name('products.collection');

Route::get('products/{id}', [ProductController::class, 'show'])->name('product.show');
