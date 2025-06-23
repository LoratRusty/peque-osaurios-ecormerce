@extends('layouts.cliente')

@section('title', 'Mis Órdenes')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-rose-50 to-pink-100">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-8" x-data="{ expandedOrder: null }">
            <!-- Header optimizado para móvil -->
            <div class="mb-6 sm:mb-10">
                <!-- Breadcrumb compacto -->
                <nav class="flex items-center text-xs sm:text-sm text-pink-600 mb-3 sm:mb-4" aria-label="Breadcrumb">
                    <a href="{{ route('cliente.store') }}"
                        class="flex items-center hover:text-pink-700 transition-all duration-300 hover:bg-pink-100 px-2 py-1 rounded-md">
                        <i class="fas fa-store mr-1 sm:mr-2 text-xs sm:text-sm"></i>
                        <span>Tienda</span>
                    </a>
                    <i class="fas fa-chevron-right mx-2 sm:mx-3 text-pink-400 text-xs"></i>
                    <span class="text-pink-800 font-semibold bg-pink-100 px-2 sm:px-3 py-1 rounded-full text-xs">Mis
                        Órdenes</span>
                </nav>

                <!-- Header principal responsivo -->
                <div
                    class="bg-white/60 backdrop-blur-sm rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg border border-pink-200/50">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div
                            class="bg-gradient-to-br from-pink-500 to-pink-600 p-2 sm:p-4 rounded-xl sm:rounded-2xl shadow-lg">
                            <i class="fas fa-box-open text-xl sm:text-3xl text-white"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h1
                                class="text-2xl sm:text-4xl lg:text-5xl font-bold bg-gradient-to-r from-pink-700 to-pink-800 bg-clip-text text-transparent truncate">
                                Mis Órdenes
                            </h1>
                            @if (isset($ordenes) && $ordenes->count() > 0)
                                <div class="flex items-center mt-1 sm:mt-2">
                                    <span
                                        class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-pink-100 text-pink-800">
                                        <i class="fas fa-shopping-bag mr-1 sm:mr-2 text-xs"></i>
                                        {{ $ordenes->count() }} {{ $ordenes->count() == 1 ? 'orden' : 'órdenes' }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if (!isset($ordenes) || $ordenes->isEmpty())
                @if (request('estado'))
                    <!-- Empty state con mejor padding móvil -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl sm:rounded-3xl shadow-2xl border border-pink-200/50 p-8 sm:p-16 text-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-pink-50/50 to-transparent"></div>
                        <div
                            class="absolute top-0 right-0 w-16 h-16 sm:w-32 sm:h-32 bg-pink-100/30 rounded-full -translate-y-8 translate-x-8 sm:-translate-y-16 sm:translate-x-16">
                        </div>

                        <div class="relative z-10">
                            <div class="mb-6 sm:mb-8">
                                <div
                                    class="w-20 h-20 sm:w-32 sm:h-32 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 shadow-lg">
                                    <i class="fas fa-search text-3xl sm:text-5xl text-orange-400"></i>
                                </div>
                                <h2 class="text-xl sm:text-3xl font-bold text-gray-800 mb-2 sm:mb-3 px-2">
                                    No hay órdenes con estado "{{ ucfirst(request('estado')) }}"
                                </h2>
                                <p class="text-gray-600 max-w-lg mx-auto text-sm sm:text-lg leading-relaxed px-2">
                                    No se encontraron órdenes que coincidan con el filtro seleccionado.
                                </p>
                            </div>

                            <div class="flex flex-col gap-3 sm:gap-4 items-center">
                                <a href="{{ route('cliente.myorders') }}"
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-xl sm:rounded-2xl font-bold hover:from-pink-600 hover:to-pink-700 transform hover:scale-105 transition-all duration-300 shadow-xl">
                                    <i class="fas fa-list mr-2 sm:mr-3"></i>
                                    Ver todas las órdenes
                                </a>
                                <a href="{{ route('cliente.store') }}"
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-gray-500 to-gray-600 text-white rounded-xl sm:rounded-2xl font-semibold hover:from-gray-600 hover:to-gray-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                                    <i class="fas fa-store mr-2 sm:mr-3"></i>
                                    Ir a la tienda
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty state sin órdenes -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl sm:rounded-3xl shadow-2xl border border-pink-200/50 p-8 sm:p-16 text-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-pink-50/50 to-transparent"></div>

                        <div class="relative z-10">
                            <div class="mb-6 sm:mb-8">
                                <div
                                    class="w-20 h-20 sm:w-32 sm:h-32 bg-gradient-to-br from-pink-100 to-pink-200 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 shadow-lg">
                                    <i class="fas fa-receipt text-3xl sm:text-5xl text-pink-400"></i>
                                </div>
                                <h2 class="text-xl sm:text-3xl font-bold text-gray-800 mb-2 sm:mb-3">No tienes órdenes aún
                                </h2>
                                <p class="text-gray-600 max-w-lg mx-auto text-sm sm:text-lg leading-relaxed px-2">
                                    Descubre nuestra increíble colección de productos y realiza tu primera compra.
                                </p>
                            </div>

                            <a href="{{ route('cliente.store') }}"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-8 sm:px-10 py-4 sm:py-5 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-xl sm:rounded-2xl font-bold text-base sm:text-lg hover:from-pink-600 hover:to-pink-700 transform hover:scale-105 transition-all duration-300 shadow-xl">
                                <i class="fas fa-store mr-2 sm:mr-3 text-lg sm:text-xl"></i>
                                Explorar productos
                            </a>
                        </div>
                    </div>
                @endif
            @else
                <!-- Filtros optimizados para móvil -->
                <div class="mb-6 sm:mb-8">
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-lg border border-pink-200/50 p-4 sm:p-6">
                        <form method="GET" class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                            <label for="estado" class="text-sm text-pink-800 font-semibold flex items-center">
                                <i class="fas fa-filter mr-2 text-pink-600"></i>
                                Filtrar por estado:
                            </label>
                            <select name="estado" id="estado" onchange="this.form.submit()"
                                class="w-full sm:w-64 border border-pink-200 rounded-xl text-base px-5 py-3 bg-white/90
                    focus:outline-none focus:ring-3 focus:ring-pink-300/50 focus:border-pink-400
                    transition-all duration-200 shadow-sm text-gray-800 font-medium">
                                <option value="">Todos los estados</option>
                                @foreach (['pendiente', 'pagado', 'enviado', 'cancelado', 'completado'] as $estadoOption)
                                    <option value="{{ $estadoOption }}"
                                        {{ request('estado') === $estadoOption ? 'selected' : '' }}>
                                        {{ ucfirst($estadoOption) }}
                                    </option>
                                @endforeach
                            </select>

                        </form>
                    </div>
                </div>

                <!-- Vista móvil: Cards en lugar de tabla -->
                <div class="block sm:hidden space-y-4">
                    @foreach ($ordenes as $orden)
                        <div
                            class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-pink-200/50 overflow-hidden">
                            <!-- Header de la orden -->
                            <div class="p-4 cursor-pointer"
                                @click="expandedOrder = expandedOrder === {{ $orden->id }} ? null : {{ $orden->id }}">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="font-bold text-pink-700 bg-pink-100 px-3 py-1 rounded-full text-xs">
                                        #{{ $orden->id }}
                                    </span>
                                    <div class="text-right">
                                        <div class="text-sm font-medium">{{ $orden->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $orden->created_at->format('H:i') }}</div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between mb-3">
                                    @php
                                        $estilos = [
                                            'pendiente' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'pagado' => 'bg-green-100 text-green-700 border-green-200',
                                            'enviado' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'cancelado' => 'bg-red-100 text-red-700 border-red-200',
                                            'completado' => 'bg-pink-100 text-pink-700 border-pink-200',
                                        ];
                                        $iconos = [
                                            'pendiente' => 'fas fa-clock',
                                            'pagado' => 'fas fa-check-circle',
                                            'enviado' => 'fas fa-truck',
                                            'cancelado' => 'fas fa-times-circle',
                                            'completado' => 'fas fa-trophy',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold border {{ $estilos[$orden->status] ?? 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                        <i class="{{ $iconos[$orden->status] ?? 'fas fa-question' }} mr-1"></i>
                                        {{ ucfirst($orden->status) }}
                                    </span>
                                    <span
                                        class="text-lg font-bold text-gray-900">${{ number_format($orden->total, 2) }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-700">
                                        <i class="fas fa-credit-card mr-1"></i>
                                        {{ $orden->payment->paymentType->nombre ?? '—' }}
                                    </span>
                                    <button class="flex items-center text-pink-600 font-semibold text-sm">
                                        <span
                                            x-text="expandedOrder === {{ $orden->id }} ? 'Ocultar' : 'Ver detalles'"></span>
                                        <i class="fas fa-chevron-down ml-2 transform transition-transform duration-200"
                                            :class="expandedOrder === {{ $orden->id }} ? 'rotate-180' : ''"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Detalles expandibles -->
                            <div x-show="expandedOrder === {{ $orden->id }}"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-screen"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 max-h-screen"
                                x-transition:leave-end="opacity-0 max-h-0"
                                class="border-t border-pink-100 bg-gradient-to-r from-pink-50/50 to-rose-50/50 overflow-hidden">

                                <div class="p-4 space-y-4">
                                    <!-- Información de envío compacta -->
                                    <div class="bg-white/80 rounded-xl p-4 shadow-sm border border-pink-200/30">
                                        <h4 class="text-sm font-bold text-pink-800 mb-3 flex items-center">
                                            <i class="fas fa-truck mr-2 text-pink-600"></i>
                                            Información de Envío
                                        </h4>
                                        <div class="space-y-2 text-xs">
                                            <div class="flex items-start space-x-2">
                                                <i class="fas fa-map-marker-alt text-pink-500 mt-0.5 text-xs"></i>
                                                <div class="flex-1">
                                                    <span class="font-semibold text-gray-700">Dirección:</span>
                                                    <p class="text-gray-600 mt-0.5 break-words">
                                                        {{ $orden->direccion_envio }}</p>
                                                </div>
                                            </div>
                                            @if ($orden->payment->referencia)
                                                <div class="flex items-start space-x-2">
                                                    <i class="fas fa-receipt text-pink-500 mt-0.5 text-xs"></i>
                                                    <div class="flex-1">
                                                        <span class="font-semibold text-gray-700">Referencia:</span>
                                                        <p class="text-gray-600 mt-0.5 font-mono text-xs break-all">
                                                            {{ $orden->payment->referencia }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Productos compactos -->
                                    <div class="bg-white/80 rounded-xl p-4 shadow-sm border border-pink-200/30">
                                        <h4 class="text-sm font-bold text-pink-800 mb-3 flex items-center">
                                            <i class="fas fa-shopping-bag mr-2 text-pink-600"></i>
                                            Productos ({{ $orden->orderItems->count() }})
                                        </h4>
                                        <div class="space-y-3">
                                            @foreach ($orden->orderItems as $item)
                                                <div
                                                    class="flex items-start space-x-3 bg-gradient-to-r from-white to-pink-50/30 border border-pink-200/30 rounded-xl p-3">
                                                    @if ($item->product && $item->product->imagen)
                                                        <div class="relative flex-shrink-0">
                                                            <img src="{{ asset('storage/' . $item->product->imagen) }}"
                                                                alt="{{ $item->product->nombre }}"
                                                                class="w-12 h-12 object-cover rounded-lg shadow-sm">
                                                            <div
                                                                class="absolute -top-1 -right-1 bg-pink-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                                                {{ $item->cantidad }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="flex-1 min-w-0">
                                                        <h5 class="font-bold text-gray-800 text-sm leading-tight">
                                                            {{ $item->product->nombre ?? 'Producto eliminado' }}
                                                        </h5>
                                                        <div
                                                            class="flex flex-wrap items-center gap-2 mt-1 text-xs text-gray-600">
                                                            <span class="flex items-center">
                                                                <i class="fas fa-ruler mr-1 text-pink-500"></i>
                                                                {{ $item->size?->etiqueta ?? '—' }}
                                                            </span>
                                                            <span class="flex items-center">
                                                                <i class="fas fa-boxes mr-1 text-pink-500"></i>
                                                                x{{ $item->cantidad }}
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center justify-between mt-2">
                                                            <span class="text-base font-bold text-pink-600">
                                                                ${{ number_format($item->precio_unitario * $item->cantidad, 2) }}
                                                            </span>
                                                            <span class="text-xs text-gray-500">
                                                                ${{ number_format($item->precio_unitario, 2) }} c/u
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Vista desktop: Tabla original pero optimizada -->
                <div
                    class="hidden sm:block bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-pink-200/50 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-gray-700">
                            <thead class="bg-gradient-to-r from-pink-100 to-pink-50 text-pink-800 text-left">
                                <tr>
                                    <th class="px-4 lg:px-6 py-4 lg:py-5 text-xs font-bold uppercase tracking-wider">
                                        <i class="fas fa-hashtag mr-2"></i>ID
                                    </th>
                                    <th class="px-4 lg:px-6 py-4 lg:py-5 text-xs font-bold uppercase tracking-wider">
                                        <i class="fas fa-calendar mr-2"></i>Fecha
                                    </th>
                                    <th class="px-4 lg:px-6 py-4 lg:py-5 text-xs font-bold uppercase tracking-wider">
                                        <i class="fas fa-info-circle mr-2"></i>Estado
                                    </th>
                                    <th class="px-4 lg:px-6 py-4 lg:py-5 text-xs font-bold uppercase tracking-wider">
                                        <i class="fas fa-dollar-sign mr-2"></i>Total
                                    </th>
                                    <th class="px-4 lg:px-6 py-4 lg:py-5 text-xs font-bold uppercase tracking-wider">
                                        <i class="fas fa-credit-card mr-2"></i>Metodo de Pago
                                    </th>
                                    <th class="px-4 lg:px-6 py-4 lg:py-5 text-xs font-bold uppercase tracking-wider">
                                        <i class="fas fa-cog mr-2"></i>Acción
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-pink-100/50">
                                @foreach ($ordenes as $orden)
                                    <!-- Fila principal -->
                                    <tr class="hover:bg-pink-50/70 transition-all duration-200 cursor-pointer group"
                                        @click="expandedOrder = expandedOrder === {{ $orden->id }} ? null : {{ $orden->id }}">
                                        <td class="px-4 lg:px-6 py-4 lg:py-5">
                                            <span
                                                class="font-bold text-pink-700 bg-pink-100 px-2 lg:px-3 py-1 rounded-full text-xs">
                                                #{{ $orden->id }}
                                            </span>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 lg:py-5">
                                            <div class="flex flex-col">
                                                <span class="font-medium">{{ $orden->created_at->format('d/m/Y') }}</span>
                                                <span
                                                    class="text-xs text-gray-500">{{ $orden->created_at->format('H:i') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 lg:py-5">
                                            @php
                                                $estilos = [
                                                    'pendiente' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                    'pagado' => 'bg-green-100 text-green-700 border-green-200',
                                                    'enviado' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                    'cancelado' => 'bg-red-100 text-red-700 border-red-200',
                                                    'completado' => 'bg-pink-100 text-pink-700 border-pink-200',
                                                ];
                                                $iconos = [
                                                    'pendiente' => 'fas fa-clock',
                                                    'pagado' => 'fas fa-check-circle',
                                                    'enviado' => 'fas fa-truck',
                                                    'cancelado' => 'fas fa-times-circle',
                                                    'completado' => 'fas fa-trophy',
                                                ];
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2 lg:px-3 py-1 lg:py-2 rounded-full text-xs font-bold border {{ $estilos[$orden->status] ?? 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                                <i
                                                    class="{{ $iconos[$orden->status] ?? 'fas fa-question' }} mr-1 lg:mr-2"></i>
                                                <span class="hidden lg:inline">{{ ucfirst($orden->status) }}</span>
                                            </span>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 lg:py-5">
                                            <span
                                                class="text-base lg:text-lg font-bold text-gray-900">${{ number_format($orden->total, 2) }}</span>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 lg:py-5">
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-700">
                                                <i class="fas fa-credit-card mr-1"></i>
                                                <span
                                                    class="hidden lg:inline">{{ $orden->payment->paymentType->nombre ?? '—' }}</span>
                                                <span class="lg:hidden">💳</span>
                                            </span>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 lg:py-5">
                                            <div class="flex items-center space-x-2">
                                                @if (in_array($orden->status, ['pagado', 'enviado', 'completado']))
                                                    <a href="{{ route('cliente.invoice.download', $orden->id) }}"
                                                        class="flex items-center text-green-600 hover:text-green-800 font-semibold text-xs bg-green-50 hover:bg-green-100 px-2 py-1 rounded-lg transition-all duration-200"
                                                        title="Descargar factura"
                                                        target="_blanck">
                                                        <i class="fas fa-file-pdf mr-1"></i>
                                                        <span class="hidden lg:inline">PDF</span>
                                                    </a>
                                                @endif
                                                <button
                                                    class="flex items-center text-pink-600 hover:text-pink-800 font-semibold text-sm hover:bg-pink-50 px-2 lg:px-3 py-2 rounded-lg transition-all duration-200">
                                                    <i class="fas fa-eye mr-1 lg:mr-2"></i>
                                                    <span class="hidden lg:inline"
                                                        x-text="expandedOrder === {{ $orden->id }} ? 'Ocultar' : 'Ver'"></span>
                                                    <i class="fas fa-chevron-down ml-1 lg:ml-2 transform transition-transform duration-200"
                                                        :class="expandedOrder === {{ $orden->id }} ? 'rotate-180' : ''"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Fila expandible igual que antes pero con padding responsive -->
                                    <tr x-show="expandedOrder === {{ $orden->id }}"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 transform -translate-y-4"
                                        x-transition:enter-end="opacity-100 transform translate-y-0"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100 transform translate-y-0"
                                        x-transition:leave-end="opacity-0 transform -translate-y-4"
                                        class="bg-gradient-to-r from-pink-50/50 to-rose-50/50">
                                        <td colspan="6" class="px-4 lg:px-6 py-4 lg:py-6">
                                            <!-- Mismo contenido pero con padding responsive -->
                                            <div
                                                class="bg-white/80 rounded-xl lg:rounded-2xl p-4 lg:p-6 mb-4 lg:mb-6 shadow-lg border border-pink-200/50">
                                                <h4
                                                    class="text-base lg:text-lg font-bold text-pink-800 mb-3 lg:mb-4 flex items-center">
                                                    <i class="fas fa-truck mr-2 lg:mr-3 text-pink-600"></i>
                                                    Información de Envío
                                                </h4>
                                                <div class="grid md:grid-cols-2 gap-3 lg:gap-4 text-sm">
                                                    <div class="flex items-start space-x-2 lg:space-x-3">
                                                        <i class="fas fa-map-marker-alt text-pink-500 mt-1"></i>
                                                        <div>
                                                            <span class="font-semibold text-gray-700">Dirección:</span>
                                                            <p class="text-gray-600 mt-1">{{ $orden->direccion_envio }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-start space-x-2 lg:space-x-3">
                                                        <i class="fas fa-receipt text-pink-500 mt-1"></i>
                                                        <div>
                                                            <span class="font-semibold text-gray-700">Referencia:</span>
                                                            <p
                                                                class="text-gray-600 mt-1 font-mono text-xs lg:text-sm break-all">
                                                                {{ $orden->payment->referencia ?? '—' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                class="bg-white/80 rounded-xl lg:rounded-2xl p-4 lg:p-6 shadow-lg border border-pink-200/50">
                                                <h4
                                                    class="text-base lg:text-lg font-bold text-pink-800 mb-3 lg:mb-4 flex items-center">
                                                    <i class="fas fa-shopping-bag mr-2 lg:mr-3 text-pink-600"></i>
                                                    Productos ({{ $orden->orderItems->count() }})
                                                </h4>
                                                <div class="grid gap-3 lg:gap-4">
                                                    @foreach ($orden->orderItems as $item)
                                                        <div
                                                            class="flex items-center space-x-3 lg:space-x-4 bg-gradient-to-r from-white to-pink-50/30 border border-pink-200/30 rounded-xl lg:rounded-2xl p-3 lg:p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                                                            @if ($item->product && $item->product->imagen)
                                                                <div class="relative flex-shrink-0">
                                                                    <img src="{{ asset('storage/' . $item->product->imagen) }}"
                                                                        alt="{{ $item->product->nombre }}"
                                                                        class="w-16 h-16 lg:w-20 lg:h-20 object-cover rounded-lg lg:rounded-xl shadow-md">
                                                                    <div
                                                                        class="absolute -top-1 -right-1 lg:-top-2 lg:-right-2 bg-pink-500 text-white text-xs font-bold rounded-full w-5 h-5 lg:w-6 lg:h-6 flex items-center justify-center">
                                                                        {{ $item->cantidad }}
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="flex-1 min-w-0">
                                                                <h5
                                                                    class="font-bold text-gray-800 text-sm lg:text-lg leading-tight">
                                                                    {{ $item->product->nombre ?? 'Producto eliminado' }}
                                                                </h5>
                                                                <div
                                                                    class="flex flex-wrap items-center gap-2 lg:gap-4 mt-1 lg:mt-2 text-xs lg:text-sm text-gray-600">
                                                                    <span class="flex items-center">
                                                                        <i class="fas fa-ruler mr-1 text-pink-500"></i>
                                                                        Talla: <span
                                                                            class="font-medium ml-1">{{ $item->size?->etiqueta ?? '—' }}</span>
                                                                    </span>
                                                                    <span class="flex items-center">
                                                                        <i class="fas fa-boxes mr-1 text-pink-500"></i>
                                                                        Cantidad: <span
                                                                            class="font-medium ml-1">{{ $item->cantidad }}</span>
                                                                    </span>
                                                                </div>
                                                                <div
                                                                    class="flex items-center justify-between mt-2 lg:mt-3">
                                                                    <span
                                                                        class="text-lg lg:text-2xl font-bold text-pink-600">
                                                                        ${{ number_format($item->precio_unitario * $item->cantidad, 2) }}
                                                                    </span>
                                                                    <span class="text-xs lg:text-sm text-gray-500">
                                                                        ${{ number_format($item->precio_unitario, 2) }} c/u
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Paginación -->
                        @if ($ordenes->hasPages())
                            <div
                                class="mt-6 px-4 py-3 flex items-center justify-between border-t border-gray-200 bg-white rounded-b-lg">
                                {{-- Información de resultados --}}
                                <div class="text-sm text-gray-700">
                                    Mostrando {{ $ordenes->firstItem() }} - {{ $ordenes->lastItem() }} de
                                    {{ $ordenes->total() }}
                                    Ordenes
                                </div>

                                {{-- Paginación --}}
                                <div class="flex items-center space-x-1">
                                    {{-- Botón Anterior --}}
                                    @if ($ordenes->onFirstPage())
                                        <span
                                            class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Anterior</span>
                                    @else
                                        <a href="{{ $ordenes->previousPageUrl() }}"
                                            class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Anterior</a>
                                    @endif

                                    {{-- Páginas numéricas --}}
                                    @foreach ($ordenes->getUrlRange(1, $ordenes->lastPage()) as $page => $url)
                                        @if ($page == $ordenes->currentPage())
                                            <span
                                                class="px-3 py-1 rounded border border-pink-300 bg-pink-100 text-pink-800 font-semibold">{{ $page }}</span>
                                        @else
                                            <a href="{{ $url }}"
                                                class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">{{ $page }}</a>
                                        @endif
                                    @endforeach

                                    {{-- Botón Siguiente --}}
                                    @if ($ordenes->hasMorePages())
                                        <a href="{{ $ordenes->nextPageUrl() }}"
                                            class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Siguiente</a>
                                    @else
                                        <span
                                            class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Siguiente</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            @endif
        </div>
    </div>

    <!-- Estilos adicionales para mejorar la paginación en móvil -->
    <style>
        .pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.25rem;
            padding: 0.5rem;
        }

        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #db2777;
            background-color: #ffffff;
            border: 1px solid #fbcfe8;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
            display: inline-block;
            min-width: 40px;
            text-align: center;
        }

        .pagination .page-link:hover {
            background-color: #fdf2f8;
            border-color: #f9a8d4;
            color: #be185d;
        }

        .pagination .page-item.active .page-link {
            background-color: #ec4899;
            color: white;
            border-color: #ec4899;
            cursor: default;
        }

        .pagination .page-item.disabled .page-link {
            color: #9ca3af;
            background-color: #fff;
            border-color: #fbcfe8;
            cursor: not-allowed;
        }


        /* Mejoras para el scroll horizontal en tabla */
        @media (max-width: 640px) {
            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }

        /* Optimización de fuentes para móvil */
        @media (max-width: 640px) {
            .text-responsive {
                font-size: 0.875rem;
                line-height: 1.25rem;
            }
        }

        /* Mejoras para el Alpine.js en móvil */
        [x-cloak] {
            display: none !important;
        }

        /* Animaciones suaves para móvil */
        @media (prefers-reduced-motion: no-preference) {
            .mobile-card {
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            }

            .mobile-card:active {
                transform: scale(0.98);
            }
        }

        /* Mejoras para botones táctiles */
        @media (max-width: 640px) {
            .touch-target {
                min-height: 44px;
                min-width: 44px;
            }
        }
    </style>
@endsection
