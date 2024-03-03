<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // return $request->expectsJson() ? null : route('login');

        if ($request->expectsJson()) {
            return null; // Allow the default behavior for JSON requests
        }

        // If the request does not expect JSON, return a JSON response
        return response()->json(['error' => 'Unauthorized'], JsonResponse::HTTP_UNAUTHORIZED);
    }
}
