<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SyncRoleProfileSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        if ($user->role === 'enseignant' && $user->enseignant) {
            $request->session()->put('enseignant', $user->enseignant);
        }

        if ($user->role === 'etudiant' && $user->etudiant) {
            $request->session()->put('etudiant', $user->etudiant);
        }

        return $next($request);
    }
}
