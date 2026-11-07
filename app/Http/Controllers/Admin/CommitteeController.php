<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Support\ImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommitteeController extends Controller
{
    public function index(): View
    {
        $committees = Committee::latest()->get();

        return view('admin.committees.index', compact('committees'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // period wajib karena kolomnya NOT NULL; image adalah nama kolom foto.
        $data = $request->only(['name', 'position', 'organization', 'period', 'type']);

        if ($request->hasFile('image')) {
            $data['image'] = ImageStorage::store('committees', $request->file('image'));
        }

        Committee::create($data);

        return redirect()->back()->with('success', 'Data pengurus berhasil ditambahkan.');
    }

    public function update(Request $request, Committee $committee): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'position', 'organization', 'period', 'type']);

        if ($request->hasFile('image')) {
            ImageStorage::delete($committee->image);
            $data['image'] = ImageStorage::store('committees', $request->file('image'));
        }

        $committee->update($data);

        return redirect()->back()->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy(Committee $committee): RedirectResponse
    {
        ImageStorage::delete($committee->image);
        $committee->delete();

        return redirect()->back()->with('success', 'Data pengurus berhasil dihapus.');
    }
}
