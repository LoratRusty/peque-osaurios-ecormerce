<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View|RedirectResponse
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->tipo !== 'cliente') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('cliente.store');
            }
        }

        return view('auth.login');
    }


    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            $user = Auth::user();

            // Guardar datos específicos del usuario en la sesión
            session()->put('usuario', [
                'id'        => $user->id,
                'name'      => $user->name,
                'email'     => $user->email,
                'tipo'      => $user->tipo,
                'direccion' => $user->direccion,
            ]);

            // Verificar si el usuario está bloqueado
            if ($user->status == 0) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Tu cuenta está bloqueada. Contacta al soporte para más detalles.');
            }

            // Redirigir según el tipo de usuario
            if ($user->tipo !== 'cliente') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('cliente.store');

        } catch (ValidationException $e) {
            return back()
                ->with('error', 'Email o contraseña incorrectos.')
                ->withInput($request->only('email'));
        }
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
