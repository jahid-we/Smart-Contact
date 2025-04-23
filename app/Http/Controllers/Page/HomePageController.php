<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomePageController extends Controller
{
    // Home Page Start ********************************
    public function Home(Request $request): Response
    {
        return Inertia::render('HomePage');
    }
    // Home Page End ********************************

}
