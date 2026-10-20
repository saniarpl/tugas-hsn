<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['title', 'content']);
        // Kolom NOT NULL (slug unik, category, author) diisi otomatis & aman dari input liar
        $data['slug'] = static::uniqueSlug($request->input('title'));
        $data['category'] = 'Umum';
        $data['author'] = $request->user()->name ?? 'Admin';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->back()->with('success', 'Berita berhasil diterbitkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $item = News::findOrFail($id);
        $data = $request->only(['title', 'content']);

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $item->update($data);

        return redirect()->back()->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Buat slug unik dari judul (abaikan input slug dari user agar stabil & aman).
     */
    protected static function uniqueSlug(?string $title): string
    {
        $base = Str::limit(Str::slug((string) $title, '-'), 200, '');
        $base = $base !== '' ? $base : 'berita';
        $slug = $base;
        $i = 1;
        while (News::where('slug', $slug)->exists()) {
            $slug = $base.'-'.(++$i);
        }

        return $slug;
    }

    public function destroy($id)
    {
        $item = News::findOrFail($id);
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        $item->delete();

        return redirect()->back()->with('success', 'Berita berhasil dihapus.');
    }
}