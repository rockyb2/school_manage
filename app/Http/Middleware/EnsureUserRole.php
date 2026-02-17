<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            if ($role === 'etudiant') {
                return redirect()->route('etudiant.auth.login');
            }

            return redirect()->route('login');
        }

        if (Auth::user()->role !== $role) {
            abort(403, 'Acces refuse pour ce profil.');
        }

        return $next($request);
    }
}
