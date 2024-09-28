<?php

use Illuminate\Support\Facades\Route;
// Middleware
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\LoginAuthMiddleware;
// Controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesignationsController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\CitiesController;

Route::middleware([LoginAuthMiddleware::class])->group(function () {
    Route::group(['prefix'=>'/','as' => 'auth.'],function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'auth_login']);
        Route::get('forget-password', [AuthController::class, 'forget_password'])->name('forget_password');
    });
});

Route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard', [DashboardController::class, 'index']);
    
    // Designations
    Route::group(['prefix'=>'designations','as' => 'designations.'],function () {
        Route::get('/', [DesignationsController::class, 'index'])->name('list');
        Route::post('/', [DesignationsController::class, 'data']);
    
        Route::get('/select', [DesignationsController::class, 'select'])->name('select');
        
        Route::get('/add', [DesignationsController::class, 'create'])->name('add');
        Route::post('/add', [DesignationsController::class, 'store']);
        
        Route::get('/edit/{id}', [DesignationsController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [DesignationsController::class, 'update']);
        
        Route::get('/delete/{id}', [DesignationsController::class, 'destroy'])->name('delete');
    
    });
    
    // Departments
    Route::group(['prefix'=>'departments','as' => 'departments.'],function () {
        Route::get('/', [DepartmentsController::class, 'index'])->name('list');
        Route::post('/', [DepartmentsController::class, 'data']);
    
        Route::get('/select', [DepartmentsController::class, 'select'])->name('select');
    
        Route::get('/add', [DepartmentsController::class, 'create'])->name('add');
        Route::post('/add', [DepartmentsController::class, 'store']);
        
        Route::get('/edit/{id}', [DepartmentsController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [DepartmentsController::class, 'update']);
        
        Route::get('/delete/{id}', [DepartmentsController::class, 'destroy'])->name('delete');
    
    });
    
    // Countries
    Route::group(['prefix'=>'countries','as' => 'countries.'],function () {
        Route::get('/select', [CountriesController::class, 'select'])->name('select');
    });
    
    // States
    Route::group(['prefix'=>'states','as' => 'states.'],function () {
        Route::get('/select', [StatesController::class, 'select'])->name('select');
    });
    
    // Cities
    Route::group(['prefix'=>'cities','as' => 'cities.'],function () {
        Route::get('/select', [CitiesController::class, 'select'])->name('select');
    });
    
    // Employees
    Route::group(['prefix'=>'employees','as' => 'employees.'],function () {
        Route::get('/', [EmployeesController::class, 'index'])->name('list');
        Route::post('/', [EmployeesController::class, 'data']);
        
        Route::get('/add', [EmployeesController::class, 'create'])->name('add');
        Route::post('/add', [EmployeesController::class, 'store']);
        
        Route::get('/edit/{id}', [EmployeesController::class, 'edit'])->name('edit');
        Route::post('/edit/{employee_id}/{user_id}', [EmployeesController::class, 'update'])->name('udpate');
        Route::post('/login_detail_update/{user_id}', [EmployeesController::class, 'login_detail_update'])->name('login_detail_update');
        Route::post('/change_profile/{employee_id}', [EmployeesController::class, 'change_profile'])->name('change_profile');
        
        Route::get('/delete/{employee_id}', [EmployeesController::class, 'destroy'])->name('delete');
    
    });
});


