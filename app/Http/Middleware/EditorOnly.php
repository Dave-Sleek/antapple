<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EditorOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
        {
            if (!Auth::check()) {
                return redirect()->route('login');
            }

            $role = strtolower(Auth::user()->role);

            if (!in_array($role, ['editor', 'admin'])) {
                abort(403, 'Unauthorized access.');
            }

            return $next($request);
        }
}
