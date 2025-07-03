<?php

namespace VormiaGuardPhp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * UserController: Provides /api/user endpoint for VormiaGuardPHP.
 * This is a standard Laravel controller; all methods and helpers used are provided by the framework.
 */
class UserController
{
    public function show(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        $userData = $user->toArray();
        if (method_exists($user, 'roles')) {
            $userData['roles'] = $user->roles->pluck('name');
        }
        return response()->json($userData);
    }
}
