<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $email = $request->session()->get('email', 'default');
        $role = $request->session()->get('role', 'default');
        $id = $request->session()->get('id', 'default');

        // Check if route is NOT `/` (homepage)
        if ($request->path() !== '/') {
            if ($email === 'default' || $role === 'default' || $id === 'default') {
                return redirect()->route('LoginForm');
            }
        }
        $request->headers->set('email', $email);
        $request->headers->set('role', $role);
        $request->headers->set('id', $id);

        return $next($request);
    }
}
