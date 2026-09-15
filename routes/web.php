<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DepartmentController;

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

    Route::get('/departments', [DepartmentController::class, 'index'])
        ->middleware('permission:department.view')
        ->name('departments.index');
    
    Route::get('/departments/create', [DepartmentController::class, 'create'])
        ->middleware('permission:department.create')
        ->name('departments.create');
    
    Route::post('/departments', [DepartmentController::class, 'store'])
        ->middleware('permission:department.create')
        ->name('departments.store');
    
    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])
        ->middleware('permission:department.update')
        ->name('departments.edit');
    
    Route::put('/departments/{department}', [DepartmentController::class, 'update'])
        ->middleware('permission:department.update')
        ->name('departments.update');
    
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])
        ->middleware('permission:department.delete')
        ->name('departments.destroy');
});