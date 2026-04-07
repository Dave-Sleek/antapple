<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        // If the request expects JSON, return null (so it gets a 401 response)
        if ($request->expectsJson()) {
            return null;
        }

        // Otherwise, redirect to your login route
        return route('login');
    }
}
