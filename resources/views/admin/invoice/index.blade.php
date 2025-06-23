@extends('layouts.admin')

@section('title', 'Facturas y Carritos Pendientes')

@section('content')
    {{-- Header Principal --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Sección de Filtros Mejorada --}}
        <div class="bg-white rounded-2xl shadow-xl border border-pink-100 mb-8 overflow-hidden">
            <div x-data="{ open: {{ request()->hasAny(['search', 'status', 'date_from', 'date_to', 'min_total', 'max_total']) ? 'true' : 'false' }} }">
                {{-- Header de Filtros --}}
                <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full text-white hover:text-pink-100 transition-colors duration-200">
                        <div class="flex items-center">
                            <i class="fas fa-filter mr-3 text-lg"></i>
                            <span class="text-lg font-semibold">Filtros</span>
                        </div>
                        <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" 
                           class="text-lg transition-transform duration-200"></i>
                    </button>
                </div>

                {{-- Contenido de Filtros --}}
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="p-6 bg-pink-50 border-t border-pink-200">
                    
                    <form method="GET" action="{{ route('admin.invoice') }}" class="space-y-6">
                        {{-- Primera Fila - Búsqueda y Estado --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Búsqueda --}}
                            <div class="relative">
                                <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-search mr-2 text-pink-500"></i>Buscar Usuario
                                </label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    placeholder="Nombre, email o ID del usuario"
                                    class="w-full px-4 py-3 pl-10 border-2 border-gray-200 rounded-xl focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition-all duration-200 bg-white shadow-sm" />
                                <i class="fas fa-user absolute left-3 top-12 text-gray-400"></i>
                            </div>

                            {{-- Estado --}}
                            <div class="relative">
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-flag mr-2 text-pink-500"></i>Estado del Pedido
                                </label>
                                <select name="status" id="status"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition-all duration-200 bg-white shadow-sm">
                                    <option value="">Todos los estados</option>
                                    @foreach (['pendiente', 'pagado', 'enviado', 'cancelado', 'completado'] as $st)
                                        <option value="{{ $st }}" @if (request('status') === $st) selected @endif
                                            class="capitalize">{{ ucfirst($st) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Segunda Fila - Fechas --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <label for="date_from" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt mr-2 text-pink-500"></i>Fecha Desde
                                </label>
                                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition-all duration-200 bg-white shadow-sm" />
                            </div>

                            <div class="relative">
                                <label for="date_to" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-check mr-2 text-pink-500"></i>Fecha Hasta
                                </label>
                                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition-all duration-200 bg-white shadow-sm" />
                            </div>
                        </div>

                        {{-- Tercera Fila - Montos --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <label for="min_total" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-dollar-sign mr-2 text-pink-500"></i>Monto Mínimo
                                </label>
                                <input type="number" step="0.01" name="min_total" id="min_total"
                                    value="{{ request('min_total') }}" placeholder="0.00"
                                    class="w-full px-4 py-3 pl-8 border-2 border-gray-200 rounded-xl focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition-all duration-200 bg-white shadow-sm" />
                                <span class="absolute left-3 top-12 text-gray-400">$</span>
                            </div>

                            <div class="relative">
                                <label for="max_total" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-dollar-sign mr-2 text-pink-500"></i>Monto Máximo
                                </label>
                                <input type="number" step="0.01" name="max_total" id="max_total"
                                    value="{{ request('max_total') }}" placeholder="0.00"
                                    class="w-full px-4 py-3 pl-8 border-2 border-gray-200 rounded-xl focus:border-pink-400 focus:ring-4 focus:ring-pink-100 transition-all duration-200 bg-white shadow-sm" />
                                <span class="absolute left-3 top-12 text-gray-400">$</span>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-pink-200">
                            <button type="submit"
                                class="flex-1 sm:flex-none px-8 py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-search mr-2"></i>Aplicar Filtros
                            </button>
                            <a href="{{ route('admin.invoice') }}"
                                class="flex-1 sm:flex-none px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-200 text-center">
                                <i class="fas fa-times mr-2"></i>Limpiar Filtros
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sección de Facturas Realizadas --}}
        <div class="bg-white rounded-2xl shadow-xl border border-pink-100 mb-8 overflow-hidden">
            {{-- Header de Sección --}}
            <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-file-invoice-dollar text-white text-xl mr-3"></i>
                        <h2 class="text-xl font-bold text-white">Facturas Realizadas</h2>
                    </div>
                    <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium">
                        {{ $orders->total() ?? $orders->count() }} registros
                    </span>
                </div>
            </div>

            {{-- Contenido de Facturas --}}
            <div class="p-6">
                @if ($orders->isEmpty())
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                        <p class="text-xl text-gray-500 font-medium">No hay facturas registradas</p>
                        <p class="text-gray-400 mt-2">Las facturas aparecerán aquí una vez que se realicen pedidos</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-pink-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-pink-900 uppercase tracking-wider">
                                        <i class="fas fa-hashtag mr-2"></i>ID Orden
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-pink-900 uppercase tracking-wider">
                                        <i class="fas fa-user mr-2"></i>Usuario
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-pink-900 uppercase tracking-wider">
                                        <i class="fas fa-dollar-sign mr-2"></i>Total
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-pink-900 uppercase tracking-wider">
                                        <i class="fas fa-flag mr-2"></i>Estado
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-pink-900 uppercase tracking-wider">
                                        <i class="fas fa-calendar mr-2"></i>Fecha
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-pink-900 uppercase tracking-wider">
                                        <i class="fas fa-cogs mr-2"></i>Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-pink-25 transition-colors duration-150">
                                        {{-- ID Orden --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-pink-600 text-xs font-bold">#</span>
                                                </div>
                                                <span class="text-sm font-medium text-gray-900">{{ $order->id }}</span>
                                            </div>
                                        </td>

                                        {{-- Usuario --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-pink-600 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-user text-white text-sm"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ optional($order->user)->name ?? 'Sin usuario' }}
                                                    </div>
                                                    @if (optional($order->user)->email)
                                                        <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Total --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-lg font-bold text-green-600">
                                                ${{ number_format($order->total, 2) }}
                                            </div>
                                        </td>

                                        {{-- Estado --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                @switch($order->status)
                                                    @case('pendiente') bg-yellow-100 text-yellow-800 @break
                                                    @case('pagado') bg-blue-100 text-blue-800 @break
                                                    @case('enviado') bg-indigo-100 text-indigo-800 @break
                                                    @case('completado') bg-green-100 text-green-800 @break
                                                    @case('cancelado') bg-red-100 text-red-800 @break
                                                    @default bg-gray-100 text-gray-800
                                                @endswitch">
                                                <span class="w-2 h-2 rounded-full mr-2
                                                    @switch($order->status)
                                                        @case('pendiente') bg-yellow-400 @break
                                                        @case('pagado') bg-blue-400 @break
                                                        @case('enviado') bg-indigo-400 @break
                                                        @case('completado') bg-green-400 @break
                                                        @case('cancelado') bg-red-400 @break
                                                        @default bg-gray-400
                                                    @endswitch"></span>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>

                                        {{-- Fecha --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-medium">
                                                {{ $order->created_at->format('d/m/Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $order->created_at->format('H:i') }}
                                            </div>
                                        </td>

                                        {{-- Acciones --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                {{-- Botón PDF --}}
                                                @if (in_array($order->status, ['pagado', 'enviado', 'completado']))
                                                    <a href="{{ route('admin.invoice.download', $order->id) }}"
                                                        class="inline-flex items-center px-3 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-all duration-200 transform hover:scale-105"
                                                        title="Descargar factura" target="_blank">
                                                        <i class="fas fa-file-pdf mr-1"></i>
                                                        <span class="hidden sm:inline text-xs font-medium">PDF</span>
                                                    </a>
                                                @endif

                                                {{-- Botón Ver Detalle --}}
                                                <div x-data="{ openDetail: false }" class="relative">
                                                    <button @click="openDetail = true"
                                                        class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-all duration-200 transform hover:scale-105"
                                                        title="Ver detalle de orden">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    
                                                    {{-- Modal de detalle de orden --}}
                                                    <div x-cloak x-show="openDetail"
                                                        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50"
                                                        @click.away="openDetail = false"
                                                        x-transition:enter="ease-out duration-300"
                                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                        x-transition:leave="ease-in duration-200"
                                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                        <div class="bg-white rounded-2xl py-8 px-6 max-w-4xl w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto"
                                                            @keydown.escape.window="openDetail = false">
                                                            {{-- Header del Modal --}}
                                                            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                                                                <div class="flex items-center">
                                                                    <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-pink-600 rounded-xl flex items-center justify-center mr-4">
                                                                        <i class="fas fa-file-invoice text-white text-lg"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h3 class="text-2xl font-bold text-gray-800">Detalle de Orden</h3>
                                                                        <p class="text-gray-600">Orden #{{ $order->id }}</p>
                                                                    </div>
                                                                </div>
                                                                <button @click="openDetail = false"
                                                                    class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors duration-200">
                                                                    <i class="fas fa-times text-gray-600"></i>
                                                                </button>
                                                            </div>

                                                            {{-- Contenido del Modal --}}
                                                            <div class="space-y-6">
                                                                {{-- Información del Usuario --}}
                                                                <div class="bg-gray-50 rounded-xl p-4">
                                                                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                                                        <i class="fas fa-user mr-2 text-pink-500"></i>Información del Usuario
                                                                    </h4>
                                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                        <div>
                                                                            <p class="text-sm text-gray-600">Nombre</p>
                                                                            <p class="font-medium text-gray-800">
                                                                                {{ optional($order->user)->name ?? 'Sin usuario' }}
                                                                            </p>
                                                                        </div>
                                                                        @if (optional($order->user)->email)
                                                                            <div>
                                                                                <p class="text-sm text-gray-600">Email</p>
                                                                                <p class="font-medium text-gray-800">{{ $order->user->email }}</p>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                {{-- Dirección de Envío --}}
                                                                <div class="bg-blue-50 rounded-xl p-4">
                                                                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                                                        <i class="fas fa-map-marker-alt mr-2 text-pink-500"></i>Dirección de Envío
                                                                    </h4>
                                                                    <p class="text-gray-800 leading-relaxed">{{ $order->direccion_envio }}</p>
                                                                </div>

                                                                {{-- Método de Pago --}}
                                                                <div class="bg-green-50 rounded-xl p-4">
                                                                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                                                        <i class="fas fa-credit-card mr-2 text-pink-500"></i>Método de Pago
                                                                    </h4>
                                                                    @if ($order->payment && $order->payment->paymentType)
                                                                        <p class="font-medium text-gray-800">{{ $order->payment->paymentType->nombre }}</p>
                                                                    @else
                                                                        <p class="text-gray-500 italic">Método de pago no disponible</p>
                                                                    @endif
                                                                </div>

                                                                {{-- Items de la Orden --}}
                                                                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                                                                    <div class="bg-pink-50 px-4 py-3 border-b border-pink-100">
                                                                        <h4 class="font-semibold text-gray-800 flex items-center">
                                                                            <i class="fas fa-shopping-cart mr-2 text-pink-500"></i>Items del Pedido
                                                                        </h4>
                                                                    </div>
                                                                    <div class="overflow-x-auto">
                                                                        <table class="min-w-full text-sm">
                                                                            <thead class="bg-pink-100 text-pink-900">
                                                                                <tr>
                                                                                    <th class="px-4 py-3 text-left font-semibold">Producto</th>
                                                                                    <th class="px-4 py-3 text-center font-semibold">Cantidad</th>
                                                                                    <th class="px-4 py-3 text-right font-semibold">Precio Unit.</th>
                                                                                    <th class="px-4 py-3 text-right font-semibold">Subtotal</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="divide-y divide-gray-100">
                                                                                @php $sumSubtotal = 0; @endphp
                                                                                @foreach ($order->orderItems as $item)
                                                                                    @php
                                                                                        $subtotal = $item->cantidad * $item->precio_unitario;
                                                                                        $sumSubtotal += $subtotal;
                                                                                    @endphp
                                                                                    <tr class="hover:bg-gray-50">
                                                                                        <td class="px-4 py-3 font-medium text-gray-800">
                                                                                            {{ optional($item->product)->nombre ?? 'Producto eliminado' }}
                                                                                        </td>
                                                                                        <td class="px-4 py-3 text-center">
                                                                                            <span class="bg-gray-100 px-2 py-1 rounded-full text-xs font-medium">
                                                                                                {{ $item->cantidad }}
                                                                                            </span>
                                                                                        </td>
                                                                                        <td class="px-4 py-3 text-right font-medium">
                                                                                            ${{ number_format($item->precio_unitario, 2) }}
                                                                                        </td>
                                                                                        <td class="px-4 py-3 text-right font-bold text-green-600">
                                                                                            ${{ number_format($subtotal, 2) }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                            <tfoot class="bg-gray-50">
                                                                                <tr>
                                                                                    <td colspan="3" class="px-4 py-3 text-right font-semibold text-gray-700">
                                                                                        Subtotal:
                                                                                    </td>
                                                                                    <td class="px-4 py-3 text-right font-bold text-gray-800">
                                                                                        ${{ number_format($sumSubtotal, 2) }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="bg-pink-50">
                                                                                    <td colspan="3" class="px-4 py-3 text-right font-bold text-pink-800">
                                                                                        Total:
                                                                                    </td>
                                                                                    <td class="px-4 py-3 text-right font-bold text-pink-800 text-lg">
                                                                                        ${{ number_format($order->total, 2) }}
                                                                                    </td>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                {{-- Información Adicional --}}
                                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                    <div class="bg-gray-50 rounded-lg p-4">
                                                                        <p class="text-sm text-gray-600 mb-1">Fecha de Creación</p>
                                                                        <p class="font-semibold text-gray-800">
                                                                            {{ $order->created_at->format('d/m/Y H:i') }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="bg-gray-50 rounded-lg p-4">
                                                                        <p class="text-sm text-gray-600 mb-1">ID de Pago</p>
                                                                        <p class="font-semibold text-gray-800">
                                                                            {{ $order->pago_id ?? '—' }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- Footer del Modal --}}
                                                            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                                                                <button @click="openDetail = false"
                                                                    class="px-6 py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold rounded-xl transition-all duration-200">
                                                                    Cerrar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Botón Cambiar Estado --}}
                                                <div x-data="{ openStatus: false, newStatus: '{{ $order->status }}' }" class="relative">
                                                    <button @click="openStatus = true"
                                                        class="inline-flex items-center px-3 py-2 bg-orange-100 hover:bg-orange-200 text-orange-700 rounded-lg transition-all duration-200 transform hover:scale-105"
                                                        title="Cambiar estado">
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </button>
                                                    
                                                    {{-- Modal cambio de estado --}}
                                                    <div x-cloak x-show="openStatus"
                                                        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50"
                                                        @click.away="openStatus = false"
                                                        x-transition:enter="ease-out duration-300"
                                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                        x-transition:leave="ease-in duration-200"
                                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                        <div class="bg-white rounded-2xl py-6 px-6 max-w-sm w-full mx-4 shadow-2xl"
                                                            @keydown.escape.window="openStatus = false">
                                                            {{-- Header del Modal --}}
                                                            <div class="flex items-center mb-6">
                                                                <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center mr-3">
                                                                    <i class="fas fa-exchange-alt text-white"></i>
                                                                </div>
                                                                <div>
                                                                    <h4 class="text-lg font-bold text-gray-800">Cambiar Estado</h4>
                                                                    <p class="text-sm text-gray-600">Orden #{{ $order->id }}</p>
                                                                </div>
                                                            </div>

                                                            {{-- Formulario --}}
                                                            <form method="POST" action="{{ route('admin.invoice.updateStatus', $order->id) }}">
                                                                @csrf
                                                                @method('PATCH')

                                                                <div class="mb-6">
                                                                    <label for="status-select-{{ $order->id }}" class="block text-sm font-semibold text-gray-700 mb-3">
                                                                        <i class="fas fa-flag mr-2 text-orange-500"></i>Nuevo Estado
                                                                    </label>
                                                                    <select id="status-select-{{ $order->id }}" name="status" x-model="newStatus"
                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 focus:ring-4 focus:ring-orange-100 transition-all duration-200 bg-white shadow-sm">
                                                                        @foreach (['pendiente', 'pagado', 'enviado', 'cancelado', 'completado'] as $st)
                                                                            <option value="{{ $st }}" class="capitalize">
                                                                                {{ ucfirst($st) }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                {{-- Vista previa del estado --}}
                                                                <div class="mb-6 p-3 bg-gray-50 rounded-lg">
                                                                    <p class="text-sm text-gray-600 mb-2">Vista previa:</p>
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold"
                                                                        :class="{
                                                                            'bg-yellow-100 text-yellow-800': newStatus === 'pendiente',
                                                                            'bg-blue-100 text-blue-800': newStatus === 'pagado',
                                                                            'bg-indigo-100 text-indigo-800': newStatus === 'enviado',
                                                                            'bg-green-100 text-green-800': newStatus === 'completado',
                                                                            'bg-red-100 text-red-800': newStatus === 'cancelado'
                                                                        }">
                                                                        <span class="w-2 h-2 rounded-full mr-2"
                                                                            :class="{
                                                                                'bg-yellow-400': newStatus === 'pendiente',
                                                                                'bg-blue-400': newStatus === 'pagado',
                                                                                'bg-indigo-400': newStatus === 'enviado',
                                                                                'bg-green-400': newStatus === 'completado',
                                                                                'bg-red-400': newStatus === 'cancelado'
                                                                            }"></span>
                                                                        <span x-text="newStatus.charAt(0).toUpperCase() + newStatus.slice(1)"></span>
                                                                    </span>
                                                                </div>

                                                                {{-- Botones --}}
                                                                <div class="flex gap-3">
                                                                    <button type="button" @click="openStatus = false"
                                                                        class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-200">
                                                                        <i class="fas fa-times mr-2"></i>Cancelar
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="flex-1 px-4 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                                        <i class="fas fa-check mr-2"></i>Actualizar
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación mejorada --}}
                    @if ($orders->hasPages())
                        <div class="mt-6 px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                {{-- Información de resultados --}}
                                <div class="text-sm text-gray-600 font-medium">
                                    <i class="fas fa-info-circle mr-2 text-pink-500"></i>
                                    Mostrando <span class="font-bold text-gray-800">{{ $orders->firstItem() }}</span> - 
                                    <span class="font-bold text-gray-800">{{ $orders->lastItem() }}</span> de 
                                    <span class="font-bold text-gray-800">{{ $orders->total() }}</span> registros
                                </div>

                                {{-- Enlaces de paginación --}}
                                <div class="flex items-center space-x-2">
                                    {{-- Botón Anterior --}}
                                    @if ($orders->onFirstPage())
                                        <span class="px-4 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed font-medium">
                                            <i class="fas fa-chevron-left mr-1"></i>Anterior
                                        </span>
                                    @else
                                        <a href="{{ $orders->previousPageUrl() }}" 
                                           class="px-4 py-2 bg-white hover:bg-pink-50 text-gray-700 hover:text-pink-600 border border-gray-300 hover:border-pink-300 rounded-lg transition-all duration-200 font-medium shadow-sm">
                                            <i class="fas fa-chevron-left mr-1"></i>Anterior
                                        </a>
                                    @endif

                                    {{-- Páginas numéricas --}}
                                    @php
                                        $start = max($orders->currentPage() - 2, 1);
                                        $end = min($start + 4, $orders->lastPage());
                                        $start = max($end - 4, 1);
                                    @endphp

                                    @if ($start > 1)
                                        <a href="{{ $orders->url(1) }}" 
                                           class="px-3 py-2 bg-white hover:bg-pink-50 text-gray-700 hover:text-pink-600 border border-gray-300 hover:border-pink-300 rounded-lg transition-all duration-200 font-medium shadow-sm">1</a>
                                        @if ($start > 2)
                                            <span class="px-2 text-gray-400">...</span>
                                        @endif
                                    @endif

                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $orders->currentPage())
                                            <span class="px-3 py-2 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-lg font-bold shadow-lg">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $orders->url($page) }}" 
                                               class="px-3 py-2 bg-white hover:bg-pink-50 text-gray-700 hover:text-pink-600 border border-gray-300 hover:border-pink-300 rounded-lg transition-all duration-200 font-medium shadow-sm">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endfor

                                    @if ($end < $orders->lastPage())
                                        @if ($end < $orders->lastPage() - 1)
                                            <span class="px-2 text-gray-400">...</span>
                                        @endif
                                        <a href="{{ $orders->url($orders->lastPage()) }}" 
                                           class="px-3 py-2 bg-white hover:bg-pink-50 text-gray-700 hover:text-pink-600 border border-gray-300 hover:border-pink-300 rounded-lg transition-all duration-200 font-medium shadow-sm">
                                            {{ $orders->lastPage() }}
                                        </a>
                                    @endif

                                    {{-- Botón Siguiente --}}
                                    @if ($orders->hasMorePages())
                                        <a href="{{ $orders->nextPageUrl() }}" 
                                           class="px-4 py-2 bg-white hover:bg-pink-50 text-gray-700 hover:text-pink-600 border border-gray-300 hover:border-pink-300 rounded-lg transition-all duration-200 font-medium shadow-sm">
                                            Siguiente<i class="fas fa-chevron-right ml-1"></i>
                                        </a>
                                    @else
                                        <span class="px-4 py-2 bg-gray-200 text-gray-400 rounded-lg cursor-not-allowed font-medium">
                                            Siguiente<i class="fas fa-chevron-right ml-1"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- Sección de Carritos Pendientes Mejorada --}}
        <div class="bg-white rounded-2xl shadow-xl border border-pink-100 overflow-hidden">
            {{-- Header de Sección --}}
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-shopping-cart text-white text-xl mr-3"></i>
                        <h2 class="text-xl font-bold text-white">Carritos Pendientes</h2>
                    </div>
                    <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium">
                        {{ $carts->count() }} carritos
                    </span>
                </div>
            </div>

            {{-- Contenido de Carritos --}}
            <div class="p-6">
                @if ($carts->isEmpty())
                    <div class="text-center py-12">
                        <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                        <p class="text-xl text-gray-500 font-medium">No hay carritos pendientes</p>
                        <p class="text-gray-400 mt-2">Los carritos abandonados aparecerán aquí</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-indigo-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">
                                        <i class="fas fa-hashtag mr-2"></i>ID Carrito
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">
                                        <i class="fas fa-user mr-2"></i>Usuario
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">
                                        <i class="fas fa-boxes mr-2"></i>Items
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">
                                        <i class="fas fa-calendar mr-2"></i>Creado
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-indigo-900 uppercase tracking-wider">
                                        <i class="fas fa-cogs mr-2"></i>Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($carts as $cart)
                                    <tr class="hover:bg-indigo-25 transition-colors duration-150">
                                        {{-- ID Carrito --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-indigo-600 text-xs font-bold">#</span>
                                                </div>
                                                <span class="text-sm font-medium text-gray-900">{{ $cart->id }}</span>
                                            </div>
                                        </td>

                                        {{-- Usuario --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-user text-white text-sm"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ optional($cart->user)->name ?? 'Sin usuario' }}
                                                    </div>
                                                    @if (optional($cart->user)->email)
                                                        <div class="text-sm text-gray-500">{{ $cart->user->email }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Items --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                    {{ $cart->cartItems->count() }} items
                                                </span>
                                            </div>
                                        </td>

                                        {{-- Fecha --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-medium">
                                                {{ $cart->created_at->format('d/m/Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $cart->created_at->format('H:i') }}
                                            </div>
                                        </td>

                                        {{-- Acciones --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div x-data="{ openCartDetail: false }" class="flex items-center justify-center">
                                                <button @click="openCartDetail = true"
                                                    class="inline-flex items-center px-3 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg transition-all duration-200 transform hover:scale-105"
                                                    title="Ver detalle de carrito">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    <span class="hidden sm:inline text-xs font-medium">Ver</span>
                                                </button>
                                                
                                                {{-- Modal de detalle de carrito mejorado --}}
                                                <div x-cloak x-show="openCartDetail"
                                                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50"
                                                    @click.away="openCartDetail = false"
                                                    x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                    <div class="bg-white rounded-2xl py-8 px-6 max-w-4xl w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto"
                                                        @keydown.escape.window="openCartDetail = false">
                                                        {{-- Header del Modal --}}
                                                        <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                                                            <div class="flex items-center">
                                                                <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl flex items-center justify-center mr-4">
                                                                    <i class="fas fa-shopping-cart text-white text-lg"></i>
                                                                </div>
                                                                <div>
                                                                    <h3 class="text-2xl font-bold text-gray-800">Detalle de Carrito</h3>
                                                                    <p class="text-gray-600">Carrito #{{ $cart->id }}</p>
                                                                </div>
                                                            </div>
                                                            <button @click="openCartDetail = false"
                                                                class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors duration-200">
                                                                <i class="fas fa-times text-gray-600"></i>
                                                            </button>
                                                        </div>

                                                        {{-- Contenido del Modal --}}
                                                        <div class="space-y-6">
                                                            {{-- Información del Usuario --}}
                                                            <div class="bg-gray-50 rounded-xl p-4">
                                                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                                                    <i class="fas fa-user mr-2 text-indigo-500"></i>Información del Usuario
                                                                </h4>
                                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                    <div>
                                                                        <p class="text-sm text-gray-600">Nombre</p>
                                                                        <p class="font-medium text-gray-800">
                                                                            {{ optional($cart->user)->name ?? 'Sin usuario' }}
                                                                        </p>
                                                                    </div>
                                                                    @if (optional($cart->user)->email)
                                                                        <div>
                                                                            <p class="text-sm text-gray-600">Email</p>
                                                                            <p class="font-medium text-gray-800">{{ $cart->user->email }}</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            {{-- Items del Carrito --}}
                                                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                                                                <div class="bg-indigo-50 px-4 py-3 border-b border-indigo-100">
                                                                    <h4 class="font-semibold text-gray-800 flex items-center">
                                                                        <i class="fas fa-shopping-cart mr-2 text-indigo-500"></i>Items en el Carrito
                                                                    </h4>
                                                                </div>
                                                                <div class="overflow-x-auto">
                                                                    <table class="min-w-full text-sm">
                                                                        <thead class="bg-indigo-100 text-indigo-900">
                                                                            <tr>
                                                                                <th class="px-4 py-3 text-left font-semibold">Producto</th>
                                                                                <th class="px-4 py-3 text-center font-semibold">Cantidad</th>
                                                                                <th class="px-4 py-3 text-right font-semibold">Precio Unit.</th>
                                                                                <th class="px-4 py-3 text-right font-semibold">Subtotal</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="divide-y divide-gray-100">
                                                                            @php $cartTotal = 0; @endphp
                                                                            @foreach ($cart->cartItems as $item)
                                                                                @php
                                                                                    $subtotal = $item->cantidad * $item->precio_unitario;
                                                                                    $cartTotal += $subtotal;
                                                                                @endphp
                                                                                <tr class="hover:bg-gray-50">
                                                                                    <td class="px-4 py-3 font-medium text-gray-800">
                                                                                        {{ optional($item->product)->nombre ?? 'Producto eliminado' }}
                                                                                    </td>
                                                                                    <td class="px-4 py-3 text-center">
                                                                                        <span class="bg-gray-100 px-2 py-1 rounded-full text-xs font-medium">
                                                                                            {{ $item->cantidad }}
                                                                                        </span>
                                                                                    </td>
                                                                                    <td class="px-4 py-3 text-right font-medium">
                                                                                        ${{ number_format($item->precio_unitario, 2) }}
                                                                                    </td>
                                                                                    <td class="px-4 py-3 text-right font-bold text-green-600">
                                                                                        ${{ number_format($subtotal, 2) }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                        <tfoot class="bg-indigo-50">
                                                                            <tr>
                                                                                <td colspan="3" class="px-4 py-3 text-right font-bold text-indigo-800">
                                                                                    Total del Carrito:
                                                                                </td>
                                                                                <td class="px-4 py-3 text-right font-bold text-indigo-800 text-lg">
                                                                                    ${{ number_format($cartTotal, 2) }}
                                                                                </td>
                                                                            </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                            {{-- Información Adicional --}}
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                <div class="bg-gray-50 rounded-lg p-4">
                                                                    <p class="text-sm text-gray-600 mb-1">Fecha de Creación</p>
                                                                    <p class="font-semibold text-gray-800">
                                                                        {{ $cart->created_at->format('d/m/Y H:i') }}
                                                                    </p>
                                                                </div>
                                                                <div class="bg-gray-50 rounded-lg p-4">
                                                                    <p class="text-sm text-gray-600 mb-1">Estado</p>
                                                                    <p class="font-semibold text-gray-800 capitalize">
                                                                        {{ $cart->status ?? 'Activo' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Footer del Modal --}}
                                                        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                                                            <button @click="openCartDetail = false"
                                                                class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all duration-200">
                                                                Cerrar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection