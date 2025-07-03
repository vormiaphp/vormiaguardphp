<?php

namespace VormiaGuardPhp\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();
        if (!$user || !method_exists($user, 'hasRole') || !$user->hasRole($role)) {
            abort(403, 'Unauthorized: You do not have the required role.');
        }
        return $next($request);
    }
}
