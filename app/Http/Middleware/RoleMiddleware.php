<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
       public function handle($request, Closure $next)
        {
            $user = Auth::user();

            if (!$user) {
                // Not logged in
                return redirect()->route('admin.login');
            }

            if ($user->role !== 'admin') {
                // Logged in but not admin
                abort(403, 'Unauthorized');
            }

            return $next($request);
        }
}
