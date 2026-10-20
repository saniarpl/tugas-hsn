<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\GalleryController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/galeri', [HomeController::class, 'galleryPage'])->name('gallery');
Route::get('/berita/{news}', [HomeController::class, 'newsShow'])->whereNumber('news')->name('news.show');
Route::get('/kegiatan/{activity}', [HomeController::class, 'activityShow'])->whereNumber('activity')->name('activities.show');
Route::get('/organisasi/{slug}', [HomeController::class, 'organization'])->name('organization.detail');
Route::post('/saran', [HomeController::class, 'storeFeedback'])->middleware('throttle:5,10')->name('feedback.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('carousels', CarouselController::class);
    Route::resource('news', NewsController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('committees', CommitteeController::class);
    Route::resource('members', MemberController::class);
    Route::get('/members/{id}/card', [MemberController::class, 'show'])->name('members.card');
    Route::resource('donations', DonationController::class);
    Route::resource('galleries', GalleryController::class)->only(['index', 'store', 'destroy']);

    // Rute Feedback (Hanya read dan delete)
    Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::delete('/feedbacks/{id}', [FeedbackController::class, 'destroy'])->name('feedbacks.destroy');
});