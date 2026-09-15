<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeController extends Controller
{
    public function index(): Response
    {
        $employees = Employee::with(['user', 'department', 'position'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Employees/Index', [
            'employees' => $employees,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Employees/Create', [
            'departments' => Department::orderBy('name')->get(),
            'positions' => Position::orderBy('name')->get(),
            'users' => User::doesntHave('employee')
                ->orderBy('name')
                ->get(['id', 'name', 'email']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_number' => ['required', 'string', 'max:255', 'unique:employees,employee_number'],
            'user_id' => ['required', 'integer', 'exists:users,id', 'unique:employees,user_id'],
            'phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', 'in:male,female'],
            'hire_date' => ['required', 'date'],
            'employment_status' => ['required', 'in:permanent,contract,intern,probation,resigned'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'position_id' => ['required', 'integer', 'exists:positions,id'],
        ]);

        Employee::create($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function edit(Employee $employee): Response
    {
        $employee->load(['user', 'department', 'position']);

        return Inertia::render('Employees/Edit', [
            'employee' => $employee,
            'departments' => Department::orderBy('name')->get(),
            'positions' => Position::orderBy('name')->get(),
            'users' => User::where(function ($query) use ($employee) {
                $query->whereDoesntHave('employee')
                    ->orWhere('id', $employee->user_id);
            })
                ->orderBy('name')
                ->get(['id', 'name', 'email']),
        ]);
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $validated = $request->validate([
            'employee_number' => [
                'required',
                'string',
                'max:255',
                'unique:employees,employee_number,' . $employee->id,
            ],
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
                'unique:employees,user_id,' . $employee->id,
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'gender' => ['nullable', 'in:male,female'],
            'hire_date' => ['required', 'date'],
            'employment_status' => ['required', 'in:permanent,contract,intern,probation,resigned'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'position_id' => ['required', 'integer', 'exists:positions,id'],
        ]);

        $employee->update($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}