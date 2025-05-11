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
        return Inertia::render('DashboardPages/Dashboard');

    }
    // Dashboard Page End ********************************

}
