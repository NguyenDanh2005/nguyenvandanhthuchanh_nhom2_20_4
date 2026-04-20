<?php

/*
 * Họ tên: Nguyễn Văn A
 * Mã sinh viên: 20201234
 * Lớp: D18CNPM2
 */

use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;

// Trang đăng nhập
Route::get('/login', fn () => view('auth.login'))->name('login');

// OAuth routes: redirect & callback cho Google và Facebook
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');

// Đăng xuất
Route::post('/logout', [SocialAuthController::class, 'logout'])->name('logout');

// Dashboard - chỉ truy cập khi đã đăng nhập
Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard')->middleware('auth');

// Redirect trang chủ về login
Route::get('/', fn () => redirect()->route('login'));
