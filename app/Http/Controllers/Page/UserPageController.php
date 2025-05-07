<?php

namespace App\Http\Controllers\Page;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPageController extends Controller
{
    // User Page Method Start ******************
    public function userPage(Request $request)
    {
        return Inertia::render('UserPages/UserPages');
    }
    // User Page Method End ********************
}
