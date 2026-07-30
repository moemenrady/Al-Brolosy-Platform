
<?php


use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;

Route::get('/media/show/{post}', [MediaController::class, 'show'])
    ->name('media.show');

Route::get('/media', [MediaController::class, 'index'])
    ->name('media.index');