<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Support\ImageStorage;
use Illuminate\Http\Request;

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

        $imagePath = ImageStorage::store('galleries', $request->file('image'));
        Gallery::create(['title' => $request->title, 'image' => $imagePath]);

        return redirect()->back()->with('success', 'Foto berhasil diunggah.');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        ImageStorage::delete($gallery->image);
        $gallery->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }
}