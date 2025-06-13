<?php

namespace App\Http\Controllers\Admin;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogController extends Controller 
{
    public function index()
    {
        // Carga los logs con la relación del usuario, ordenados por fecha descendente
        $logs = Log::with('user')
            ->orderBy('fecha', 'desc')
            ->paginate(50);

        return view('admin.logs', compact('logs'));
    }
}
