<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\CctvCityController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cctv', [PagesController::class, 'cctv'])->name('cctv');
Route::get('/electricity', [PagesController::class, 'electricity'])->name('electricity');
Route::get('/fire-alarm', [PagesController::class, 'fireAlarm'])->name('fire-alarm');
Route::get('/network', [PagesController::class, 'network'])->name('network');
Route::get('/project', [PagesController::class, 'project'])->name('project');
Route::get('/security-alarm', [PagesController::class, 'securityAlarm'])->name('security-alarm');

Route::get('/services/{service}', [PagesController::class, 'showService'])->name('service.show');

Route::middleware('auth')->group(function () {
    Route::resource('cctv-city', CctvCityController::class)->except(['show']);
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/home', function () {
    return redirect()->route('profile');
});
