<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $fechaFin = $request->input('fecha_fin', now()->toDateString());
        $fechaInicio = $request->input('fecha_inicio', now()->subDays(6)->toDateString());
        $tipoReporte = $request->input('tipo_reporte', '');

        $data = [
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'tipoReporte' => $tipoReporte
        ];

        // Procesar según el tipo de reporte seleccionado
        switch ($tipoReporte) {
            case 'ventas':
                $data['ventasData'] = $this->getVentasPorDia($fechaInicio, $fechaFin);
                break;

            case 'productos':
                $data['productosData'] = $this->getProductosMasVendidos($fechaInicio, $fechaFin);
                break;

            case 'categorias':
                $data['categoriasData'] = $this->getProductosPorCategoria($fechaInicio, $fechaFin);
                break;

            case 'movimientos':
                // Solo los admins pueden ver este reporte
                if (Auth::user()->tipo !== 'admin') {
                    return redirect()->back()->with('error', 'No tienes permisos para acceder a este reporte');
                }

                $filtroUsuario = $request->input('filtro_usuario');
                $data['logs'] = $this->getLogsParaVista($fechaInicio, $fechaFin, $filtroUsuario);
                break;
        }
        crear_log('El usuario ha accedido a la vista de Reportes');

        return view('admin.reports.index', $data);
    }

    /**
     * Obtener datos de ventas por día
     */
    private function getVentasPorDia($fechaInicio, $fechaFin)
    {
        return Order::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->select(
                DB::raw('DATE(fecha) as dia'),
                DB::raw('SUM(total) as total_ventas'),
                DB::raw('COUNT(*) as cantidad_ordenes')
            )
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();
    }

    /**
     * Obtener productos más vendidos
     */
    private function getProductosMasVendidos($fechaInicio, $fechaFin)
    {
        return OrderItem::with('product:id,nombre')
            ->whereHas('order', function ($q) use ($fechaInicio, $fechaFin) {
                $q->whereBetween('fecha', [$fechaInicio, $fechaFin]);
            })
            ->select('product_id', DB::raw('SUM(cantidad) as total_vendidos'))
            ->groupBy('product_id')
            ->orderByDesc('total_vendidos')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'nombre' => $item->product->nombre ?? 'Producto no encontrado',
                    'total_vendidos' => $item->total_vendidos,
                ];
            });
    }

    /**
     * Obtener productos por categoría
     */
    private function getProductosPorCategoria($fechaInicio, $fechaFin)
    {
        return Categoria::with(['productos.orderItems' => function ($q) use ($fechaInicio, $fechaFin) {
            $q->whereHas('order', function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
            });
        }])
            ->get()
            ->map(function ($categoria) {
                $total = 0;
                foreach ($categoria->productos as $producto) {
                    foreach ($producto->orderItems as $item) {
                        $total += $item->cantidad;
                    }
                }
                return (object) [
                    'categoria' => $categoria->nombre,
                    'total_vendidos' => $total,
                ];
            })
            ->filter(function ($c) {
                return $c->total_vendidos > 0;
            })
            ->sortByDesc('total_vendidos')
            ->values();
    }

    /**
     * Obtener movimientos de usuarios con filtrado opcional
     */
    private function getMovimientosUsuarios($fechaInicio, $fechaFin, $filtroUsuario = null)
    {
        $query = Log::with('user:id,name,email')
            ->whereBetween('fecha', [
                $fechaInicio . ' 00:00:00',
                $fechaFin . ' 23:59:59'
            ]);

        // Aplicar filtro de usuario si se proporciona
        if (!empty($filtroUsuario)) {
            $query->where(function ($q) use ($filtroUsuario) {
                // Buscar por ID de usuario (si es numérico)
                if (is_numeric($filtroUsuario)) {
                    $q->where('user_id', $filtroUsuario);
                }

                // Buscar por nombre o email del usuario
                $q->orWhereHas('user', function ($userQuery) use ($filtroUsuario) {
                    $userQuery->where('name', 'LIKE', '%' . $filtroUsuario . '%')
                        ->orWhere('email', 'LIKE', '%' . $filtroUsuario . '%');
                });
            });
        }

        return $query->orderByDesc('fecha')->paginate(100);
    }

    /**
     * API endpoints para AJAX 
     */
    public function ventasPorFecha(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        if (!$fechaInicio || !$fechaFin) {
            return response()->json(['error' => 'Fechas requeridas'], 400);
        }

        crear_log("El usuario ha consultado las ventas del {$fechaInicio} al {$fechaFin}");

        $ventas = $this->getVentasPorDia($fechaInicio, $fechaFin);
        return response()->json($ventas);
    }

    public function productosMasVendidos(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        if (!$fechaInicio || !$fechaFin) {
            return response()->json(['error' => 'Fechas requeridas'], 400);
        }

        $productos = $this->getProductosMasVendidos($fechaInicio, $fechaFin);
        return response()->json($productos);
    }

    public function productosPorCategoria(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        if (!$fechaInicio || !$fechaFin) {
            return response()->json(['error' => 'Fechas requeridas'], 400);
        }

        $categorias = $this->getProductosPorCategoria($fechaInicio, $fechaFin);
        return response()->json($categorias);
    }

    public function movimientosUsuarios(Request $request)
    {
        if (Auth::user()->tipo !== 'admin') {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $filtroUsuario = $request->input('filtro_usuario');

        if (!$fechaInicio || !$fechaFin) {
            return response()->json(['error' => 'Fechas requeridas'], 400);
        }

        $logs = $this->getMovimientosUsuarios($fechaInicio, $fechaFin, $filtroUsuario);
        return response()->json($logs);
    }
    /**
     * Exportar a PDF
     */
    public function exportPdf(Request $request)
    {
        $tipoReporte = $request->input('tipo_reporte');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $filtroUsuario = $request->input('filtro_usuario');

        if (!$tipoReporte || !$fechaInicio || !$fechaFin) {
            return redirect()->back()->with('error', 'Faltan parámetros requeridos para generar el PDF');
        }

        // Debug: Log los parámetros recibidos

        $data = [
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'tipoReporte' => $tipoReporte,
            'fechaGeneracion' => now()->format('d/m/Y H:i:s'),
            'usuario' => Auth::user()->name
        ];

        switch ($tipoReporte) {
            case 'ventas':
                $data['ventasData'] = $this->getVentasPorDia($fechaInicio, $fechaFin);
                $data['titulo'] = 'Reporte de Ventas por Día';
                break;

            case 'productos':
                $data['productosData'] = $this->getProductosMasVendidos($fechaInicio, $fechaFin);
                $data['titulo'] = 'Reporte de Productos más Vendidos';
                break;

            case 'categorias':
                $data['categoriasData'] = $this->getProductosPorCategoria($fechaInicio, $fechaFin);
                $data['titulo'] = 'Reporte de Productos por Categoría';
                break;

            case 'movimientos':
            case 'logs': // Agregamos también 'logs' por si acaso
                // Verificar que el usuario sea admin
                if (Auth::user()->tipo !== 'admin') {
                    return redirect()->back()->with('error', 'No tienes permisos para generar este reporte');
                }

                try {
                    $logsData = $this->getLogsDeUsuarios($fechaInicio, $fechaFin, $filtroUsuario);

                    // Debug: Log los datos obtenidos

                    $data['logsData'] = $logsData['logs'];
                    $data['totalLogs'] = $logsData['totalLogs'];
                    $data['usuariosActivos'] = $logsData['usuariosActivos'];
                    $data['modulosAfectados'] = $logsData['modulosAfectados'];
                    $data['logsPorDia'] = $logsData['logsPorDia'];
                    $data['accionesPorTipo'] = $logsData['accionesPorTipo'];
                    $data['filtroUsuario'] = $filtroUsuario;

                    $titulo = 'Reporte de Movimientos de Usuarios';
                    if ($filtroUsuario) {
                        $titulo .= ' - Filtrado por: ' . $filtroUsuario;
                    }
                    $data['titulo'] = $titulo;
                } catch (\Exception $e) {
  
                    return redirect()->back()->with('error', 'Error al generar el reporte: ' . $e->getMessage());
                }
                break;

            default:
                return redirect()->back()->with('error', 'Tipo de reporte no válido');
        }

        try {
            $pdf = Pdf::loadView('admin.reports.pdf', $data);
            $pdf->setPaper('A4', 'portrait');

            $filename = 'reporte_' . $tipoReporte . '_' . $fechaInicio . '_a_' . $fechaFin;
            if ($filtroUsuario && in_array($tipoReporte, ['movimientos', 'logs'])) {
                $filename .= '_filtrado';
            }
            $filename .= '.pdf';
            crear_log("El usuario exportó un reporte PDF del tipo '{$tipoReporte}' del {$fechaInicio} al {$fechaFin}");
            return $pdf->stream($filename);
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    /**
     * Obtener logs de usuarios con estadísticas
     */
    private function getLogsDeUsuarios($fechaInicio, $fechaFin, $filtroUsuario = null)
    {
        try {
            // Debug: Log las fechas

            $query = Log::with('user')
                ->whereBetween('fecha', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
                ->orderBy('fecha', 'desc');

            if ($filtroUsuario) {
                $query->whereHas('user', function ($q) use ($filtroUsuario) {
                    $q->where('name', 'like', '%' . $filtroUsuario . '%');
                });
            }

            $logs = $query->get();
            $totalLogs = $logs->count();

            // Debug: Log el resultado

            // Usuarios activos
            $usuariosActivos = $logs->pluck('user.name')
                ->filter()
                ->unique()
                ->count();

            // Módulos afectados
            $modulosAfectados = $logs->pluck('modulo')
                ->filter()
                ->unique()
                ->count();

            // Logs por día
            $logsPorDia = $logs->groupBy(function ($log) {
                return $log->fecha;
            })->map(function ($dayLogs) {
                return $dayLogs->count();
            });

            // Acciones por tipo
            $accionesPorTipo = $logs->groupBy('accion')
                ->map(function ($actionLogs) {
                    return $actionLogs->count();
                });

            $result = [
                'logs' => $logs,
                'totalLogs' => $totalLogs,
                'usuariosActivos' => $usuariosActivos,
                'modulosAfectados' => $modulosAfectados,
                'logsPorDia' => $logsPorDia,
                'accionesPorTipo' => $accionesPorTipo
            ];

            // Debug: Log el resultado final

            return $result;
        } catch (\Exception $e) {

            return [
                'logs' => collect([]),
                'totalLogs' => 0,
                'usuariosActivos' => 0,
                'modulosAfectados' => 0,
                'logsPorDia' => collect([]),
                'accionesPorTipo' => collect([])
            ];
        }
    }

    /**
     * Obtener logs de usuarios para la vista principal
     */
    private function getLogsParaVista($fechaInicio, $fechaFin, $filtroUsuario = null)
    {
        $query = Log::with('user')
            ->whereBetween('fecha', [
                Carbon::parse($fechaInicio)->startOfDay(),
                Carbon::parse($fechaFin)->endOfDay()
            ]);

        // Aplicar filtro de usuario si se proporciona
        if ($filtroUsuario) {
            $query->where(function ($q) use ($filtroUsuario) {
                // Buscar por ID exacto
                if (is_numeric($filtroUsuario)) {
                    $q->where('user_id', $filtroUsuario);
                }

                // Buscar por nombre o email
                $q->orWhereHas('user', function ($subQuery) use ($filtroUsuario) {
                    $subQuery->where('name', 'LIKE', '%' . $filtroUsuario . '%')
                        ->orWhere('email', 'LIKE', '%' . $filtroUsuario . '%');
                });
            });
        }

        // Para la vista, paginamos los resultados
        return $query->orderBy('fecha', 'desc')->paginate(20);
    }

    /**
     * Exportar a Excel - Versión sin facade
     */
    public function exportExcel(Request $request)
    {
        $tipoReporte = $request->input('tipo_reporte');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $filtroUsuario = $request->input('filtro_usuario'); // Agregar el filtro de usuario

        if (!$tipoReporte || !$fechaInicio || !$fechaFin) {
            return redirect()->back()->with('error', 'Faltan parámetros requeridos para generar el Excel');
        }

        $data = collect();
        $nombreArchivo = '';
        $titulo = '';

        switch ($tipoReporte) {
            case 'ventas':
                $ventasData = $this->getVentasPorDia($fechaInicio, $fechaFin);
                $data = $ventasData->map(function ($item) {
                    return [
                        'Fecha' => Carbon::parse($item->dia)->format('d/m/Y'),
                        'Total Ventas' => '$' . number_format($item->total_ventas, 2),
                        'Cantidad Órdenes' => $item->cantidad_ordenes,
                        'Promedio por Orden' => '$' . number_format($item->cantidad_ordenes > 0 ? $item->total_ventas / $item->cantidad_ordenes : 0, 2)
                    ];
                });
                $nombreArchivo = 'reporte_ventas_' . $fechaInicio . '_a_' . $fechaFin . '.xlsx';
                $titulo = 'Reporte de Ventas por Día';
                break;

            case 'productos':
                $productosData = $this->getProductosMasVendidos($fechaInicio, $fechaFin);
                $data = $productosData->map(function ($item, $index) {
                    return [
                        'Ranking' => $index + 1,
                        'Producto' => $item->nombre,
                        'Cantidad Vendida' => $item->total_vendidos
                    ];
                });
                $nombreArchivo = 'reporte_productos_' . $fechaInicio . '_a_' . $fechaFin . '.xlsx';
                $titulo = 'Reporte de Productos más Vendidos';
                break;

            case 'categorias':
                $categoriasData = $this->getProductosPorCategoria($fechaInicio, $fechaFin);
                $total = $categoriasData->sum('total_vendidos');
                $data = $categoriasData->map(function ($item) use ($total) {
                    return [
                        'Categoría' => $item->categoria,
                        'Cantidad Vendida' => $item->total_vendidos,
                        'Porcentaje' => $total > 0 ? number_format(($item->total_vendidos / $total) * 100, 1) . '%' : '0%'
                    ];
                });
                $nombreArchivo = 'reporte_categorias_' . $fechaInicio . '_a_' . $fechaFin . '.xlsx';
                $titulo = 'Reporte de Productos por Categoría';
                break;

            case 'movimientos':
                if (Auth::user()->tipo !== 'admin') {
                    return redirect()->back()->with('error', 'No autorizado para generar este reporte');
                }

                // Usar el método modificado con filtro de usuario
                $logsQuery = Log::with('user:id,name,email')
                    ->whereBetween('fecha', [
                        $fechaInicio . ' 00:00:00',
                        $fechaFin . ' 23:59:59'
                    ]);

                // Aplicar filtro de usuario si se proporciona
                if (!empty($filtroUsuario)) {
                    $logsQuery->where(function ($q) use ($filtroUsuario) {
                        // Buscar por ID de usuario (si es numérico)
                        if (is_numeric($filtroUsuario)) {
                            $q->where('user_id', $filtroUsuario);
                        }

                        // Buscar por nombre o email del usuario
                        $q->orWhereHas('user', function ($userQuery) use ($filtroUsuario) {
                            $userQuery->where('name', 'LIKE', '%' . $filtroUsuario . '%')
                                ->orWhere('email', 'LIKE', '%' . $filtroUsuario . '%');
                        });
                    });
                }

                $logsData = $logsQuery->orderByDesc('fecha')->get();

                $data = $logsData->map(function ($log) {
                    return [
                        'Fecha' => Carbon::parse($log->fecha)->format('d/m/Y H:i:s'),
                        'ID Usuario' => $log->user_id,
                        'Usuario' => $log->user->name ?? 'Usuario no encontrado',
                        'Email' => $log->user->email ?? 'N/A',
                        'Acción' => $log->accion,
                        'Descripción' => $log->descripcion ?? '',
                        'IP' => $log->ip ?? ''
                    ];
                });

                // Modificar el nombre del archivo si hay filtro
                $sufijo = !empty($filtroUsuario) ? '_filtrado_' . str_replace(' ', '_', $filtroUsuario) : '';
                $nombreArchivo = 'reporte_movimientos' . $sufijo . '_' . $fechaInicio . '_a_' . $fechaFin . '.xlsx';
                $titulo = 'Reporte de Movimientos de Usuarios';
                if (!empty($filtroUsuario)) {
                    $titulo .= ' - Filtrado por: ' . $filtroUsuario;
                }
                break;

            default:
                return redirect()->back()->with('error', 'Tipo de reporte no válido');
        }

        // Verificar que tenemos datos
        if ($data->isEmpty()) {
            $mensaje = 'No hay datos para exportar en el rango de fechas seleccionado';
            if (!empty($filtroUsuario)) {
                $mensaje .= ' con el filtro de usuario aplicado';
            }
            return redirect()->back()->with('warning', $mensaje);
        }

        try {
            // Crear la instancia del exportador directamente
            $exporter = new ReportsExport($data, $titulo, $fechaInicio, $fechaFin);

            // Usar el método download de la clase
            crear_log("El usuario exportó un reporte Excel del tipo '{$tipoReporte}' del {$fechaInicio} al {$fechaFin}");

            return $exporter->download($nombreArchivo);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Error al generar el archivo Excel: ' . $e->getMessage());
        }
    }
}
