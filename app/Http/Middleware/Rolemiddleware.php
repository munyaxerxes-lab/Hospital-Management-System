<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('show.login');
        }

        $user = auth()->user();

        if (!$user->role || !in_array($user->role->name, $roles)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}