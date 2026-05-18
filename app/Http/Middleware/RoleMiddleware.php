<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.index');
            } elseif ($user->role === 'owner') {
                return redirect()->route('owner.index');
            } else {
                return redirect()->route('index');
            }
        }

        return $next($request);
    }
}
