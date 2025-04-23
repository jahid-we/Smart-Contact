<?php

use App\Http\Controllers\Page\AuthenticationPageController;
use App\Http\Controllers\Page\DashboardPageController;
use App\Http\Controllers\Page\HomePageController;
use Illuminate\Support\Facades\Route;

// =========================================================
// =============== Home Page  Routes ====================
// =========================================================
Route::middleware('sessionAuth')->controller(HomePageController::class)->group(function () {

    Route::get('/', 'Home')->name('home');

});

// =========================================================
// =============== Authentication Page  Routes ====================
// =========================================================
Route::middleware('guest')->controller(AuthenticationPageController::class)->group(function () {

    Route::get('/LoginForm', 'LoginForm')->name('LoginForm');
    Route::get('/OtpForm', 'OtpForm')->name('OtpForm');

});

// =========================================================
// =============== Dashboard Page  Routes ====================
// =========================================================
Route::middleware('sessionAuth')->controller(DashboardPageController::class)->group(function () {

    Route::get('/dashboard', 'Dashboard')->name('dashboard');
    Route::get('/contact', 'Contact')->name('contact');

});
