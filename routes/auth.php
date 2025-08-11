<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'show'])->name('login.show');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
