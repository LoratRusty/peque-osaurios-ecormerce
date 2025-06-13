@extends('layouts.admin')

@section('title', 'Facturas y Carritos Pendientes')

@section('content')
    <div class="max-w-5xl mx-auto p-6 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10">

        {{-- Sección de Filtros Dinámicos --}}
        <div x-data="{ open: {{ request()->hasAny(['search', 'status', 'date_from', 'date_to', 'min_total', 'max_total']) ? 'true' : 'false' }} }" class="mb-6">
            <button @click="open = !open"
                class="flex items-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg transition">
                <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="mr-2"></i>
                <span x-text="open ? 'Ocultar Filtros' : 'Mostrar Filtros'"></span>
            </button>
            <div x-show="open" x-transition class="mt-4 bg-pink-50 p-4 rounded-xl border border-pink-200">
                <form method="GET" action="{{ route('admin.invoice') }}"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    {{-- Búsqueda por usuario o ID --}}
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Buscar (usuario, email o
                            ID)</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Nombre, email o ID"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-pink-300 focus:border-pink-300 transition" />
                    </div>

                    {{-- Filtrar por estado --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-pink-300 focus:border-pink-300 transition">
                            <option value="">Todos</option>
                            @foreach (['pendiente', 'procesando', 'enviado', 'cancelado', 'completado'] as $st)
                                <option value="{{ $st }}" @if (request('status') === $st) selected @endif
                                    class="capitalize">{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Rango de fecha: desde --}}
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700">Fecha Desde</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-pink-300 focus:border-pink-300 transition" />
                    </div>

                    {{-- Rango de fecha: hasta --}}
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700">Fecha Hasta</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-pink-300 focus:border-pink-300 transition" />
                    </div>

                    {{-- Total mínimo --}}
                    <div>
                        <label for="min_total" class="block text-sm font-medium text-gray-700">Total Mínimo ($)</label>
                        <input type="number" step="0.01" name="min_total" id="min_total"
                            value="{{ request('min_total') }}" placeholder="0.00"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-pink-300 focus:border-pink-300 transition" />
                    </div>

                    {{-- Total máximo --}}
                    <div>
                        <label for="max_total" class="block text-sm font-medium text-gray-700">Total Máximo ($)</label>
                        <input type="number" step="0.01" name="max_total" id="max_total"
                            value="{{ request('max_total') }}" placeholder="0.00"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-pink-300 focus:border-pink-300 transition" />
                    </div>

                    {{-- Botones de aplicar o limpiar --}}
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg transition">
                            Aplicar Filtros
                        </button>
                        <a href="{{ route('admin.invoice') }}"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Órdenes Realizadas --}}
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Facturas Realizadas</h2>
        @if ($orders->isEmpty())
            <p class="text-gray-600">No hay órdenes registradas.</p>
        @else
            <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-pink-100 text-pink-900 uppercase tracking-wide text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-left">ID Orden</th>
                            <th class="px-4 py-3 text-left">Usuario</th>
                            <th class="px-4 py-3 text-left">Total</th>
                            <th class="px-4 py-3 text-left">Estado</th>
                            <th class="px-4 py-3 text-left">Fecha</th>
                            <th class="px-4 py-3 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-pink-50 transition">
                                {{-- ID Orden --}}
                                <td class="px-4 py-3 text-gray-800">{{ $order->id }}</td>

                                {{-- Usuario --}}
                                <td class="px-4 py-3 text-gray-800">
                                    {{ optional($order->user)->name ?? 'Sin usuario' }}
                                    @if (optional($order->user)->email)
                                        <br>
                                        <span class="text-xs text-gray-500">{{ $order->user->email }}</span>
                                    @endif
                                </td>

                                {{-- Total --}}
                                <td class="px-4 py-3 text-gray-800">${{ number_format($order->total, 2) }}</td>

                                {{-- Estado --}}
                                <td class="px-4 py-3">
                                    <span
                                        class="capitalize inline-block px-2 py-1 text-xs font-medium 
                                    @switch($order->status)
                                        @case('pendiente') bg-yellow-100 text-yellow-800 @break
                                        @case('procesando') bg-blue-100 text-blue-800 @break
                                        @case('enviado') bg-indigo-100 text-indigo-800 @break
                                        @case('completado') bg-green-100 text-green-800 @break
                                        @case('cancelado') bg-red-100 text-red-800 @break
                                        @default bg-gray-100 text-gray-800
                                    @endswitch
                                ">
                                        {{ $order->status }}
                                    </span>
                                </td>

                                {{-- Fecha --}}
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $order->created_at->format('d/m/Y') }}
                                    <br>
                                    <span class="text-xs">{{ $order->created_at->format('H:i') }}</span>
                                </td>

                                {{-- Acciones: Ver detalle y Cambiar estado --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center space-x-2">
                                        {{-- Botón ver detalle --}}
                                        <div x-data="{ openDetail: false }" class="relative">
                                            <button @click="openDetail = true"
                                                class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition"
                                                title="Ver detalle de orden">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            {{-- Modal de detalle de orden --}}
                                            <div x-cloak x-show="openDetail"
                                                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50"
                                                @click.away="openDetail = false" x-transition:enter="ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="ease-in duration-200"
                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                <div class="bg-white rounded-2xl py-8 px-6 max-w-2xl w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto flex flex-col"
                                                    @keydown.escape.window="openDetail = false">
                                                    {{-- Header --}}
                                                    <div class="flex justify-between items-center mb-6">
                                                        <h3 class="text-xl font-semibold text-pink-600">Detalle Orden
                                                            #{{ $order->id }}</h3>
                                                        <button @click="openDetail = false"
                                                            class="text-gray-500 hover:text-gray-700">
                                                            <i class="fas fa-times text-lg"></i>
                                                        </button>
                                                    </div>
                                                    {{-- Información principal --}}
                                                    <div class="space-y-4">
                                                        {{-- Usuario --}}
                                                        <div>
                                                            <h4 class="font-semibold text-gray-700">Usuario</h4>
                                                            <p class="text-gray-800">
                                                                {{ optional($order->user)->name ?? 'Sin usuario' }}
                                                                @if (optional($order->user)->email)
                                                                    <br><span
                                                                        class="text-sm text-gray-500">{{ $order->user->email }}</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                        {{-- Dirección de envío --}}
                                                        <div>
                                                            <h4 class="font-semibold text-gray-700">Dirección de Envío</h4>
                                                            <p class="text-gray-800 break-words">
                                                                {{ $order->direccion_envio }}</p>
                                                        </div>
                                                        {{-- Método de pago --}}
                                                        @if ($order->payment && $order->payment->paymentType)
                                                            <div>
                                                                <h4 class="font-semibold text-gray-700">Método de Pago</h4>
                                                                <p class="text-gray-800">
                                                                    {{ $order->payment->paymentType->nombre }}
                                                                </p>
                                                            </div>
                                                        @else
                                                            <p>Método de pago no disponible</p>
                                                        @endif
                                                        {{-- Items de la orden --}}
                                                        <div>
                                                            <h4 class="font-semibold text-gray-700">Items</h4>
                                                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                                                <table class="min-w-full text-sm">
                                                                    <thead class="bg-pink-100 text-pink-900 uppercase tracking-wide text-xs font-semibold">
                                                                        <tr>
                                                                            <th class="px-3 py-2 text-left">Producto</th>
                                                                            <th class="px-3 py-2 text-center">Cant.</th>
                                                                            <th class="px-3 py-2 text-right">Precio Unit.
                                                                            </th>
                                                                            <th class="px-3 py-2 text-right">Subtotal</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @php $sumSubtotal = 0; @endphp
                                                                        @foreach ($order->orderItems as $item)
                                                                            @php
                                                                                $subtotal =
                                                                                    $item->cantidad *
                                                                                    $item->precio_unitario;
                                                                                $sumSubtotal += $subtotal;
                                                                            @endphp
                                                                            <tr class="border-t border-gray-100">
                                                                                <td class="px-3 py-2">
                                                                                    {{ optional($item->product)->nombre ?? 'Producto eliminado' }}
                                                                                </td>
                                                                                <td class="px-3 py-2 text-center">
                                                                                    {{ $item->cantidad }}</td>
                                                                                <td class="px-3 py-2 text-right">
                                                                                    ${{ number_format($item->precio_unitario, 2) }}
                                                                                </td>
                                                                                <td class="px-3 py-2 text-right">
                                                                                    ${{ number_format($subtotal, 2) }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr class="bg-gray-50">
                                                                            <td colspan="3"
                                                                                class="px-3 py-2 text-right font-medium">
                                                                                Subtotal:</td>
                                                                            <td class="px-3 py-2 text-right font-semibold">
                                                                                ${{ number_format($sumSubtotal, 2) }}</td>
                                                                        </tr>
                                                                        <tr class="bg-gray-50">
                                                                            <td colspan="3"
                                                                                class="px-3 py-2 text-right font-medium">
                                                                                Total:</td>
                                                                            <td class="px-3 py-2 text-right font-semibold">
                                                                                ${{ number_format($order->total, 2) }}</td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        {{-- Metadata --}}
                                                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                                            <div>
                                                                <p>Fecha creación</p>
                                                                <p class="font-medium">
                                                                    {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                                            </div>
                                                            <div>
                                                                <p>ID Pago</p>
                                                                <p class="font-medium">{{ $order->pago_id ?? '—' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Footer --}}
                                                    <div class="mt-6 flex justify-end space-x-2">
                                                        <button @click="openDetail = false"
                                                            class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                                                            Cerrar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Botón Cambiar Estado --}}
                                        <div x-data="{ openStatus: false, newStatus: '{{ $order->status }}' }" class="relative">
                                            <button @click="openStatus = true"
                                                class="flex items-center justify-center w-9 h-9 rounded-full bg-green-100 text-green-600 hover:bg-green-200 transition"
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
                                                    <h4 class="text-lg font-semibold text-gray-700 mb-4">Cambiar Estado
                                                        Orden #{{ $order->id }}</h4>
                                                    <form method="POST"
                                                        action="{{ route('admin.invoice.updateStatus', $order->id) }}"
                                                        class="w-full max-w-sm">
                                                        @csrf

                                                        <label for="status-select-{{ $order->id }}"
                                                            class="block text-sm font-medium text-gray-700 mb-2">
                                                            Estado
                                                        </label>

                                                        <select id="status-select-{{ $order->id }}" name="status"
                                                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
               focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition"
                                                            aria-label="Seleccionar estado del pedido">
                                                            @foreach (['pendiente', 'procesando', 'enviado', 'cancelado', 'completado'] as $st)
                                                                <option value="{{ $st }}"
                                                                    @if ($order->status === $st) selected @endif
                                                                    class="capitalize">
                                                                    {{ ucfirst($st) }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        <div class="mt-4 flex justify-end space-x-3">
                                                            <button type="button" @click="openStatus = false"
                                                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                                                                Cancelar
                                                            </button>

                                                            <button type="submit"
                                                                class="px-5 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg font-semibold transition">
                                                                Actualizar
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

                {{-- Paginación (si aplica) --}}
                <div class="mt-4">
                    {{ $orders->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>

    {{-- Carritos Pendientes --}}
    <div class="max-w-5xl mx-auto p-6 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Carritos Pendientes</h2>
        @if ($carts->isEmpty())
            <p class="text-gray-600">No hay carritos pendientes.</p>
        @else
            <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-pink-100 text-pink-900 uppercase tracking-wide text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-left">ID Carrito</th>
                            <th class="px-4 py-3 text-left">Usuario</th>
                            <th class="px-4 py-3 text-left">Creado</th>
                            <th class="px-4 py-3 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($carts as $cart)
                            <tr class="hover:bg-pink-50 transition">
                                {{-- ID Carrito --}}
                                <td class="px-4 py-3 text-gray-800">{{ $cart->id }}</td>

                                {{-- Usuario --}}
                                <td class="px-4 py-3 text-gray-800">
                                    {{ optional($cart->user)->name ?? 'Sin usuario' }}
                                    @if (optional($cart->user)->email)
                                        <br>
                                        <span class="text-xs text-gray-500">{{ $cart->user->email }}</span>
                                    @endif
                                </td>

                                {{-- Creado --}}
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $cart->created_at->format('d/m/Y H:i') }}
                                </td>

                                {{-- Acciones: Ver detalle --}}
                                <td class="px-4 py-3">
                                    <div x-data="{ openDetail: false }" class="flex justify-center">
                                        <button @click="openDetail = true"
                                            class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition"
                                            title="Ver detalle de carrito">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        {{-- Modal de detalle de carrito --}}
                                        <div x-cloak x-show="openDetail"
                                            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50"
                                            @click.away="openDetail = false" x-transition:enter="ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="ease-in duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                            <div class="bg-white rounded-2xl py-8 px-6 max-w-2xl w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto flex flex-col"
                                                @keydown.escape.window="openDetail = false">
                                                {{-- Header --}}
                                                <div class="flex justify-between items-center mb-6">
                                                    <h3 class="text-xl font-semibold text-pink-600">Detalle Carrito
                                                        #{{ $cart->id }}</h3>
                                                    <button @click="openDetail = false"
                                                        class="text-gray-500 hover:text-gray-700">
                                                        <i class="fas fa-times text-lg"></i>
                                                    </button>
                                                </div>

                                                {{-- Información principal --}}
                                                <div class="space-y-4">
                                                    {{-- Usuario --}}
                                                    <div>
                                                        <h4 class="font-semibold text-gray-700">Usuario</h4>
                                                        <p class="text-gray-800">
                                                            {{ optional($cart->user)->name ?? 'Sin usuario' }}
                                                            @if (optional($cart->user)->email)
                                                                <br><span
                                                                    class="text-sm text-gray-500">{{ $cart->user->email }}</span>
                                                            @endif
                                                        </p>
                                                    </div>

                                                    {{-- Items del carrito --}}
                                                    <div>
                                                        <h4 class="font-semibold text-gray-700">Items en Carrito</h4>
                                                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                                                            <table class="min-w-full text-sm">
                                                                <thead class="bg-pink-100 text-pink-900 uppercase tracking-wide text-xs font-semibold">
                                                                    <tr>
                                                                        <th class="px-3 py-2 text-left">Producto</th>
                                                                        <th class="px-3 py-2 text-center">Cant.</th>
                                                                        <th class="px-3 py-2 text-right">Precio Unit.</th>
                                                                        <th class="px-3 py-2 text-right">Subtotal</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php $cartSum = 0; @endphp
                                                                    @foreach ($cart->cartItems as $item)
                                                                        @php
                                                                            $subtotal =
                                                                                $item->cantidad *
                                                                                $item->precio_unitario;
                                                                            $cartSum += $subtotal;
                                                                        @endphp
                                                                        <tr class="border-t border-gray-100">
                                                                            <td class="px-3 py-2">
                                                                                {{ optional($item->product)->nombre ?? 'Producto eliminado' }}
                                                                            </td>
                                                                            <td class="px-3 py-2 text-center">
                                                                                {{ $item->cantidad }}</td>
                                                                            <td class="px-3 py-2 text-right">
                                                                                ${{ number_format($item->precio_unitario, 2) }}
                                                                            </td>
                                                                            <td class="px-3 py-2 text-right">
                                                                                ${{ number_format($subtotal, 2) }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr class="bg-gray-50">
                                                                        <td colspan="3"
                                                                            class="px-3 py-2 text-right font-medium">
                                                                            Subtotal:</td>
                                                                        <td class="px-3 py-2 text-right font-semibold">
                                                                            ${{ number_format($cartSum, 2) }}</td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    {{-- Metadata --}}
                                                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                                        <div>
                                                            <p>Creado</p>
                                                            <p class="font-medium">
                                                                {{ $cart->created_at->format('d/m/Y H:i') }}</p>
                                                        </div>
                                                        <div>
                                                            <p>Estado</p>
                                                            <p class="font-medium capitalize">{{ $cart->status }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Footer --}}
                                                <div class="mt-6 flex justify-end">
                                                    <button @click="openDetail = false"
                                                        class="px-5 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg transition">
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

                {{-- Paginación (si aplica) --}}
                <div class="mt-4">
                    {{ $carts->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
