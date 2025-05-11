<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactPageController extends Controller
{
    // Contact Page Start ********************************
    public function Contact(Request $request): Response
    {
        return Inertia::render('ContactPages/ContactPage');
    }
    // Contact Page End ********************************
}
