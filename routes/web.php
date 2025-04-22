<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page\HomePageController;
use App\Http\Controllers\Page\AuthenticationPageController;

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
