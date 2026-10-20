<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = $request->file('image')->store('galleries', 'public');
        Gallery::create(['title' => $request->title, 'image' => $imagePath]);

        return redirect()->back()->with('success', 'Foto berhasil diunggah.');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }
}