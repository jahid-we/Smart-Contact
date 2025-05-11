<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserPageController extends Controller
{
    // User Page Method Start ******************
    public function userPage(Request $request)
    {
        return Inertia::render('UserPages/UserPages');
    }
    // User Page Method End ********************
}
