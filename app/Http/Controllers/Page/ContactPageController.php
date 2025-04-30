<?php

namespace App\Http\Controllers\Page;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactPageController extends Controller
{
     // Contact Page Start ********************************
     public function Contact(Request $request): Response
     {
         return Inertia::render('ContactPages/ContactPage');
     }
     // Contact Page End ********************************
}
