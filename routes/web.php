<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'permission:employee.view'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])
        ->middleware('permission:employee.view')
        ->name('employees.index');

    Route::get('/employees/create', [EmployeeController::class, 'create'])
        ->middleware('permission:employee.create')
        ->name('employees.create');

    Route::post('/employees', [EmployeeController::class, 'store'])
        ->middleware('permission:employee.create')
        ->name('employees.store');

    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])
        ->middleware('permission:employee.update')
        ->name('employees.edit');

    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])
        ->middleware('permission:employee.update')
        ->name('employees.update');

    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])
        ->middleware('permission:employee.delete')
        ->name('employees.destroy');
});