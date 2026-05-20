<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request and ensure the user has one of the allowed roles.
     * Usage: add middleware with parameter list of allowed roles separated by |, e.g. 'role:admin|manager'
     */
    public function handle(Request $request, Closure $next, ?string $roles = null)
    {
        $user = Auth::user();
        if (! $user) {
            abort(403);
        }

        if (! $roles) {
            return $next($request);
        }

        $allowed = explode('|', $roles);
        if (! in_array($user->role ?? '', $allowed, true)) {
            abort(403);
        }

        return $next($request);
    }
}
