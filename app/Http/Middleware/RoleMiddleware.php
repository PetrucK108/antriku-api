<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // user sudah login
        if (!$request->user()) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        // cek role user
        if ($request->user()->role !== $role) {
            return response()->json([
                'message' => 'Forbidden: Role tidak sesuai'
            ], 403);
        }

        return $next($request);
    }
}
