<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PositionController extends Controller
{
    public function index(): Response
    {
        $positions = Position::withCount('employees')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Positions/Index', [
            'positions' => $positions,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Positions/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:positions,code'],
            'description' => ['nullable', 'string'],
        ]);

        Position::create($validated);

        return redirect()
            ->route('positions.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit(Position $position): Response
    {
        return Inertia::render('Positions/Edit', [
            'position' => $position,
        ]);
    }

    public function update(
        Request $request,
        Position $position
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'required',
                'string',
                'max:255',
                'unique:positions,code,' . $position->id,
            ],
            'description' => ['nullable', 'string'],
        ]);

        $position->update($validated);

        return redirect()
            ->route('positions.index')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy(Position $position): RedirectResponse
    {
        if ($position->employees()->exists()) {
            return redirect()
                ->route('positions.index')
                ->with('error', 'Jabatan tidak dapat dihapus karena masih memiliki karyawan.');
        }

        $position->delete();

        return redirect()
            ->route('positions.index')
            ->with('success', 'Jabatan berhasil dihapus.');
    }
}