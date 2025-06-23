<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ec4899;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #ec4899;
            margin: 0 0 10px 0;
            font-size: 24px;
        }

        .header-info {
            color: #666;
            font-size: 11px;
            margin: 5px 0;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            color: #ec4899;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 1px solid #ec4899;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #ec4899;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #fce7f3;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .stats-grid {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .stat-box {
            text-align: center;
            padding: 15px;
            border: 1px solid #ec4899;
            border-radius: 5px;
            background-color: #fce7f3;
            min-width: 120px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #ec4899;
        }

        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }

        .ranking-badge {
            display: inline-block;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            text-align: center;
            line-height: 25px;
            font-weight: bold;
            color: white;
        }

        .ranking-1 {
            background-color: #fbbf24;
        }

        .ranking-2 {
            background-color: #9ca3af;
        }

        .ranking-3 {
            background-color: #f97316;
        }

        .ranking-other {
            background-color: #ec4899;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .page-break {
            page-break-before: always;
        }

        /* Estilos específicos para movimientos */
        .log-entry {
            font-size: 10px;
            word-wrap: break-word;
        }

        .log-level {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            color: white;
        }

        .log-info {
            background-color: #3b82f6;
        }

        .log-warning {
            background-color: #f59e0b;
        }

        .log-error {
            background-color: #ef4444;
        }

        .log-success {
            background-color: #10b981;
        }

        .log-debug {
            background-color: #6b7280;
        }

        .stats-container {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stats-row {
            display: table-row;
        }

        .stats-cell {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 15px;
            border: 1px solid #ec4899;
            background-color: #fce7f3;
        }

        .text-small {
            font-size: 10px;
        }

        .text-truncate {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body>
    {{-- Header --}}
    <div class="header">
        <h1>{{ $titulo }}</h1>
        <div class="header-info">
            <div>Período: {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} -
                {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</div>
            <div>Generado: {{ $fechaGeneracion }}</div>
            <div>Usuario: {{ $usuario }}</div>
        </div>
    </div>

    {{-- Reporte de Ventas --}}
    @if ($tipoReporte === 'ventas' && isset($ventasData))
        <div class="section">
            <div class="section-title">Resumen de Ventas</div>

            @if ($ventasData->count() > 0)
                {{-- Estadísticas --}}
                <div class="stats-container">
                    <div class="stats-row">
                        <div class="stats-cell">
                            <div class="stat-value">${{ number_format($ventasData->sum('total_ventas'), 2) }}</div>
                            <div class="stat-label">Total de Ventas</div>
                        </div>
                        <div class="stats-cell">
                            <div class="stat-value">${{ number_format($ventasData->avg('total_ventas'), 2) }}</div>
                            <div class="stat-label">Promedio Diario</div>
                        </div>
                        <div class="stats-cell">
                            <div class="stat-value">{{ $ventasData->sum('cantidad_ordenes') }}</div>
                            <div class="stat-label">Total de Órdenes</div>
                        </div>
                    </div>
                </div>

                {{-- Tabla de ventas --}}
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Total Ventas</th>
                            <th>Cantidad Órdenes</th>
                            <th>Promedio por Orden</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventasData as $venta)
                            <tr>
                                <td class="text-center">{{ \Carbon\Carbon::parse($venta->dia)->format('d/m/Y') }}</td>
                                <td class="text-right">${{ number_format($venta->total_ventas, 2) }}</td>
                                <td class="text-center">{{ $venta->cantidad_ordenes }}</td>
                                <td class="text-right">
                                    ${{ number_format($venta->total_ventas / $venta->cantidad_ordenes, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #666; padding: 30px;">No hay datos de ventas para el período
                    seleccionado</p>
            @endif
        </div>
    @endif

    {{-- Reporte de Productos --}}
    @if ($tipoReporte === 'productos' && isset($productosData))
        <div class="section">
            <div class="section-title">Productos más Vendidos</div>

            @if ($productosData->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th style="width: 15%;">Ranking</th>
                            <th style="width: 60%;">Producto</th>
                            <th style="width: 25%;">Cantidad Vendida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productosData as $index => $producto)
                            <tr>
                                <td class="text-center">
                                    <span
                                        class="ranking-badge {{ $index === 0 ? 'ranking-1' : ($index === 1 ? 'ranking-2' : ($index === 2 ? 'ranking-3' : 'ranking-other')) }}">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td>{{ $producto->nombre }}</td>
                                <td class="text-right">{{ number_format($producto->total_vendidos) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #666; padding: 30px;">No hay datos de productos para el período
                    seleccionado</p>
            @endif
        </div>
    @endif

    {{-- Reporte de Categorías --}}
    @if ($tipoReporte === 'categorias' && isset($categoriasData))
        <div class="section">
            <div class="section-title">Productos por Categoría</div>

            @if ($categoriasData->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50%;">Categoría</th>
                            <th style="width: 25%;">Cantidad Vendida</th>
                            <th style="width: 25%;">Porcentaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = $categoriasData->sum('total_vendidos'); @endphp
                        @foreach ($categoriasData as $categoria)
                            <tr>
                                <td>{{ $categoria->categoria }}</td>
                                <td class="text-right">{{ number_format($categoria->total_vendidos) }}</td>
                                <td class="text-right">
                                    {{ number_format(($categoria->total_vendidos / $total) * 100, 1) }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #666; padding: 30px;">No hay datos de categorías para el período
                    seleccionado</p>
            @endif
        </div>
    @endif

    {{-- Reporte de Logs --}}
    @if ($tipoReporte === 'movimientos' && isset($logsData))
        <div class="section">
            <div class="section-title">Resumen de Actividad del Sistema</div>

            @if ($totalLogs > 0)
                {{-- Estadísticas generales --}}
                <div class="stats-container">
                    <div class="stats-row">
                        <div class="stats-cell">
                            <div class="stat-value">{{ number_format($totalLogs) }}</div>
                            <div class="stat-label">Total de Logs</div>
                        </div>
                        <div class="stats-cell">
                            <div class="stat-value">{{ $usuariosActivos }}</div>
                            <div class="stat-label">Usuarios Activos</div>
                        </div>
                        <div class="stats-cell">
                            <div class="stat-value">{{ $modulosAfectados }}</div>
                            <div class="stat-label">Módulos Afectados</div>
                        </div>
                        <div class="stats-cell">
                            <div class="stat-value">{{ number_format($totalLogs / max(count($logsPorDia), 1), 1) }}
                            </div>
                            <div class="stat-label">Promedio Diario</div>
                        </div>
                    </div>
                </div>

                {{-- Resumen por tipo de acción --}}
                @if (!empty($accionesPorTipo))
                    <div class="section">
                        <div class="section-title">Acciones por Tipo</div>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 60%;">Tipo de Acción</th>
                                    <th style="width: 20%;">Cantidad</th>
                                    <th style="width: 20%;">Usuario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accionesPorTipo->sortByDesc(function ($value) {
        return $value;
    }) as $accion => $cantidad)
                                    <tr>
                                        <td>{{ ucfirst($accion) }}</td>
                                        <td class="text-center">{{ $cantidad }}</td>
                                        <td class="text-center">{{ number_format(($cantidad / $totalLogs) * 100, 1) }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                {{-- Actividad por día --}}
                @if (!empty($logsPorDia))
                    <div class="section">
                        <div class="section-title">Actividad Diaria</div>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 50%;">Fecha</th>
                                    <th style="width: 25%;">Cantidad de Logs</th>
                                    <th style="width: 25%;">Porcentaje del Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logsPorDia->sortKeys() as $fecha => $cantidad)
                                    <tr>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                                        </td>
                                        <td class="text-center">{{ $cantidad }}</td>
                                        <td class="text-center">{{ number_format(($cantidad / $totalLogs) * 100, 1) }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                {{-- Detalle de movimientos (últimos 50) --}}
                <div class="section page-break">
                    <div class="section-title">Detalle de Actividad (Últimos 50 registros)</div>
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 15%;">Fecha/Hora</th>
                                <th style="width: 15%;">Usuario</th>
                                <th style="width: 15%;">Módulo</th>
                                <th style="width: 20%;">Acción</th>
                                <th style="width: 35%;">Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logsData->take(50) as $log)
                                <tr class="log-entry">
                                    <td class="text-small text-center">
                                        {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="text-small">
                                        {{ $log->user ? $log->user->name : 'Sistema' }}
                                    </td>
                                    <td class="text-small">{{ $log->modulo ?? 'N/A' }}</td>
                                    <td class="text-small">
                                        <span class="log-level log-{{ strtolower($log->nivel ?? 'info') }}">
                                            {{ ucfirst($log->accion ?? 'Info') }}
                                        </span>
                                    </td>
                                    <td class="text-small text-truncate">
                                        {{ $log->descripcion ?? ($log->mensaje ?? 'Sin descripción') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($logsData->count() > 50)
                        <p class="text-center text-small" style="color: #666; margin-top: 10px;">
                            Mostrando los últimos 50 registros de {{ number_format($totalLogs) }} movimientos totales.
                        </p>
                    @endif
                </div>
            @else
                <p style="text-align: center; color: #666; padding: 30px;">No hay movimientos para el período seleccionado</p>
            @endif
        </div>
    @endif

    <div class="footer">
        <p>Generado el {{ $fechaGeneracion }} por {{ $usuario }}</p>
    </div>
</body>

</html>
