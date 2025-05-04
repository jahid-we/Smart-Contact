<?php

namespace App\Http\Controllers\Page;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfilePageController extends Controller
{
     // User Profile Page Start ********************************
     public function UserProfile(Request $request)
     {
         return Inertia::render('UserProfilePages/ProfilePages');
     }
     // User Profile Page End ********************************
}
