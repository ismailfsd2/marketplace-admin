<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::group(['prefix'=>'/','as' => 'auth.'],function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('forget-password', [AuthController::class, 'forget_password'])->name('forget_password');
});

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard', [DashboardController::class, 'index']);

