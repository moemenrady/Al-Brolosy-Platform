
<?php


use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('projects', [ProjectController::class, 'index']);
Route::get('projects/index', [ProjectController::class, 'index'])->name('projects.index');

Route::get('projects/{id}', [ProjectController::class, 'show'])
    ->name('projects.show');
