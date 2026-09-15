<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DepartmentController extends Controller
{
    public function index(): Response
    {
        $departments = Department::withCount('employees')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Departments/Index', [
            'departments' => $departments,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Departments/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:departments,code'],
            'description' => ['nullable', 'string'],
        ]);

        Department::create($validated);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit(Department $department): Response
    {
        return Inertia::render('Departments/Edit', [
            'department' => $department,
        ]);
    }

    public function update(
        Request $request,
        Department $department
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'required',
                'string',
                'max:255',
                'unique:departments,code,' . $department->id,
            ],
            'description' => ['nullable', 'string'],
        ]);

        $department->update($validated);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        if ($department->employees()->exists()) {
            return redirect()
                ->route('departments.index')
                ->with('error', 'Departemen tidak dapat dihapus karena masih memiliki karyawan.');
        }
    
        $department->delete();
    
        return redirect()
            ->route('departments.index')
            ->with('success', 'Departemen berhasil dihapus.');
    }
}