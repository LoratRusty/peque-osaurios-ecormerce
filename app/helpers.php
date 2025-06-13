<?php

if (!function_exists('getRolNombre')) {
    function getRolNombre($tipo)
    {
        $roles = [
            'admin' => 'Administrador',
            'soporte' => 'Soporte a Clientes',
            'inventario' => 'Analista de Inventario',
            'ventas' => 'Analista de Ventas',
            'cliente' => 'Cliente',
        ];

        return $roles[$tipo] ?? $tipo;
    }
}

use Illuminate\Support\Facades\Auth;
use App\Models\Log;

if (!function_exists('crear_log')) {
    function crear_log($accion, $descripcion = null)
    {
        $usuarioId = Auth::id(); // ID del usuario autenticado

        Log::create([
            'user_id' => $usuarioId,
            'accion' => $accion,
            //'descripcion' => $descripcion,
            'fecha' => now(), // Asegúrate de tener este campo en la tabla
        ]);
    }
}
