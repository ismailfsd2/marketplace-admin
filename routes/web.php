<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesignationsController;

Route::group(['prefix'=>'/','as' => 'auth.'],function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('forget-password', [AuthController::class, 'forget_password'])->name('forget_password');
});

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard', [DashboardController::class, 'index']);

// Designations
Route::group(['prefix'=>'designations','as' => 'designations.'],function () {
    Route::get('/', [DesignationsController::class, 'index'])->name('list');
    Route::post('/', [DesignationsController::class, 'data']);
    
    Route::get('/add', [DesignationsController::class, 'create'])->name('add');
    Route::post('/add', [DesignationsController::class, 'store']);
    
    Route::get('/edit/{id}', [DesignationsController::class, 'edit'])->name('edit');
    Route::post('/edit/{id}', [DesignationsController::class, 'update']);
    
    Route::post('/delete/{id}', [DesignationsController::class, 'destroy'])->name('delete');

});


