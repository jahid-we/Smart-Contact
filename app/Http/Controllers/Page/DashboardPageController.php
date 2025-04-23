<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardPageController extends Controller
{
    // Dashboard Page Start ********************************
    public function Dashboard(Request $request): Response
    {
        dd($request->cookies->all()); // Debugging cookies

        if ($request->cookie('token')) {
            return Inertia::render('DashboardPages/Dashboard');
        } else {
            return Inertia::render('AuthenticationPages/LoginForm');
        }

    }
    // Dashboard Page End ********************************
}
