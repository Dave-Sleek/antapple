<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth::user();
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($request->routeIs('pricing', 'login', 'logout', 'register')) {
            return $next($request);
        }


        if ($request->routeIs('pricing')) {
            return $next($request);
        }

        if (!$user || !$user->hasActiveSubscription()) {
            return redirect()->route('pricing')
                ->with('warning', 'You must subscribe to a plan before posting jobs.');
        }

        return $next($request);
    }
}
