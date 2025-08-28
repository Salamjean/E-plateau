<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guards = ['web', 'mairie', 'hopital', 'doctor', 'director', 'agent', 'caisse', 'poste', 'livreur', 'finance', 'admin'];

        // Vérifier chaque guard
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $next($request);
            }
        }

        // Déterminer la redirection basée sur le pattern d'URL
        $patterns = [
            'mairie/*' => 'login.mairie',
            'hopital/*' => 'login.hopital',
            'doctor/*' => 'login.doctor',
            'director/*' => 'login.director',
            'agent/*' => 'login.agent',
            'caisse/*' => 'login.caisse',
            'poste/*' => 'login.poste',
            'livreur/*' => 'login.livreur',
            'finance/*' => 'login.finance',
            'admin/*' => 'login.admin',
        ];

        foreach ($patterns as $pattern => $route) {
            if ($request->is($pattern)) {
                return redirect()->route($route);
            }
        }

        // Fallback vers le login par défaut
        return redirect()->route('admin.login');
    }
}