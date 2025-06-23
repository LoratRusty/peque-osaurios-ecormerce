@extends('layouts.admin')

@section('title', 'Reportes del Sistema')

@section('content')
    <div class="max-w-6xl mx-auto p-6 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10">

        {{-- Formulario de Selección --}}
        <form method="GET" action="{{ route('admin.reports') }}" class="mb-8">
            <fieldset class="grid grid-cols-1 md:grid-cols-6 gap-4 bg-pink-50 p-6 rounded-lg border border-pink-200">

                {{-- Tipo de Reporte (más ancho) --}}
                <div class="md:col-span-2">
                    <label for="tipo_reporte" class="block text-sm font-semibold text-pink-700 mb-2">Tipo de Reporte:</label>
                    <select id="tipo_reporte" name="tipo_reporte"
                        class="w-full border border-pink-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 transition"
                        onchange="toggleUserFilter(); this.form.submit()">
                        <option disabled selected value="">-- Selecciona --</option>
                        <option value="ventas" {{ request('tipo_reporte') == 'ventas' ? 'selected' : '' }}>Ventas por Día
                        </option>
                        <option value="productos" {{ request('tipo_reporte') == 'productos' ? 'selected' : '' }}>Productos
                            más Vendidos</option>
                        <option value="categorias" {{ request('tipo_reporte') == 'categorias' ? 'selected' : '' }}>Productos
                            por Categoría</option>
                        @if (auth()->user()->tipo === 'admin')
                            <option value="movimientos" {{ request('tipo_reporte') == 'movimientos' ? 'selected' : '' }}>
                                Movimientos de Usuarios</option>
                        @endif
                    </select>
                </div>

                {{-- Fecha Inicio --}}
                <div>
                    <label for="fecha_inicio" class="block text-sm font-semibold text-pink-700 mb-2">Desde:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio"
                        value="{{ request('fecha_inicio', $fechaInicio ?? now()->subDays(6)->toDateString()) }}"
                        class="w-full border border-pink-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 transition"
                        required>
                </div>

                {{-- Fecha Fin --}}
                <div>
                    <label for="fecha_fin" class="block text-sm font-semibold text-pink-700 mb-2">Hasta:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin"
                        value="{{ request('fecha_fin', $fechaFin ?? now()->toDateString()) }}"
                        class="w-full border border-pink-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 transition"
                        required>
                </div>

                {{-- Botón Generar --}}
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg shadow transition disabled:opacity-50"
                        {{ !request('tipo_reporte') ? 'disabled' : '' }}>
                        <i class="fas fa-chart-bar mr-2"></i> Generar
                    </button>
                </div>

                {{-- Botones Exportación --}}
                @if (request('tipo_reporte'))
                    <div class="flex items-end gap-2">
                        <a href="{{ route('admin.reports.export.pdf') }}?{{ http_build_query(request()->all()) }}"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg shadow text-sm transition"
                            title="Exportar como PDF" target="_blank">
                            <i class="fas fa-file-pdf mr-1"></i> PDF
                        </a>
                        {{-- Solo mostrar Excel para reportes que no sean de movimientos --}}
                        @if (request('tipo_reporte') !== 'movimientos')
                            <a href="{{ route('admin.reports.export.excel') }}?{{ http_build_query(request()->all()) }}"
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg shadow text-sm transition"
                                title="Exportar como Excel">
                                <i class="fas fa-file-excel mr-1"></i> Excel
                            </a>
                        @endif
                    </div>
                @endif
            </fieldset>

            {{-- Filtro adicional para movimientos de usuarios --}}
            @if (request('tipo_reporte') === 'movimientos' && auth()->user()->tipo === 'admin')
                <div id="user-filter" class="mt-4 bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <div class="grid grid-cols-1 gap-6 bg-blue-50 rounded-lg">
                        {{-- Campo de búsqueda y botón --}}
                        <div>
                            <label for="filtro_usuario" class="block text-sm font-semibold text-blue-700 mb-2">
                                <i class="fas fa-user mr-1"></i> Filtrar por Usuario <span
                                    class="text-gray-500 font-normal">(opcional)</span>
                            </label>

                            {{-- Grid que alinea el input y el botón --}}
                            <div class="grid grid-cols-1 md:grid-cols-[1fr_auto] gap-4">
                                <input type="text" id="filtro_usuario" name="filtro_usuario"
                                    value="{{ request('filtro_usuario') }}" placeholder="ID, nombre o email del usuario..."
                                    class="w-full border border-blue-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition placeholder:text-sm">

                                <button type="submit"
                                    class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition whitespace-nowrap">
                                    <i class="fas fa-filter mr-2"></i> Aplicar Filtro
                                </button>
                            </div>

                            <p class="text-xs text-blue-600 mt-2 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i>
                                Puedes buscar por ID (ej: 123), nombre (ej: Juan) o email (ej: usuario@email.com)
                            </p>
                        </div>
                    </div>

                    @if (request('filtro_usuario'))
                        <div class="mt-4 flex items-center text-sm text-blue-600">
                            <i class="fas fa-filter mr-1"></i>
                            Filtrando por: <strong class="ml-1">"{{ request('filtro_usuario') }}"</strong>
                            <a href="{{ route('admin.reports') }}?tipo_reporte=movimientos&fecha_inicio={{ request('fecha_inicio') }}&fecha_fin={{ request('fecha_fin') }}"
                                class="ml-2 text-red-500 hover:text-red-700">
                                <i class="fas fa-times mr-1"></i>Limpiar filtro
                            </a>
                        </div>
                    @endif
                </div>
            @endif

        </form>


        {{-- Mensaje inicial --}}
        @if (!request('tipo_reporte'))
            <div class="text-center py-16">
                <div class="text-pink-300 mb-4">
                    <i class="fas fa-chart-bar text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Selecciona un tipo de reporte</h3>
                <p class="text-gray-500">Elige el tipo de reporte que deseas generar para comenzar</p>
            </div>
        @endif

        {{-- REPORTE DE VENTAS POR DÍA --}}
        @if (request('tipo_reporte') === 'ventas')
            <div class="mb-10">
                <div class="bg-gradient-to-r from-pink-50 to-rose-50 p-6 rounded-lg border border-pink-200">
                    <h3 class="text-lg font-semibold text-pink-700 mb-4 flex items-center">
                        <i class="fas fa-chart-line mr-2"></i>
                        Ventas por Día
                    </h3>

                    @if (isset($ventasData) && $ventasData->count() > 0)
                        {{-- Estadísticas --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                                <div class="text-2xl font-bold text-pink-600">
                                    ${{ number_format($ventasData->sum('total_ventas'), 2) }}</div>
                                <div class="text-sm text-gray-600">Total de Ventas</div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                                <div class="text-2xl font-bold text-pink-600">
                                    ${{ number_format($ventasData->avg('total_ventas'), 2) }}</div>
                                <div class="text-sm text-gray-600">Promedio Diario</div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                                <div class="text-2xl font-bold text-pink-600">{{ $ventasData->sum('cantidad_ordenes') }}
                                </div>
                                <div class="text-sm text-gray-600">Total de Órdenes</div>
                            </div>
                        </div>

                        {{-- Gráfico --}}
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <canvas id="ventasChart" width="400" height="200"></canvas>
                        </div>

                        {{-- Tabla de datos --}}
                        <div class="mt-6 bg-white rounded-lg shadow-sm overflow-hidden">
                            <table class="w-full text-sm">
                                <thead class="bg-pink-50 text-pink-700 font-semibold">
                                    <tr>
                                        <th class="px-6 py-3 text-left">Fecha</th>
                                        <th class="px-6 py-3 text-right">Total Ventas</th>
                                        <th class="px-6 py-3 text-right">Cantidad Órdenes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventasData as $venta)
                                        <tr class="border-t border-pink-100">
                                            <td class="px-6 py-4 text-pink-600">
                                                {{ \Carbon\Carbon::parse($venta->dia)->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 text-right font-semibold">
                                                ${{ number_format($venta->total_ventas, 2) }}</td>
                                            <td class="px-6 py-4 text-right">{{ $venta->cantidad_ordenes }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10 text-gray-600">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                            <p>No hay datos de ventas para el período seleccionado</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- REPORTE DE PRODUCTOS MÁS VENDIDOS --}}
        @if (request('tipo_reporte') === 'productos')
            <div class="mb-10">
                <div class="bg-gradient-to-r from-pink-50 to-rose-50 p-6 rounded-lg border border-pink-200">
                    <h3 class="text-lg font-semibold text-pink-700 mb-4 flex items-center">
                        <i class="fas fa-trophy mr-2"></i>
                        Productos más Vendidos
                    </h3>

                    @if (isset($productosData) && $productosData->count() > 0)
                        {{-- Gráfico --}}
                        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
                            <canvas id="productosChart" width="400" height="200"></canvas>
                        </div>

                        {{-- Tabla de datos --}}
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <table class="w-full text-sm">
                                <thead class="bg-pink-50 text-pink-700 font-semibold">
                                    <tr>
                                        <th class="px-6 py-3 text-left">Ranking</th>
                                        <th class="px-6 py-3 text-left">Producto</th>
                                        <th class="px-6 py-3 text-right">Cantidad Vendida</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productosData as $index => $producto)
                                        <tr class="border-t border-pink-100">
                                            <td class="px-6 py-4">
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                            {{ $index === 0
                                                ? 'bg-yellow-100 text-yellow-600'
                                                : ($index === 1
                                                    ? 'bg-gray-100 text-gray-600'
                                                    : ($index === 2
                                                        ? 'bg-orange-100 text-orange-600'
                                                        : 'bg-pink-100 text-pink-600')) }} 
                                            font-bold">
                                                    {{ $index + 1 }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 font-medium text-pink-600">{{ $producto->nombre }}</td>
                                            <td class="px-6 py-4 text-right font-semibold">
                                                {{ number_format($producto->total_vendidos) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10 text-gray-600">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                            <p>No hay datos de productos para el período seleccionado</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- REPORTE DE PRODUCTOS POR CATEGORÍA --}}
        @if (request('tipo_reporte') === 'categorias')
            <div class="mb-10">
                <div class="bg-gradient-to-r from-pink-50 to-rose-50 p-6 rounded-lg border border-pink-200">
                    <h3 class="text-lg font-semibold text-pink-700 mb-4 flex items-center">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Productos por Categoría
                    </h3>

                    @if (isset($categoriasData) && $categoriasData->count() > 0)
                        {{-- Gráfico --}}
                        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
                            <canvas id="categoriasChart" width="400" height="200"></canvas>
                        </div>

                        {{-- Tabla de datos --}}
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <table class="w-full text-sm">
                                <thead class="bg-pink-50 text-pink-700 font-semibold">
                                    <tr>
                                        <th class="px-6 py-3 text-left">Categoría</th>
                                        <th class="px-6 py-3 text-right">Cantidad Vendida</th>
                                        <th class="px-6 py-3 text-right">Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = $categoriasData->sum('total_vendidos'); @endphp
                                    @foreach ($categoriasData as $categoria)
                                        <tr class="border-t border-pink-100">
                                            <td class="px-6 py-4 font-medium text-pink-600">{{ $categoria->categoria }}
                                            </td>
                                            <td class="px-6 py-4 text-right font-semibold">
                                                {{ number_format($categoria->total_vendidos) }}</td>
                                            <td class="px-6 py-4 text-right">
                                                {{ number_format(($categoria->total_vendidos / $total) * 100, 1) }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10 text-gray-600">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                            <p>No hay datos de categorías para el período seleccionado</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- REPORTE DE MOVIMIENTOS DE USUARIOS --}}
        @if (request('tipo_reporte') === 'movimientos' && auth()->user()->tipo === 'admin')
            <div class="mb-10">
                <div class="bg-gradient-to-r from-pink-50 to-rose-50 p-6 rounded-lg border border-pink-200">
                    <h3 class="text-lg font-semibold text-pink-700 mb-4 flex items-center">
                        <i class="fas fa-users mr-2"></i>
                        Movimientos de Usuarios
                        @if (request('filtro_usuario'))
                            <span class="ml-2 text-sm bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                                <i class="fas fa-filter mr-1"></i>
                                Filtrado por: "{{ request('filtro_usuario') }}"
                            </span>
                        @endif
                    </h3>

                    @if (isset($logs) && $logs->count() > 0)
                        {{-- Información de resultados --}}
                        <div class="mb-4 text-sm text-gray-600">
                            <i class="fas fa-info-circle mr-1"></i>
                            Mostrando {{ $logs->count() }}
                            @if (method_exists($logs, 'total'))
                                de {{ $logs->total() }}
                            @endif
                            registros
                            @if (request('filtro_usuario'))
                                para la búsqueda: <strong>"{{ request('filtro_usuario') }}"</strong>
                            @endif
                        </div>

                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <table class="w-full text-sm">
                                <thead class="bg-pink-50 text-pink-700 font-semibold">
                                    <tr>
                                        <th class="px-6 py-3 text-left">Usuario</th>
                                        <th class="px-6 py-3 text-left">Email</th>
                                        <th class="px-6 py-3 text-left">Acción</th>
                                        <th class="px-6 py-3 text-left">Fecha y Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                        <tr class="border-t border-pink-100 hover:bg-pink-50 transition duration-150">
                                            <td class="px-6 py-4 text-pink-600 font-medium">
                                                <div>
                                                    {{ $log->user->name ?? 'Usuario no encontrado' }}
                                                    <span class="text-xs text-gray-500 block">ID:
                                                        {{ $log->user_id }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600 text-xs">
                                                {{ $log->user->email ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-700">{{ $log->accion ?? 'Sin acción' }}</td>
                                            <td class="px-6 py-4 text-gray-500">
                                                {{ \Carbon\Carbon::parse($log->fecha)->format('d/m/Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Paginación si es necesaria --}}
                        @if (method_exists($logs, 'links'))
                            <div class="mt-4">
                                {{ $logs->appends(request()->query())->links('vendor.pagination.custom') }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-10 text-gray-600">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                            <p>
                                @if (request('filtro_usuario'))
                                    No se encontraron movimientos para el usuario:
                                    <strong>"{{ request('filtro_usuario') }}"</strong>
                                @else
                                    No hay movimientos registrados para el período seleccionado
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    {{-- Scripts para Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Función para mostrar/ocultar el filtro de usuario
            function toggleUserFilter() {
                const tipoReporte = document.getElementById('tipo_reporte').value;
                const userFilter = document.getElementById('user-filter');

                if (userFilter) {
                    if (tipoReporte === 'movimientos') {
                        userFilter.style.display = 'block';
                    } else {
                        userFilter.style.display = 'none';
                    }
                }
            }

            // Ejecutar al cargar la página
            toggleUserFilter();

            // Gráfico de Ventas por Día
            @if (request('tipo_reporte') === 'ventas' && isset($ventasData) && $ventasData->count() > 0)
                const ventasCtx = document.getElementById('ventasChart');
                if (ventasCtx) {
                    new Chart(ventasCtx, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode(
                                $ventasData->map(function ($v) {
                                    return \Carbon\Carbon::parse($v->dia)->format('d/m');
                                }),
                            ) !!},
                            datasets: [{
                                label: 'Ventas ($)',
                                data: {!! json_encode($ventasData->pluck('total_ventas')) !!},
                                borderColor: '#ec4899',
                                backgroundColor: 'rgba(236,72,153,0.1)',
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#ec4899',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return '$' + value.toLocaleString();
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            @endif

            // Gráfico de Productos más Vendidos
            @if (request('tipo_reporte') === 'productos' && isset($productosData) && $productosData->count() > 0)
                const productosCtx = document.getElementById('productosChart');
                if (productosCtx) {
                    new Chart(productosCtx, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($productosData->pluck('nombre')) !!},
                            datasets: [{
                                label: 'Cantidad Vendida',
                                data: {!! json_encode($productosData->pluck('total_vendidos')) !!},
                                backgroundColor: [
                                    '#f9a8d4', '#f472b6', '#ec4899', '#db2777', '#be185d',
                                    '#9d174d', '#831843', '#701a75', '#581c87', '#4c1d95'
                                ],
                                borderColor: '#ec4899',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            @endif

            // Gráfico de Productos por Categoría
            @if (request('tipo_reporte') === 'categorias' && isset($categoriasData) && $categoriasData->count() > 0)
                const categoriasCtx = document.getElementById('categoriasChart');
                if (categoriasCtx) {
                    new Chart(categoriasCtx, {
                        type: 'doughnut',
                        data: {
                            labels: {!! json_encode($categoriasData->pluck('categoria')) !!},
                            datasets: [{
                                data: {!! json_encode($categoriasData->pluck('total_vendidos')) !!},
                                backgroundColor: [
                                    '#f9a8d4', '#f472b6', '#ec4899', '#db2777', '#be185d',
                                    '#9d174d', '#831843', '#701a75', '#581c87', '#4c1d95'
                                ],
                                borderWidth: 2,
                                borderColor: '#ffffff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'right',
                                }
                            }
                        }
                    });
                }
            @endif
        });

        // Hacer la función global para que pueda ser llamada desde el onchange
        window.toggleUserFilter = function() {
            const tipoReporte = document.getElementById('tipo_reporte').value;
            const userFilter = document.getElementById('user-filter');

            if (userFilter) {
                if (tipoReporte === 'movimientos') {
                    userFilter.style.display = 'block';
                } else {
                    userFilter.style.display = 'none';
                }
            }
        }
    </script>
@endsection
