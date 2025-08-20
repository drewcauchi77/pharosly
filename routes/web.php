<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('modules', ModuleController::class);
    Route::resource('workspaces', WorkspaceController::class)->except(['create', 'show']);
});

require __DIR__.'/auth.php';
