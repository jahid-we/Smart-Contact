<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticationPageController extends Controller
{
    // Login Form Page Start ********************************
    public function LoginForm(Request $request): Response
    {
        return Inertia::render('AuthenticationPages/LoginForm');
    }
    // Login Form Page End ********************************

    // OPT Form Page Start ********************************
    public function OtpForm(Request $request): Response
    {
        return Inertia::render('AuthenticationPages/OtpVerificationForm');
    }
    // OPT Form Page End ********************************
}
