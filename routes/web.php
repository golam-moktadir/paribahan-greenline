<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BoothController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\OffenceController;
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

// Guide Routes
Route::prefix('dashboard/guides')->name('guides.')->group(function () {
    // CRUD Operations
    Route::get('/', [GuideController::class, 'index'])->name('index');
    Route::get('/create', [GuideController::class, 'create'])->name('create');
    Route::post('/', [GuideController::class, 'store'])->name('store');
    Route::get('/{guide}', [GuideController::class, 'show'])->name('show');
    Route::get('/{guide}/edit', [GuideController::class, 'edit'])->name('edit');
    Route::put('/{guide}', [GuideController::class, 'update'])->name('update');
    Route::delete('/{guide}', [GuideController::class, 'destroy'])->name('destroy');

    // Additional Actions
    Route::delete('/force-delete/{guide}', [GuideController::class, 'forceDelete'])->name('forceDelete');
    Route::put('/{guide}/status', [GuideController::class, 'updateStatus'])->name('status.update');
});

// Booths Routes
Route::prefix('dashboard/booths')->name('booths.')->group(function () {
    Route::get('/', [BoothController::class, 'index'])->name('index');
    Route::post('/get-station', [BoothController::class, 'getAllStation'])->name('getStation');
    Route::get('/create', [BoothController::class, 'create'])->name('create');
    Route::post('/', [BoothController::class, 'store'])->name('store');
    Route::get('/{id}', [BoothController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [BoothController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BoothController::class, 'update'])->name('update');
    Route::delete('/{id}', [BoothController::class, 'destroy'])->name('destroy');
    Route::delete('/force-delete/{id}', [BoothController::class, 'forceDelete'])->name('forceDelete');
    Route::put('/{id}/status', [BoothController::class, 'updateStatus'])->name('status.update');


    Route::patch('/{booth}/toggle', [BoothController::class, 'toggle'])->name('toggle');

});

Route::prefix('dashboard/offences')->name('offences.')->group(function () {
    // CRUD Operations
    Route::get('/', [OffenceController::class, 'index'])->name('index');
    Route::get('/create', [OffenceController::class, 'create'])->name('create');
    Route::post('/', [OffenceController::class, 'store'])->name('store');
    Route::get('/{offence}', [OffenceController::class, 'show'])->name('show');
    Route::get('/{offence}/edit', [OffenceController::class, 'edit'])->name('edit');
    Route::put('/{offence}', [OffenceController::class, 'update'])->name('update');
    Route::delete('/{offence}', [OffenceController::class, 'destroy'])->name('destroy');

    // Additional Actions
    Route::delete('/force-delete/{offence}', [OffenceController::class, 'forceDelete'])->name('forceDelete');
    Route::put('/{offence}/status', [OffenceController::class, 'updateStatus'])->name('status.update');

    // Offence attachments delete
    Route::delete('{offence}/attachments/{attachment}', [OffenceController::class, 'attachmentDelete'])->name('attachmentDelete');
});

// });

Route::prefix('dashboard/stations')->name('stations.')->group(function () {
    Route::get('/', [StationController::class, 'index'])->name('index');
    Route::get('/create', [StationController::class, 'create'])->name('create');    
    Route::post('/', [StationController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [StationController::class, 'edit'])->name('edit');
    Route::put('/{id}', [StationController::class, 'update'])->name('update');
});

Route::prefix('dashboard/cities')->name('cities.')->group(function () {
    Route::get('/', [CityController::class, 'index'])->name('index');
    Route::get('/get-all-data', [CityController::class, 'getAllData'])->name('getAllData');
    Route::get('/create', [CityController::class, 'create'])->name('create');    
    Route::post('/', [CityController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CityController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CityController::class, 'update'])->name('update');
    Route::delete('/{id}', [CityController::class, 'destroy'])->name('destroy');
});

Route::prefix('dashboard/routes')->name('routes.')->group(function () {
    Route::get('/', [RouteController::class, 'index'])->name('index');
    Route::get('/get-all-data', [RouteController::class, 'getAllData'])->name('getAllData');
    Route::get('/create', [RouteController::class, 'create'])->name('create');    
    Route::post('/', [RouteController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [RouteController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RouteController::class, 'update'])->name('update');
    Route::delete('/{id}', [RouteController::class, 'destroy'])->name('destroy');
    Route::patch('/{id}/toggle', [RouteController::class, 'toggle'])->name('toggle');    
});

Route::get('stations/{city_id}', function ($city_id) {
    return \App\Models\Station::where('city_id', $city_id)
        ->select('station_id as value', 'station_name as label')
        ->get();
});

