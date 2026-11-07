<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use App\Support\ImageStorage;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    public function index()
    {
        $carousels = Carousel::latest()->get();
        return view('admin.carousels.index', compact('carousels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['title', 'description']);

        if ($request->hasFile('image')) {
            $data['image'] = ImageStorage::store('carousels', $request->file('image'));
        }

        Carousel::create($data);

        return redirect()->back()->with('success', 'Banner carousel berhasil diunggah.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $carousel = Carousel::findOrFail($id);
        $data = $request->only(['title', 'description']);

        if ($request->hasFile('image')) {
            ImageStorage::delete($carousel->image);
            $data['image'] = ImageStorage::store('carousels', $request->file('image'));
        }

        $carousel->update($data);

        return redirect()->back()->with('success', 'Banner carousel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $carousel = Carousel::findOrFail($id);
        ImageStorage::delete($carousel->image);
        $carousel->delete();

        return redirect()->back()->with('success', 'Banner carousel berhasil dihapus.');
    }
}