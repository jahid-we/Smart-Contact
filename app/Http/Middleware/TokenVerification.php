<?php

namespace App\Http\Middleware;

use App\Helpers\JWTToken;
use App\Helpers\ResponseHelper;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('token');

        if (! $token) {

            return ResponseHelper::Out(false, 'unauthorized', 401);
        }

        try {
            $result = JWTToken::verifyToken($token);
        } catch (Exception $e) {

            return ResponseHelper::Out(false, 'unauthorized', 401);
        }

        if (! is_object($result) || empty($result->email)) {

            return redirect()->route('login');
        }

        // Set user details in headers
        $request->headers->set('email', $result->email);
        $request->headers->set('id', $result->id ?? null);
        $request->headers->set('role', $result->role ?? null);

        return $next($request);
    }
}
