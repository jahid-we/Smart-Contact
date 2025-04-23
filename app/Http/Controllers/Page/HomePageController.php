<?php

namespace App\Http\Controllers\Page;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    // Home Page Start ********************************
    public function Home(Request $request): Response
    {
        $email = $request->header('email');
        $id = $request->header('id');
        $user = User::where('email', $email)
                ->where('id', $id)
                ->select('is_logged_in')
                ->first();

        return Inertia::render('HomePage', ['is_logged_in' => $user->is_logged_in ?? false]);
    }
    // Home Page End ********************************

}
