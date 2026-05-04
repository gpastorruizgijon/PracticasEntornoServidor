<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->must_change_password) {
            // Deja pasar solo al perfil y al logout para no crear un bucle
            if (! $request->routeIs('profile.edit', 'profile.update', 'password.update', 'logout')) {
                return redirect()->route('profile.edit')
                    ->with('warning', 'Debes cambiar tu contraseña provisional antes de continuar.');
            }
        }

        return $next($request);
    }
}
