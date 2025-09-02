<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StreamingController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cctv', [PagesController::class, 'cctv'])->name('cctv');
Route::get('/electricity', [PagesController::class, 'electricity'])->name('electricity');
Route::get('/fire-alarm', [PagesController::class, 'fireAlarm'])->name('fire-alarm');
Route::get('/network', [PagesController::class, 'network'])->name('network');
Route::get('/project', [PagesController::class, 'project'])->name('project');
Route::get('/security-alarm', [PagesController::class, 'securityAlarm'])->name('security-alarm');

Route::get('/services/{service}', [PagesController::class, 'showService'])->name('service.show');

Route::middleware('auth')->group(function () {
    Route::resource('cctv-city', StreamingController::class)->except(['show']);
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');

    Route::post('/profile/avatar/upload', [ProfileController::class, 'update'])->name('profile.avatar.upload');

    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.delete');
});

Route::get('/home', function () {
    return redirect()->route('profile');
});

// Маршруты для администратора
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/cameras/create', [AdminController::class, 'create'])->name('admin.cameras.create');
    Route::post('/admin/cameras', [AdminController::class, 'store'])->name('admin.cameras.store');
    Route::delete('/admin/cameras/{camera}', [AdminController::class, 'destroy'])->name('admin.cameras.destroy');
});
