<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page\HomePageController;

Route::get("/",[HomePageController::class,'Home'])->name('home');
