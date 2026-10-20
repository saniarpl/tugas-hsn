<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::orderBy('date', 'desc')->get();
        return view('admin.donations.index', compact('donations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
        ]);

        Donation::create($request->only(['name', 'amount', 'date']));

        return redirect()->back()->with('success', 'Data infaq berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
        ]);

        $donation = Donation::findOrFail($id);
        $donation->update($request->only(['name', 'amount', 'date']));

        return redirect()->back()->with('success', 'Data infaq berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();

        return redirect()->back()->with('success', 'Data infaq berhasil dihapus.');
    }
}