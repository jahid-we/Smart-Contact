<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserProfilePageController extends Controller
{
    // User Profile Page Start ********************************
    public function UserProfile(Request $request)
    {
        return Inertia::render('UserProfilePages/ProfilePages');
    }
    // User Profile Page End ********************************
}
