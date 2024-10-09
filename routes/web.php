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
use App\Http\Controllers\TaxesController;
use App\Http\Controllers\DiscountsController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\FieldGroupsController;
use App\Http\Controllers\FieldsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CurrenciesController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\PointOfContactsController;

Route::middleware([LoginAuthMiddleware::class])->group(function () {
    Route::group(['prefix'=>'/','as' => 'auth.'],function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'auth_login']);

        Route::get('forget-password', [AuthController::class, 'forget_password'])->name('forget_password');
    });
});

Route::middleware([AuthMiddleware::class])->group(function () {

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    
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

    // Taxes
    Route::group(['prefix'=>'taxes','as' => 'taxes.'],function () {
        Route::get('/', [TaxesController::class, 'index'])->name('list');
        Route::post('/', [TaxesController::class, 'data']);
    
        Route::get('/select', [TaxesController::class, 'select'])->name('select');
    
        Route::get('/add', [TaxesController::class, 'create'])->name('add');
        Route::post('/add', [TaxesController::class, 'store']);
        
        Route::get('/edit/{id}', [TaxesController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [TaxesController::class, 'update']);
        
        Route::get('/delete/{id}', [TaxesController::class, 'destroy'])->name('delete');
    
    });

    // Discounts
    Route::group(['prefix'=>'discounts','as' => 'discounts.'],function () {
        Route::get('/', [DiscountsController::class, 'index'])->name('list');
        Route::post('/', [DiscountsController::class, 'data']);
    
        Route::get('/select', [DiscountsController::class, 'select'])->name('select');
    
        Route::get('/add', [DiscountsController::class, 'create'])->name('add');
        Route::post('/add', [DiscountsController::class, 'store']);
        
        Route::get('/edit/{id}', [DiscountsController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [DiscountsController::class, 'update']);
        
        Route::get('/delete/{id}', [DiscountsController::class, 'destroy'])->name('delete');
    
    });

    // Units
    Route::group(['prefix'=>'units','as' => 'units.'],function () {
        Route::get('/', [UnitsController::class, 'index'])->name('list');
        Route::post('/', [UnitsController::class, 'data']);
    
        Route::get('/select', [UnitsController::class, 'select'])->name('select');
    
        Route::get('/add', [UnitsController::class, 'create'])->name('add');
        Route::post('/add', [UnitsController::class, 'store']);
        
        Route::get('/edit/{id}', [UnitsController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [UnitsController::class, 'update']);
        
        Route::get('/delete/{id}', [UnitsController::class, 'destroy'])->name('delete');
    
    });
    
    // Brands
    Route::group(['prefix'=>'brands','as' => 'brands.'],function () {
        Route::get('/', [BrandsController::class, 'index'])->name('list');
        Route::post('/', [BrandsController::class, 'data']);
    
        Route::get('/select', [BrandsController::class, 'select'])->name('select');
    
        Route::get('/add', [BrandsController::class, 'create'])->name('add');
        Route::post('/add', [BrandsController::class, 'store']);
        
        Route::get('/edit/{id}', [BrandsController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [BrandsController::class, 'update']);
        
        Route::get('/delete/{id}', [BrandsController::class, 'destroy'])->name('delete');
    
    });
    
    // Field Groups
    Route::group(['prefix'=>'field_groups','as' => 'field_groups.'],function () {
        Route::get('/', [FieldGroupsController::class, 'index'])->name('list');
        Route::post('/', [FieldGroupsController::class, 'data']);
    
        Route::get('/select', [FieldGroupsController::class, 'select'])->name('select');
    
        Route::get('/add', [FieldGroupsController::class, 'create'])->name('add');
        Route::post('/add', [FieldGroupsController::class, 'store']);
        
        Route::get('/edit/{id}', [FieldGroupsController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [FieldGroupsController::class, 'update']);
        
        Route::get('/delete/{id}', [FieldGroupsController::class, 'destroy'])->name('delete');

        Route::group(['prefix'=>'fields','as' => 'fields.'],function () {
            Route::get('/{id}', [FieldsController::class, 'index'])->name('list');
            Route::post('/{id}', [FieldsController::class, 'data']);

            Route::get('/add/{id}', [FieldsController::class, 'create'])->name('add');
            Route::post('/add/{id}', [FieldsController::class, 'store']);
        
            Route::get('/edit/{id}', [FieldsController::class, 'edit'])->name('edit');
            Route::post('/edit/{id}', [FieldsController::class, 'update']);
            
            Route::get('/delete/{id}', [FieldsController::class, 'destroy'])->name('delete');
    
        });
    });

    // Categories
    Route::group(['prefix'=>'categories','as' => 'categories.'],function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('list');
        Route::post('/', [CategoriesController::class, 'data']);
    
        Route::get('/select', [CategoriesController::class, 'select'])->name('select');
    
        Route::get('/add', [CategoriesController::class, 'create'])->name('add');
        Route::post('/add', [CategoriesController::class, 'store']);
        
        Route::get('/edit/{id}', [CategoriesController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [CategoriesController::class, 'update']);
        
        Route::get('/delete/{id}', [CategoriesController::class, 'destroy'])->name('delete');
    
    });

    // Currencies
    Route::group(['prefix'=>'currencies','as' => 'currencies.'],function () {
        Route::get('/', [CurrenciesController::class, 'index'])->name('list');
        Route::post('/', [CurrenciesController::class, 'data']);
    
        Route::get('/select', [CurrenciesController::class, 'select'])->name('select');
    
        Route::get('/add', [CurrenciesController::class, 'create'])->name('add');
        Route::post('/add', [CurrenciesController::class, 'store']);
        
        Route::get('/edit/{id}', [CurrenciesController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [CurrenciesController::class, 'update']);
        
        Route::get('/delete/{id}', [CurrenciesController::class, 'destroy'])->name('delete');
    
    });

    // Suppliers
    Route::group(['prefix'=>'suppliers','as' => 'suppliers.'],function () {

        Route::get('/', [SuppliersController::class, 'index'])->name('list');
        Route::post('/', [SuppliersController::class, 'data']);
        
        Route::get('/add', [SuppliersController::class, 'create'])->name('add');
        Route::post('/add', [SuppliersController::class, 'store']);
        
        Route::get('/edit/{id}', [SuppliersController::class, 'edit'])->name('edit');
        Route::post('/edit/{supplier_id}/{user_id}', [SuppliersController::class, 'update'])->name('udpate');

        Route::post('/create_login_account/{supplier_id}', [SuppliersController::class, 'create_login_account'])->name('create_login_account');
        Route::post('/login_detail_update/{user_id}', [SuppliersController::class, 'login_detail_update'])->name('login_detail_update');

        Route::post('/change_profile/{supplier_id}', [SuppliersController::class, 'change_profile'])->name('change_profile');
        
        Route::get('/delete/{supplier_id}', [SuppliersController::class, 'destroy'])->name('delete');
    
    });

    // Point of Contacts
    Route::group(['prefix'=>'point_of_contacts','as' => 'point_of_contacts.'],function () {
        Route::get('/{supplier_id}', [PointOfContactsController::class, 'index'])->name('list');
        Route::post('/{supplier_id}', [PointOfContactsController::class, 'data']);
    
        Route::get('/select/{supplier_id}', [PointOfContactsController::class, 'select'])->name('select');
    
        Route::get('/add/{supplier_id}', [PointOfContactsController::class, 'create'])->name('add');
        Route::post('/add/{supplier_id}', [PointOfContactsController::class, 'store']);
        
        Route::get('/edit/{id}', [PointOfContactsController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [PointOfContactsController::class, 'update']);
        
        Route::get('/delete/{id}', [PointOfContactsController::class, 'destroy'])->name('delete');
    
    });

});


