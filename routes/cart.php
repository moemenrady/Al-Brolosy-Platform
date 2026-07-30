<?php

use App\Http\Controllers\CartController;

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name("cart.index"); // جلب محتويات Cart

    Route::get('/api', [CartController::class, 'indexApi'])->name("cart.indexApi"); // جلب محتويات Cart
    Route::post('/api-add', [CartController::class, 'addApi'])->name("cart.addApi"); // إضافة منتج
    Route::post('/buy-product', [CartController::class, 'buyProduct'])->name("cart.buy-product"); // إضافة منتج
    Route::post('/api-update/{item}', [CartController::class, 'updateApi'])->name("cart.updateApi"); // تحديث كمية
    Route::delete('/api-remove/{item}', [CartController::class, 'removeApi'])->name("cart.removeApi"); // إزالة منتج
});
