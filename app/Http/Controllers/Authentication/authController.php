<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Service\Authentication\AuthService;
use Illuminate\Http\Request;

class authController extends Controller
{
    // AuthService instance
    protected $AuthService;

    // Constructor to bind AuthService instance
    public function __construct(AuthService $AuthService)
    {
        $this->AuthService = $AuthService;
    }

    // User Login Part Start ********************************
    public function userLogin(Request $request)
    {
        return $this->AuthService->userLogin($request);
    }
    // User Login Part End **********************************

    // Verify OTP Part Start ********************************
    public function verifyOTP(Request $request)
    {
        return $this->AuthService->verifyOTP($request);
    }
    // Verify OTP Part End **********************************

    // Logout Part Start ********************************
    public function logout(Request $request)
    {
        return $this->AuthService->logout($request);
    }
    // Logout Part End **********************************
}
