<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Maneja una petición entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Verifica si el usuario tiene alguno de los roles permitidos
        if (!in_array($user->tipo, $roles)) {
            // Acceso denegado, redirige con mensaje
            return redirect()->route('admin.dashboard')
                ->with('error', 'Acceso denegado. Solo los administradores pueden acceder a esta sección.');
        }

        return $next($request);
    }
}
