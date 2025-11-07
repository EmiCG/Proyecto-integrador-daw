<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRole
{
    /**
     * Handle an incoming request.
     * Usage in routes: ->middleware(\App\Http\Middleware\EnsureRole::class . ':admin')
     * or 'App\\Http\\Middleware\\EnsureRole:admin' as string.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles  pipe-separated or comma-separated list (e.g. 'admin' or 'admin|caja')
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles = '')
    {
        $user = Auth::user();

        if (! $user) {
            // Not authenticated — let auth middleware handle redirect; here just abort
            abort(403, 'No autorizado');
        }

        // Normalize roles parameter: accept 'admin', 'admin|caja' or comma separated
        $rolesList = preg_split('/[|,]/', $roles ?: '');
        $rolesList = array_map('trim', $rolesList);

        // If no roles specified, deny access
        if (empty($rolesList) || $rolesList === ['']) {
            abort(403, 'No autorizado');
        }

        $userRole = $user->role ?? null;

        if (! $userRole || ! in_array($userRole, $rolesList)) {
            abort(403, 'No autorizado');
        }

        return $next($request);
    }
}
