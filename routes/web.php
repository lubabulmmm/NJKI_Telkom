<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\DashboardController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Auth as AuthService;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\InvestmentArchiveController;

Route::post('/archive', [ArchiveController::class, 'store']);

Route::get('/calculator', [CalculatorController::class, 'index']);
// Public routes
Route::get('/items', [CalculatorController::class, 'getItems']);
Route::get('/bandwidth/{itemId}', [CalculatorController::class, 'getBandwidth']);
Route::post('/calculate-total', [CalculatorController::class, 'calculateTotal']);
Route::get('/', function () {
    return view('auth.login');
});

// Middleware to ensure the user is authenticated
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
   
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');


    // Routes for users with the 'user' role
    Route::middleware([CheckRole::class . ':user'])->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', function () {
            return view('user.dashboard');
        })->name('dashboard');
        Route::get('/calculator', function () {
            return view('user.calculator');
        })->name('calculator');
        Route::get('/calculator', [InvestmentController::class, 'showCalculator'])->name('calculator');
        Route::post('/calculate', [InvestmentController::class, 'calculate'])->name('calculate');
        Route::get('/api/items', [InvestmentController::class, 'getItems']);
        Route::get('/api/bandwidth/{item}', [InvestmentController::class, 'getBandwidths']);
        Route::post('/api/save-archive', [InvestmentController::class, 'saveArchive']);
        
        // User Investment Archive Routes
       Route::prefix('investment/archive')->name('investment.archive.')->group(function () {
        Route::get('/', [InvestmentArchiveController::class, 'index'])->name('index');
        Route::get('/{archive}', [InvestmentArchiveController::class, 'show'])->name('show');
        Route::get('/{archive}/edit', [InvestmentArchiveController::class, 'edit'])->name('edit');
        Route::put('/{archive}', [InvestmentArchiveController::class, 'update'])->name('update');
        Route::delete('/{archive}', [InvestmentArchiveController::class, 'destroy'])->name('destroy');
        Route::get('/investment/archive/{archive}/export', [InvestmentArchiveController::class, 'export'])
    ->name('export');
    });
    });

    // Routes for users with the 'superadmin' role
    Route::middleware([CheckRole::class . ':superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
// routes/web.php
Route::get('/superadmin/dashboard', [SuperadminController::class, 'showDashboard'])
    ->name('superadmin.dashboard');
        Route::get('/users', function () {
            return view('superadmin.users.index');
        })->name('users');

        Route::get('/dashboard', [SuperadminController::class, 'showDashboard'])->name('dashboard');

        // Bandwidth and items routes
        Route::get('/bandwidth', [SuperadminController::class, 'showBandwidthData'])->name('bandwidth');
        Route::get('/users', [SuperadminController::class, 'showUserData'])->name('users');
        Route::get('/items', [SuperadminController::class, 'showItemsData'])->name('items');
        
        // Bandwidth management routes
        Route::delete('/bandwidth/{itemId}/{bandwidthId}', [SuperadminController::class, 'destroy'])->name('bandwidth.delete');
        Route::get('/bandwidth/create', [SuperadminController::class, 'create'])->name('bandwidth.create');
        Route::post('/bandwidth', [SuperadminController::class, 'store'])->name('bandwidth.store');
        Route::get('/bandwidth/edit/{itemId}/{bandwidthId}', [SuperadminController::class, 'edit'])->name('bandwidth.edit');
        Route::put('/bandwidth/update/{itemId}/{bandwidthId}', [SuperadminController::class, 'update'])->name('bandwidth.update');
        // Route::delete('/bandwidth/{itemId}/{bandwidthId}', [SuperadminController::class, 'delete'])->name('bandwidth.delete');
        Route::delete('/bandwidth/{itemId}/{bandwidthId}', [SuperadminController::class, 'delete'])->name('bandwidth.delete');

        // User management routes
        Route::get('/users/create', [SuperadminController::class, 'showAddUserForm'])->name('users.create');
        Route::post('/users', [SuperadminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}/edit', [SuperadminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [SuperadminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [SuperadminController::class, 'deleteUser'])->name('users.delete');

        // Item management routes
        Route::get('/items/create', [SuperadminController::class, 'showAddItemForm'])->name('items.create');
        Route::post('/items', [SuperadminController::class, 'storeItem'])->name('items.store');
        Route::get('/items/edit/{id}', [SuperadminController::class, 'showEditItemForm'])->name('items.edit');
        Route::put('/items/{id}', [SuperadminController::class, 'updateItem'])->name('items.update');
        Route::delete('/items/{id}', [SuperadminController::class, 'deleteItem'])->name('items.delete');
    
        // Superadmin Investment Archive Routes
        Route::prefix('investment/archives')->name('investment.archive.')->group(function () {
            Route::get('/', [InvestmentArchiveController::class, 'index'])->name('index');
            Route::get('/{archive}', [InvestmentArchiveController::class, 'show'])->name('show');
            Route::delete('/{archive}', [InvestmentArchiveController::class, 'destroy'])->name('destroy');
            // Add this route for the export functionality
            Route::get('/{archive}/export', [InvestmentArchiveController::class, 'export'])->name('export');
        });
    });

    // Route redirection based on user role after login
    Route::get('/dashboard', function () {
        // Ensure the user is authenticated
        if (!AuthService::check()) {
            return redirect()->route('login');
        }

        return redirect()->route(Auth::user()->role . '.dashboard');
    })->name('dashboard');
});

Route::get('/api/investment-data', [InvestmentController::class, 'getInvestmentData'])
    ->name('api.investment-data')
    ->middleware('auth');