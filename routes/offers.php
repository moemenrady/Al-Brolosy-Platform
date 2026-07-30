
<?php


use App\Http\Controllers\OfferController;

Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');