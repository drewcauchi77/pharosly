<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login.create');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');

    Route::get('register', [RegisterController::class, 'create'])->name('register.create');
    Route::post('register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('forgot-password', [ForgotPasswordController::class, 'create'])->name('forgot-password.create');
    Route::post('forgot-password', [ForgotPasswordController::class, 'create'])->name('forgot-password.store');
});

Route::middleware('auth')->group(function () {
    Route::delete('login', [LoginController::class, 'destroy'])->name('login.destroy');
});
