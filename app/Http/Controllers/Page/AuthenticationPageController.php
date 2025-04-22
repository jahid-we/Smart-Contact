<?php

namespace App\Http\Controllers\Page;

use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthenticationPageController extends Controller
{
    // Login Form Page Start ********************************
    public function LoginForm(Request $request):Response
    {
        return Inertia::render('AuthenticationPages/LoginForm');
    }
    // Login Form Page End ********************************

    // OPT Form Page Start ********************************
    public function OtpForm(Request $request):Response
    {
        return Inertia::render('AuthenticationPages/OtpVerificationForm');
    }
    // OPT Form Page End ********************************
}
