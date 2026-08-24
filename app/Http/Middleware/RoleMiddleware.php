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
    public function handle(Request $request, Closure $next, string $roleName): Response
    {
        // 1. Force guest redirect if not logged in
        if (!Auth::check()) {
            return redirect()->route('show.login');
        }

        // 2. Fetch the user's assigned role string from the database relation
        $userRole = $request->user()->role ? $request->user()->role->name : null;

        // 3. Block unauthorized access cleanly
        if ($userRole !== $roleName) {
            abort(403, 'Unauthorized access to this section.');
        }

        return $next($request);
    }
}
