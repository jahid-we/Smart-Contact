<?php

use App\Http\Controllers\Page\AuthenticationPageController;
use App\Http\Controllers\Page\DashboardPageController;
use App\Http\Controllers\Page\HomePageController;
use Illuminate\Support\Facades\Route;

// =========================================================
// =============== Home Page  Routes ====================
// =========================================================
Route::controller(HomePageController::class)->group(function () {

    Route::get('/', 'Home')->name('home');

});

// =========================================================
// =============== Authentication Page  Routes ====================
// =========================================================
Route::controller(AuthenticationPageController::class)->group(function () {

    Route::get('/LoginForm', 'LoginForm')->name('loginForm');
    Route::get('/OtpForm', 'OtpForm')->name('otpForm');

});

// =========================================================
// =============== Dashboard Page  Routes ====================
// =========================================================
Route::controller(DashboardPageController::class)->group(function () {

    Route::get('/dashboard', 'Dashboard')->name('dashboard');

});
