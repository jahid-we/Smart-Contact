<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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
