<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Untuk API / Sanctum
        $user = $request->user();

        // Untuk frontend / session
        if (!$user && session()->has('user_id')) {
            $user = User::find(session('user_id'));
        }

        // Belum login
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum login'
                ], 401);
            }

            return redirect('/login');
        }

        // Cek role
        if (!in_array($user->role, $roles)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses'
                ], 403);
            }

            abort(403, 'Anda tidak memiliki akses');
        }

        return $next($request);
    }
}