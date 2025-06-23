@extends('layouts.cliente')

@section('title', 'Confirmar pedido')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-pink-50 to-rose-100">
        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Header con icono y breadcrumb -->
            <div class="mb-8">
                <div class="flex items-center text-sm text-pink-600 mb-3">
                    <a href="{{ route('cliente.store') }}" class="hover:text-pink-700 transition-colors duration-200">
                        <i class="fas fa-store mr-1"></i> Tienda
                    </a>
                    <i class="fas fa-chevron-right mx-2 text-pink-400"></i>
                    <span class="text-pink-800 font-medium">Confirmación de pedido</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="bg-pink-100 p-3 rounded-full">
                        <i class="fas fa-check-circle text-2xl text-pink-600"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-pink-700">Confirmar pedido</h1>
                        {{-- Si deseas mostrar un subtítulo opcional: --}}
                        {{-- <p class="text-pink-600 mt-1">Verifica tus datos y finaliza la compra</p> --}}
                    </div>
                </div>
            </div>

            <section class="bg-white rounded-2xl shadow-lg border border-pink-100 p-6">
                <h2 class="text-2xl font-semibold text-pink-700 mb-6">Datos del cliente</h2>
                <form action="{{ route('cliente.checkout.placeorder') }}" method="POST" class="space-y-8"
                    id="form-checkout" novalidate>
                    @csrf

                    <!-- Dirección de despacho -->
                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección de
                            despacho</label>
                        <input type="text" name="direccion" id="direccion" required
                            value="{{ old('direccion', Auth::user()->direccion) }}" aria-describedby="direccion-error"
                            placeholder="Ingresa tu dirección de despacho"
                            class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none transition-colors duration-200">
                        @error('direccion')
                            <p id="direccion-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Método de pago -->
                    <div>
                        <label for="metodo_pago" class="block text-sm font-medium text-gray-700 mb-1">Método de pago</label>
                        <div class="relative">
                            <select name="metodo_pago" id="metodo_pago" required aria-describedby="metodo_pago-error"
                                class="w-full appearance-none px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none transition-colors duration-200 bg-white">
                                <option value="">-- Selecciona un método de pago --</option>
                                @foreach ($paymentTypes as $paymentType)
                                    <option value="{{ $paymentType->id }}"
                                        {{ old('metodo_pago') == $paymentType->id ? 'selected' : '' }}>
                                        {{ $paymentType->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('metodo_pago')
                            <p id="metodo_pago-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info genérica método de pago -->
                    <div id="info_pago"
                        class="text-sm text-gray-600 bg-pink-50 p-4 border border-dashed border-pink-200 rounded-lg hidden mt-2">
                        @foreach ($paymentTypes as $paymentType)
                            <div id="payment_type_{{ $paymentType->id }}" class="hidden whitespace-pre-line">
                                {!! nl2br(e($paymentType->descripcion)) !!}
                            </div>
                        @endforeach
                    </div>

                    <!-- Campos extra según método -->
                    <div id="campos_extra_pago" class="space-y-6 hidden mt-4">
                        <!-- Tarjeta Crédito / Débito -->
                        <div id="tarjeta_fields" class="hidden space-y-4">
                            <fieldset class="space-y-4 border border-pink-200 rounded-lg p-4">
                                <legend class="text-lg font-medium text-pink-700">Datos de la Tarjeta</legend>
                                <div>
                                    <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Número de
                                        tarjeta</label>
                                    <input type="text" name="card_number" id="card_number" maxlength="19"
                                        value="{{ old('card_number') }}" aria-describedby="card_number-error"
                                        placeholder="1234 5678 9012 3456"
                                        class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none transition-colors duration-200">
                                    @error('card_number')
                                        <p id="card_number-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="expiry_month" class="block text-sm font-medium text-gray-700 mb-1">Mes
                                            expiración (MM)</label>
                                        <input type="text" name="expiry_month" id="expiry_month" maxlength="2"
                                            value="{{ old('expiry_month') }}" aria-describedby="expiry_month-error"
                                            placeholder="MM"
                                            class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none transition-colors duration-200">
                                        @error('expiry_month')
                                            <p id="expiry_month-error" class="text-red-600 text-sm mt-1">{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="expiry_year" class="block text-sm font-medium text-gray-700 mb-1">Año
                                            expiración (AA)</label>
                                        <input type="text" name="expiry_year" id="expiry_year" maxlength="2"
                                            value="{{ old('expiry_year') }}" aria-describedby="expiry_year-error"
                                            placeholder="AA"
                                            class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none transition-colors duration-200">
                                        @error('expiry_year')
                                            <p id="expiry_year-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                    <input type="text" name="cvv" id="cvv" maxlength="4"
                                        value="{{ old('cvv') }}" aria-describedby="cvv-error" placeholder="123"
                                        class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none transition-colors duration-200">
                                    @error('cvv')
                                        <p id="cvv-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </fieldset>
                        </div>

                        <!-- PayPal -->
                        <div id="paypal_fields" class="hidden space-y-4">
                            <fieldset class="space-y-4 border border-pink-200 rounded-lg p-4">
                                <legend class="text-lg font-medium text-pink-700">Datos de PayPal</legend>
                                <div>
                                    <label for="paypal_email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                        de PayPal</label>
                                    <input type="email" name="paypal_email" id="paypal_email"
                                        value="{{ old('paypal_email', Auth::user()->email) }}"
                                        aria-describedby="paypal_email-error" placeholder="tu-correo@ejemplo.com"
                                        class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none transition-colors duration-200">
                                    @error('paypal_email')
                                        <p id="paypal_email-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </fieldset>
                        </div>

                        <!-- Referencia manual -->
                        <div id="referencia_fields" class="hidden space-y-4">
                            <fieldset class="space-y-4 border border-pink-200 rounded-lg p-4">
                                <legend class="text-lg font-medium text-pink-700">Referencia de pago</legend>
                                <div>
                                    <label for="referencia"
                                        class="block text-sm font-medium text-gray-700 mb-1">Referencia (p.ej. número de
                                        transacción)</label>
                                    <input type="text" name="referencia" id="referencia"
                                        value="{{ old('referencia') }}" aria-describedby="referencia-error"
                                        placeholder="Ej: REF123456"
                                        class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none transition-colors duration-200">
                                    @error('referencia')
                                        <p id="referencia-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </fieldset>
                        </div>

                </form>
            </section>

            <!-- Resumen del pedido -->
            <section class="bg-white rounded-2xl shadow-lg border border-pink-100 p-6 mt-8">
                <h2 class="text-2xl font-semibold text-pink-700 mb-6 flex items-center">
                    <i class="fas fa-calculator mr-2"></i>
                    Resumen del pedido
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm table-auto border rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-pink-50 to-rose-50 text-pink-700">
                            <tr>
                                <th class="px-4 py-3 text-left">Producto</th>
                                <th class="px-4 py-3 text-center">Talla</th>
                                <th class="px-4 py-3 text-center">Cantidad</th>
                                <th class="px-4 py-3 text-center">Precio unitario</th>
                                <th class="px-4 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 bg-white divide-y divide-pink-50">
                            @forelse ($cart->items as $item)
                                <tr class="hover:bg-pink-25 transition-colors duration-200">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-4">
                                            <div class="relative group">
                                                @if ($item->product && $item->product->imagen)
                                                    <img src="{{ asset('storage/' . $item->product->imagen) }}"
                                                        alt="{{ $item->product->nombre }}"
                                                        class="w-20 h-20 object-cover rounded-xl shadow-md group-hover:shadow-lg transition-shadow duration-200">
                                                    <div
                                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-xl transition-all duration-200">
                                                    </div>
                                                @else
                                                    <div
                                                        class="w-20 h-20 bg-gradient-to-br from-pink-100 to-pink-200 rounded-xl flex items-center justify-center shadow-md">
                                                        <i class="fas fa-image text-pink-400 text-xl"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <h3 class="text-gray-800 font-semibold text-base leading-tight">
                                                    {{ $item->product->nombre ?? 'Producto eliminado' }}
                                                </h3>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-700">
                                            {{ $item->size?->etiqueta ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="inline-flex items-center px-4 py-2 bg-pink-50 rounded-lg">
                                            <i class="fas fa-cubes text-pink-500 mr-2"></i>
                                            <span class="font-semibold text-gray-700">{{ $item->cantidad }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="space-y-1">
                                            <div class="text-sm text-gray-500">
                                                ${{ number_format($item->precio_unitario, 2) }} c/u
                                            </div>
                                            <div class="text-lg font-bold text-pink-600">
                                                ${{ number_format($item->cantidad * $item->precio_unitario, 2) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold">
                                        ${{ number_format($item->cantidad * $item->precio_unitario, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500">Tu carrito está vacío.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-right mt-4">
                    <p class="text-xl font-bold text-pink-700">Total a pagar: ${{ number_format($total, 2) }}</p>
                </div>
                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('cliente.store') }}"
                        class="text-sm text-gray-600 hover:text-pink-700 transition-colors duration-200">
                        ← Seguir comprando
                    </a>
                    <button type="submit" form="form-checkout"
                        class="bg-gradient-to-r from-pink-500 to-pink-600 text-white font-semibold px-6 py-3 rounded-xl hover:from-pink-600 hover:to-pink-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Realizar pedido
                    </button>
                </div>
            </section>

            <script>
                const metodoPago = document.getElementById('metodo_pago');
                const infoPago = document.getElementById('info_pago');
                const opciones = {};
                const camposExtra = document.getElementById('campos_extra_pago');
                const tarjetaFields = document.getElementById('tarjeta_fields');
                const paypalFields = document.getElementById('paypal_fields');
                const referenciaFields = document.getElementById('referencia_fields');

                @foreach ($paymentTypes as $paymentType)
                    opciones["{{ $paymentType->id }}"] = document.getElementById("payment_type_{{ $paymentType->id }}");
                @endforeach

                function mostrarInfoPago() {
                    const valor = metodoPago.value;
                    // Ocultar todo
                    infoPago.classList.add('hidden');
                    Object.values(opciones).forEach(div => div.classList.add('hidden'));
                    tarjetaFields.classList.add('hidden');
                    paypalFields.classList.add('hidden');
                    referenciaFields.classList.add('hidden');

                    if (!valor) {
                        camposExtra.classList.add('hidden');
                        return;
                    }

                    // Mostrar descripción genérica
                    if (opciones[valor]) {
                        infoPago.classList.remove('hidden');
                        opciones[valor].classList.remove('hidden');
                    }

                    // Mostrar campos extra según texto
                    const selectedOption = metodoPago.options[metodoPago.selectedIndex].text.toLowerCase();
                    camposExtra.classList.remove('hidden');

                    if (selectedOption.includes('tarjeta')) {
                        tarjetaFields.classList.remove('hidden');
                    } else if (selectedOption.includes('paypal')) {
                        paypalFields.classList.remove('hidden');
                    } else if (selectedOption.includes('transferencia')) {
                        referenciaFields.classList.remove('hidden');
                    } else {
                        // Otros métodos: sin datos extra
                    }
                }

                metodoPago.addEventListener('change', mostrarInfoPago);
                document.addEventListener('DOMContentLoaded', mostrarInfoPago);
            </script>

        </div>
    </div>
    </div>
@endsection
