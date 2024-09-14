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
        Route::post('store', [CompanyController::class, 'store'])->name('company.store');
        Route::delete('delete/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');
        Route::get('edit/{id}', [CompanyController::class, 'edit'])->name('company.edit');
        Route::post('update', [CompanyController::class, 'update'])->name('company.update');
    });

    Route::get('employees', [EmployeeController::class, 'index'])->name('employee.index');

});

Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
