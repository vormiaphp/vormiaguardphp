<?php

namespace VormiaGuardPhp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * AccessController: Provides /api/can-access endpoint for VormiaGuardPHP.
 * This is a standard Laravel controller; all methods and helpers used are provided by the framework.
 */
class AccessController
{
    public function canAccess(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['allowed' => false], 401);
        }
        $route = $request->input('route');
        $middleware = $request->input('middleware');
        // Example: check role if middleware is provided
        if ($middleware && method_exists($user, 'hasRole')) {
            if (!$user->hasRole($middleware)) {
                return response()->json(['allowed' => false]);
            }
        }
        // You can add more complex logic here as needed
        return response()->json(['allowed' => true]);
    }
}
