@extends('layouts.admin')
@section('content')
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-rose-50 py-6 sm:py-8 pb-24">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Header de bienvenida --}}
            <div class="relative overflow-hidden rounded-2xl shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 opacity-90"></div>
                <div class="relative p-6 sm:p-8 text-white">
                    <h1 class="text-2xl sm:text-3xl font-bold mb-2 truncate">
                        ¡Hola, {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-pink-100 text-base sm:text-lg max-w-full sm:max-w-md">
                        Bienvenido al panel de control de
                        <span
                            class="font-bold bg-white/20 px-3 py-1 rounded-full capitalize backdrop-blur-sm whitespace-nowrap">
                            {{ getRolNombre(auth()->user()->tipo) }}
                        </span>
                    </p>
                </div>
            </div>

            @php $tipo = auth()->user()->tipo; @endphp

            {{-- Sección Soporte --}}
            @if (in_array($tipo, ['soporte', 'admin']))
                <section class="group">
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden">
                        <div
                            class="bg-gradient-to-r from-emerald-500 to-teal-600 px-4 sm:px-6 py-3 sm:py-4 flex items-center space-x-2 sm:space-x-3">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25A9.75 9.75 0 1 0 21.75 12 9.75 9.75 0 0 0 12 2.25Z">
                                </path>
                            </svg>
                            <h3 class="text-lg sm:text-xl font-bold text-white truncate">Centro de Soporte</h3>
                        </div>
                        <div class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <div
                                class="bg-gradient-to-br from-blue-50 to-indigo-100 p-4 sm:p-6 rounded-xl border border-blue-200 hover:scale-105 transition-transform duration-200">
                                <div class="flex items-center justify-between mb-2 sm:mb-3">
                                    <h4 class="font-semibold text-gray-700 text-sm sm:text-base truncate">Mensajes Nuevos
                                    </h4>
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-3xl sm:text-4xl font-bold text-blue-600 mb-1 sm:mb-2 truncate">
                                    {{ $newMessagesCount ?? '0' }}</p>
                                <p class="text-xs sm:text-sm text-gray-600 truncate">Mensajes sin responder</p>
                            </div>

                            <div
                                class="bg-gradient-to-br from-purple-50 to-pink-100 p-4 sm:p-6 rounded-xl border border-purple-200 hover:scale-105 transition-transform duration-200">
                                <div class="flex items-center justify-between mb-2 sm:mb-3">
                                    <h4 class="font-semibold text-gray-700 text-sm sm:text-base truncate">Opiniones
                                        Recientes</h4>
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-3xl sm:text-4xl font-bold text-purple-600 mb-1 sm:mb-2 truncate">
                                    {{ $recentTestimonialsCount ?? '0' }}</p>
                                <p class="text-xs sm:text-sm text-gray-600 truncate">Nuevas reseñas</p>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            {{-- Sección Inventario --}}
            @if (in_array($tipo, ['inventario', 'admin']))
                <section class="group">
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden">
                        <div
                            class="bg-gradient-to-r from-amber-500 to-orange-600 px-4 sm:px-6 py-3 sm:py-4 flex items-center space-x-2 sm:space-x-3">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <h3 class="text-lg sm:text-xl font-bold text-white truncate">Control de Inventario</h3>
                        </div>
                        <div
                            class="p-4 sm:p-6 bg-gradient-to-br from-red-50 to-orange-100 rounded-xl border border-red-200">
                            <div class="flex items-center space-x-2 sm:space-x-3 mb-3">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="text-base sm:text-lg font-semibold text-gray-700 truncate">Productos con Bajo
                                    Stock</h4>
                            </div>
                            <div class="space-y-2 sm:space-y-3 max-h-96 overflow-y-auto">
                                @forelse($lowStockProducts ?? [] as $product)
                                    <div
                                        class="bg-white p-3 sm:p-4 rounded-lg border-l-4 border-red-400 shadow-sm hover:shadow-md transition-shadow truncate">
                                        <div class="flex items-center justify-between">
                                            <span class="font-medium text-gray-800 truncate">{{ $product->nombre }}</span>
                                            <div class="flex items-center space-x-1 sm:space-x-2">
                                                <span class="text-xs sm:text-sm text-gray-600">Stock:</span>
                                                <span
                                                    class="bg-red-100 text-red-800 px-2 py-0.5 rounded-full text-xs sm:text-sm font-semibold">{{ $product->total_stock }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div
                                        class="bg-green-100 p-3 rounded-lg border-l-4 border-green-400 flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-green-800 font-medium text-sm">¡Excelente! No hay productos con
                                            bajo stock.</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            {{-- Sección Ventas --}}
            @if (in_array($tipo, ['ventas', 'admin']))
                <section class="group">
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden">
                        <div
                            class="bg-gradient-to-r from-green-500 to-emerald-600 px-4 sm:px-6 py-3 sm:py-4 flex items-center space-x-2 sm:space-x-3">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                            <h3 class="text-lg sm:text-xl font-bold text-white truncate">Panel de Ventas</h3>
                        </div>
                        <div class="p-4 sm:p-6 space-y-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                            {{-- Últimos Pagos --}}
                            <div
                                class="bg-gradient-to-br from-blue-50 to-cyan-100 rounded-xl p-4 sm:p-6 border border-blue-200">
                                <div class="flex items-center space-x-2 sm:space-x-3 mb-3">
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="text-base sm:text-lg font-semibold text-gray-700 truncate">Últimos Pagos
                                    </h4>
                                </div>
                                <div class="space-y-2 sm:space-y-3">
                                    @forelse($recentPayments ?? [] as $payment)
                                        <div
                                            class="bg-white p-3 sm:p-4 rounded-lg shadow-sm border hover:shadow-md transition-shadow">
                                            <div
                                                class="flex items-center justify-between flex-wrap gap-1 sm:gap-2 text-xs sm:text-sm">
                                                <div class="flex items-center space-x-2 sm:space-x-3 truncate">
                                                    <span
                                                        class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-xs font-medium truncate">#{{ $payment->id }}</span>
                                                    <span
                                                        class="px-2 py-0.5 rounded-full font-semibold truncate
                                            {{ $payment->estado === 'completado'
                                                ? 'bg-green-100 text-green-800'
                                                : ($payment->estado === 'pendiente'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : 'bg-red-100 text-red-800') }}">
                                                        {{ ucfirst($payment->estado) }}
                                                    </span>
                                                </div>
                                                <div
                                                    class="flex items-center space-x-2 sm:space-x-4 text-gray-600 truncate">
                                                    <span
                                                        class="font-semibold text-green-600 truncate">${{ number_format($payment->monto, 2) }}</span>
                                                    <span
                                                        class="truncate">{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="bg-gray-100 p-4 rounded-lg text-center">
                                            <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-gray-600 text-sm">No hay pagos recientes</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            {{-- Órdenes Recientes --}}
                            <div
                                class="bg-gradient-to-br from-purple-50 to-pink-100 rounded-xl p-6 border border-purple-200">
                                <div class="flex items-center space-x-3 mb-4">
                                    <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-700">Órdenes Recientes</h4>
                                </div>
                                <div class="space-y-3">
                                    @forelse($recentOrders ?? [] as $order)
                                        <div
                                            class="bg-white p-4 rounded-lg shadow-sm border hover:shadow-md transition-shadow">
                                            <div class="flex items-center justify-between flex-wrap gap-2">
                                                <div class="flex items-center space-x-3">
                                                    <span
                                                        class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm font-medium">#{{ $order->id }}</span>
                                                    <span
                                                        class="px-3 py-1 rounded-full text-sm font-semibold
                                            {{ $order->status === 'completado'
                                                ? 'bg-green-100 text-green-800'
                                                : ($order->status === 'pendiente'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : ($order->status === 'procesando'
                                                        ? 'bg-blue-100 text-blue-800'
                                                        : 'bg-red-100 text-red-800')) }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                                    <span
                                                        class="font-semibold text-green-600">${{ number_format($order->total, 2) }}</span>
                                                    <span>{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="bg-gray-100 p-4 rounded-lg text-center">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            <span class="text-gray-600">No hay órdenes recientes</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

        </div>
    </div>
@endsection
