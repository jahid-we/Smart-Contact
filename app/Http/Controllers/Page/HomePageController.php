<?php

namespace App\Http\Controllers\Page;

use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    // Home Page Start ********************************
    public function Home(Request $request): Response
    {
        return Inertia::render('HomePage');
    }
    // Home Page End ********************************

}
