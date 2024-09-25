<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesignationsController;
use App\Http\Controllers\DepartmentsController;

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

// Departments
Route::group(['prefix'=>'departments','as' => 'departments.'],function () {
    Route::get('/', [DepartmentsController::class, 'index'])->name('list');
    Route::post('/', [DepartmentsController::class, 'data']);
    
    Route::get('/add', [DepartmentsController::class, 'create'])->name('add');
    Route::post('/add', [DepartmentsController::class, 'store']);
    
    Route::get('/edit/{id}', [DepartmentsController::class, 'edit'])->name('edit');
    Route::post('/edit/{id}', [DepartmentsController::class, 'update']);
    
    Route::post('/delete/{id}', [DepartmentsController::class, 'destroy'])->name('delete');

});


