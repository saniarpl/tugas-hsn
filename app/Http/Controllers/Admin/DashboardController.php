<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\News; use App\Models\Member; use App\Models\Committee; use App\Models\Activity; use App\Models\Gallery;
class DashboardController extends Controller {
    public function index() {
        $data = ['news' => News::count(), 'members' => Member::count(), 'committees' => Committee::count(), 'activities' => Activity::count(), 'galleries' => Gallery::count()];
        return view('admin.dashboard', compact('data'));
    }
}