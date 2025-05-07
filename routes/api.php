<?php

use App\Http\Controllers\authentication\authController;
use App\Http\Controllers\Contact\contactController;
use App\Http\Controllers\User\userController;
use App\Http\Controllers\UserProfile\userProfileController;
use Illuminate\Support\Facades\Route;

// =====================================================
// =============== Authentication Routes ===============
// =====================================================
Route::middleware('web')->controller(AuthController::class)
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::post('/login', 'userLogin')->name('login');           // Authenticate user using email
        Route::post('/verify-otp', 'verifyOTP')->name('verify-otp'); // Verify OTP for authentication
        Route::middleware('sessionAuth')->get('/logout', 'logout')->name('logout'); // Logout
    });

// =========================================================
// =============== Contact Management Routes ===============
// =========================================================
Route::middleware(['sessionAuth', 'web'])
    ->controller(ContactController::class)
    ->prefix('contact')
    ->name('contact.')
    ->group(function () {
        Route::post('/create', 'createContact')->name('create');
        Route::get('/list', 'contactList')->name('list');
        Route::post('/update/{id}', 'updateContact')->name('update');
        Route::post('/delete', 'deleteContact')->name('delete');
        Route::get('/listById', 'contactById')->name('view');
        Route::get('/latest', 'getLatestContact')->name('latest');
        Route::get('/count', 'contactCount')->name('count');
    });

// =========================================================
// =============== User Profile Routes ====================
// =========================================================
Route::middleware(['sessionAuth', 'web'])
    ->controller(userProfileController::class)
    ->prefix('profile')
    ->name('profile.')
    ->group(function () {
        Route::post('/create', 'createProfile')->name('create');
        Route::post('/update', 'updateProfile')->name('update');
        Route::get('/delete', 'deleteProfile')->name('delete');
        Route::get('/get', 'getProfile')->name('get');

    });

// =========================================================
// =============== User Management Routes ====================
// =========================================================
Route::middleware(['sessionAuth', 'web'])
    ->controller(userController::class)
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        // Get All
        Route::get('/all-user', 'getAllUser');
        Route::get('/user-by-id', 'getUserById');
        Route::get('/all-admin', 'getAllAdmin');
        Route::get('/all-editor', 'getAllEditor');
        Route::get('/all-viewer', 'getAllNormalUser');

        // Count
        Route::get('/count-all', 'countAllUser');
        Route::get('/count-admin', 'countAllAdmin');
        Route::get('/count-editor', 'countAllEditor');
        Route::get('/count-viewer', 'countAllNormalUser');

        // Create
        Route::post('/create-user', 'createUser');

        // Update
        Route::post('/update-role', 'updateUserRole');

        // Delete
        Route::post('/delete-user', 'deleteUser');

    });
