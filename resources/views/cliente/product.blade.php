@extends('layouts.cliente')

@section('title', 'Detalles del Producto')

@section('content')
    <div class="max-w-6xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('cliente.store') }}" class="hover:text-pink-600 transition-colors">Tienda</a></li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('cliente.store', ['category' => $producto->categoria->id]) }}" class="hover:text-pink-600 transition-colors">{{ $producto->categoria->nombre }}</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-800 font-medium">{{ $producto->nombre }}</span>
                </li>
            </ol>
        </nav>

        <!-- Contenido principal -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="flex flex-col lg:flex-row lg:items-center">
                {{-- Sección de imagen --}}
                <div>
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                            class="remove-bg rounded-xl object-cover w-full h-auto max-h-[500px] shadow-md transition-transform duration-300">
                        
                        <!-- Badge de stock -->
                        <div class="absolute top-4 right-4">
                            @if (isset($producto->stockTotal) && $producto->stockTotal > 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 shadow-sm">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Disponible
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 shadow-sm">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Agotado
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sección de detalles --}}
                <div class="lg:w-1/2 p-8 flex flex-col justify-between">
                    <div class="space-y-6">
                        <!-- Título y descripción -->
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900 mb-2 leading-tight">{{ $producto->nombre }}</h1>
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="text-sm text-gray-500">Categoría:</span>
                                <a href="{{ route('cliente.store', ['category' => $producto->categoria->id]) }}"
                                    class="inline-flex items-center px-2 py-1 rounded-md text-sm font-medium bg-pink-100 text-pink-800 hover:bg-pink-200 transition-colors">
                                    {{ $producto->categoria->nombre }}
                                </a>
                            </div>
                            <p class="text-gray-600 leading-relaxed text-lg">{{ $producto->descripcion }}</p>
                        </div>

                        <!-- Precio -->
                        <div class="bg-gradient-to-r from-pink-50 to-pink-100 rounded-lg p-4 border border-pink-200">
                            <div class="flex items-center justify-between">
                                <span class="text-lg text-gray-600">Precio:</span>
                                <span class="text-3xl font-bold text-pink-600">${{ number_format($producto->precio, 2) }}</span>
                            </div>
                        </div>

                        <!-- Información de stock -->
                        <div class="bg-gray-50 rounded-lg p-4 border">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Stock disponible:</span>
                                @if (isset($producto->stockTotal) && $producto->stockTotal > 0)
                                    <span class="flex items-center text-green-600 font-semibold">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $producto->stockTotal }} unidades
                                    </span>
                                @else
                                    <span class="flex items-center text-red-600 font-semibold">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Agotado
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Formulario agregar al carrito --}}
                    <div class="mt-8 border-t pt-6">
                        @if (isset($producto->stockTotal) && $producto->stockTotal > 0)
                            <form action="{{ route('cliente.cart.add') }}" method="POST" class="space-y-6">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $producto->id }}">

                                {{-- Selector de talla --}}
                                @if ($producto->sizes->count())
                                    <div class="space-y-2">
                                        <label for="size_id" class="block text-sm font-semibold text-gray-700">
                                            <i class="fas fa-ruler mr-1 text-pink-600"></i>
                                            Selecciona tu talla:
                                        </label>
                                        <select name="size_id" id="size_id" required
                                                class="w-full border-2 border-pink-200 rounded-lg px-4 py-3 text-gray-700 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all duration-200">
                                            <option value="" disabled selected>Elige una talla</option>
                                            @foreach ($producto->sizes as $size)
                                                <option value="{{ $size->id }}" data-stock="{{ $size->pivot->stock }}"
                                                    @if($size->pivot->stock == 0) disabled @endif>
                                                    {{ $size->etiqueta }} 
                                                    @if($size->pivot->stock > 0)
                                                        ({{ $size->pivot->stock }} disponibles)
                                                    @else
                                                        (Agotado)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                {{-- Selector de cantidad y botón --}}
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <div class="flex-1">
                                        <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-hashtag mr-1 text-pink-600"></i>
                                            Cantidad:
                                        </label>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1"
                                            class="w-full border-2 border-pink-200 rounded-lg px-4 py-3 text-center text-gray-700 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 transition-all duration-200" required>
                                    </div>
                                    
                                    <div class="flex-1 flex items-end">
                                        <button type="submit"
                                            class="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center space-x-2"
                                            @if ($producto->stockTotal <= 0) disabled @endif>
                                            <i class="fas fa-cart-plus text-lg"></i>
                                            <span>Agregar al Carrito</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Información adicional -->
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex items-start space-x-3">
                                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div class="text-sm text-blue-800">
                                            <p class="font-medium">Información de compra</p>
                                            <p class="mt-1">Envío gratuito • Devolución en 30 días • Garantía incluida</p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="text-center">
                                <button disabled class="w-full px-6 py-4 bg-gray-400 text-white rounded-lg cursor-not-allowed font-semibold flex items-center justify-center space-x-2">
                                    <i class="fas fa-times-circle"></i>
                                    <span>Producto Agotado</span>
                                </button>
                                <p class="text-sm text-gray-500 mt-2">Te notificaremos cuando esté disponible nuevamente</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sizeSelect = document.getElementById('size_id');
            const quantityInput = document.getElementById('quantity');

            if (sizeSelect && quantityInput) {
                sizeSelect.addEventListener('change', function () {
                    const selected = sizeSelect.options[sizeSelect.selectedIndex];
                    const stock = parseInt(selected.getAttribute('data-stock')) || 1;
                    quantityInput.max = stock;
                    if (parseInt(quantityInput.value) > stock) {
                        quantityInput.value = stock;
                    }
                });

                // Opcional: establecer el max al cargar si ya hay talla seleccionada
                if (sizeSelect.value) {
                    const selected = sizeSelect.options[sizeSelect.selectedIndex];
                    const stock = parseInt(selected.getAttribute('data-stock')) || 1;
                    quantityInput.max = stock;
                }
            }
        });
    </script>
@endsection