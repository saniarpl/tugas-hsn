<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->get();

        return view('admin.members.index', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'nik', 'phone', 'address']);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $path = $photo->store('member-photos', 'public');
            $data['photo'] = $path;
        }

        Member::create($data);

        return redirect()->back()->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $member = Member::findOrFail($id);
        $data = $request->only(['name', 'nik', 'phone', 'address']);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }

            $photo = $request->file('photo');
            $path = $photo->store('member-photos', 'public');
            $data['photo'] = $path;
        }

        $member->update($data);

        return redirect()->back()->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }

        $member->delete();

        return redirect()->back()->with('success', 'Data warga berhasil dihapus.');
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);

        return view('admin.members.card', compact('member'));
    }
}
