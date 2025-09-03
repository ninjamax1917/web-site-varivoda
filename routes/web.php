<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StreamingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MediaMtxAuthController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ServiceCardController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Страница политики конфиденциальности
Route::view('/policy', 'policy')->name('policy');

Route::get('/cctv', [PagesController::class, 'cctv'])->name('cctv');
Route::get('/electricity', [PagesController::class, 'electricity'])->name('electricity');
Route::get('/fire-alarm', [PagesController::class, 'fireAlarm'])->name('fire-alarm');
Route::get('/network', [PagesController::class, 'network'])->name('network');
Route::get('/project', [PagesController::class, 'project'])->name('project');
Route::get('/security-alarm', [PagesController::class, 'securityAlarm'])->name('security-alarm');

Route::get('/services/{service}', [PagesController::class, 'showService'])->name('service.show');

Route::resource('cctv-city', StreamingController::class)->except(['show']);

Route::middleware('auth')->group(function () {
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

    // Пользователи: список и блокировка трансляций
    Route::get('/auth/users', [AdminUserController::class, 'index'])->name('auth.users.index');
    Route::post('/auth/users/{user}/toggle', [AdminUserController::class, 'toggle'])->name('auth.users.toggle');

    // Карточки услуг (слайдеры)
    Route::get('/auth/service-cards', [ServiceCardController::class, 'index'])->name('auth.service_cards.index');
    Route::get('/auth/service-cards/create', [ServiceCardController::class, 'create'])->name('auth.service_cards.create');
    Route::post('/auth/service-cards', [ServiceCardController::class, 'store'])->name('auth.service_cards.store');
    Route::get('/auth/service-cards/{service_card}/edit', [ServiceCardController::class, 'edit'])->name('auth.service_cards.edit');
    Route::put('/auth/service-cards/{service_card}', [ServiceCardController::class, 'update'])->name('auth.service_cards.update');
    Route::delete('/auth/service-cards/{service_card}', [ServiceCardController::class, 'destroy'])->name('auth.service_cards.destroy');
});

// MediaMTX Control API auth webhook (HTTP-based auth) — публичный маршрут без CSRF
Route::post('/api/mediamtx/auth', [MediaMtxAuthController::class, '__invoke'])
    ->withoutMiddleware([VerifyCsrfToken::class]);

// Клиентский endpoint для отключения cookie (soft-disable: не выходит из аккаунта)
Route::post('/cookies/disable', function () {
    // Soft disable: не делаем logout, устанавливаем server-side cookie_consent=deny
    $deny = cookie('cookie_consent', 'deny', 60 * 24 * 365);
    // удалить возможную клиентскую куку cookie_consent
    $forgetConsent = cookie()->forget('cookie_consent');
    return response()->json(['status' => 'ok'])->withCookie($deny)->withCookie($forgetConsent);
})->name('cookies.disable');
