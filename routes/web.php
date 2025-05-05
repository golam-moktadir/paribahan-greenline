<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dev', [TestController::class, 'dev']);


// Route::middleware(['auth', 'verified'])->group(function () {

// Main Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// Employees Routes
Route::prefix('dashboard/employees')->name('employees.')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('create');
    Route::post('/', [EmployeeController::class, 'store'])->name('store');
    Route::get('/{employee}', [EmployeeController::class, 'show'])->name('show');
    Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
    Route::put('/{employee}', [EmployeeController::class, 'update'])->name('update');
    Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
    Route::delete('/force-delete/{employee}', [EmployeeController::class, 'forceDelete'])->name('forceDelete');

    // Additional Employee Routes
    Route::get('/{employee}/profile', [EmployeeController::class, 'profile'])->name('profile');
    Route::put('/{employee}/status', [EmployeeController::class, 'updateStatus'])->name('status.update');

});

// Drivers Routes
Route::prefix('dashboard/drivers')->name('drivers.')->group(function () {
    Route::get('/', [DriverController::class, 'index'])->name('index');
    Route::get('/create', [DriverController::class, 'create'])->name('create');
    Route::post('/', [DriverController::class, 'store'])->name('store');
    Route::get('/{id}', [DriverController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [DriverController::class, 'edit'])->name('edit');
    Route::put('/{id}', [DriverController::class, 'update'])->name('update');
    Route::delete('/{id}', [DriverController::class, 'destroy'])->name('destroy');
    Route::delete('/force-delete/{id}', [DriverController::class, 'forceDelete'])->name('forceDelete');

    Route::put('/{id}/status', [DriverController::class, 'updateStatus'])->name('status.update');
});

// });

