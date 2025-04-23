<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is already logged in
        $email = $request->session()->get('email');
        $role = $request->session()->get('role');
        $id = $request->session()->get('id');

        if ($email && $role && $id) {
            // If logged in, redirect to dashboard
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
