<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommitteeController extends Controller
{
    public function index()
    {
        $committees = Committee::latest()->get();
        return view('admin.committees.index', compact('committees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'organization' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'position', 'organization']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('committees', 'public');
        }

        Committee::create($data);

        return redirect()->back()->with('success', 'Data pengurus berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'organization' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $committee = Committee::findOrFail($id);
        $data = $request->only(['name', 'position', 'organization']);

        if ($request->hasFile('image')) {
            if ($committee->image) {
                Storage::disk('public')->delete($committee->image);
            }
            $data['image'] = $request->file('image')->store('committees', 'public');
        }

        $committee->update($data);

        return redirect()->back()->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $committee = Committee::findOrFail($id);
        if ($committee->image) {
            Storage::disk('public')->delete($committee->image);
        }
        $committee->delete();

        return redirect()->back()->with('success', 'Data pengurus berhasil dihapus.');
    }
}