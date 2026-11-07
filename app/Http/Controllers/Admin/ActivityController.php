<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Support\ImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(): View
    {
        $activities = Activity::latest()->get();

        return view('admin.activities.index', compact('activities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // location ikut disimpan karena kolomnya wajib pada skema lama.
        $data = $request->only(['title', 'date', 'location', 'description']);

        if ($request->hasFile('image')) {
            $data['image'] = ImageStorage::store('activities', $request->file('image'));
        }

        Activity::create($data);

        return redirect()->back()->with('success', 'Agenda kegiatan berhasil disimpan.');
    }

    public function update(Request $request, Activity $activity): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['title', 'date', 'location', 'description']);

        if ($request->hasFile('image')) {
            ImageStorage::delete($activity->image);
            $data['image'] = ImageStorage::store('activities', $request->file('image'));
        }

        $activity->update($data);

        return redirect()->back()->with('success', 'Agenda kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        ImageStorage::delete($activity->image);
        $activity->delete();

        return redirect()->back()->with('success', 'Agenda kegiatan berhasil dihapus.');
    }
}
