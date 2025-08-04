<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est authentifié
        if (auth()->check()) {


            $user = auth()->user();

            // Role 1 : Accès uniquement aux routes /admin*
            if ($user->role_id == 1) {
                if ($request->is('admin*')) {
                    return $next($request);
                }
                return redirect('/admin');
            }

            // Role 2 : Accès uniquement aux routes /rh*
            if ($user->role_id == 2) {
                if ($request->is('rh*')) {
                    return $next($request);
                }
                return redirect('/rh');
            }

            // Role 3 : Accès uniquement à la page d'accueil
            if ($user->role_id == 3) {
                if (!$request->is('rh*') && !$request->is('admin*')) {
                    return $next($request);
                }
                return redirect('/');
            }
        }

        // Tous les autres rôles ou cas non prévus : redirection vers l'accueil
        return $next($request);
    }
}
