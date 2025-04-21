<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminVerification
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

        if (strtolower($result->role) !== 'admin') {

            return ResponseHelper::Out(false, 'unauthorized', 401);
        }

        return $next($request);
    }
}
