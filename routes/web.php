<?php

use App\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', []);
})->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('modules', ModuleController::class);
});

require __DIR__.'/auth.php';
