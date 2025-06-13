<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->tipo !== 'cliente') {
            // Usuario autenticado y no es cliente: permite acceso
            return $next($request);
        }

        // Si no cumple, cerrar sesión y redirigir al login con mensaje
        auth()->logout();

        return redirect()->route('login')
            ->with('error', 'Acceso denegado. Solo los administradores pueden acceder a esta sección.');
    }
}
