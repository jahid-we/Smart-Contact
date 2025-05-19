<?php

use App\Http\Controllers\Page\AuthenticationPageController;
use App\Http\Controllers\Page\ContactPageController;
use App\Http\Controllers\Page\DashboardPageController;
use App\Http\Controllers\Page\HomePageController;
use App\Http\Controllers\Page\UserPageController;
use App\Http\Controllers\Page\UserProfilePageController;
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

});
// =========================================================
// =============== Contact Page  Routes ====================
// =========================================================
Route::middleware('sessionAuth')->controller(ContactPageController::class)->group(function () {

    Route::get('/contact', 'Contact')->name('contact');

});

// =========================================================
// =============== User  Page  Routes ====================
// =========================================================
Route::middleware('sessionAuth')->controller(UserPageController::class)->group(function () {

    Route::get('/userPage', 'userPage')->name('userPage');

});

// =========================================================
// =============== User profile Page  Routes ====================
// =========================================================
Route::middleware('sessionAuth')->controller(UserProfilePageController::class)->group(function () {

    Route::get('/userProfile', 'UserProfile')->name('userProfile');

});
