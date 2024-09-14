<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

// админ панель
Route::prefix('admin')->group(function () {
    Route::prefix('companies')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('company.index');
        Route::get('create', [CompanyController::class, 'create'])->name('company.create');
        Route::get('edit/{id}', [CompanyController::class, 'edit'])->name('company.edit');
        Route::post('store', [CompanyController::class, 'store'])->name('company.store');
        Route::delete('delete/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');
        Route::post('update', [CompanyController::class, 'update'])->name('company.update');
    });

    Route::prefix('employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employee.index');
        Route::get('create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::get('edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::post('store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::post('update', [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
