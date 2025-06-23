@extends('layouts.cliente')

@section('title', 'Carrito de compras')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 to-rose-100">
    <div class="max-w-6xl mx-auto px-4 py-8" x-data="{ showModal: false, itemToDelete: null }">
        <!-- Header con icono y breadcrumb -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-pink-600 mb-3">
                <a href="{{ route('cliente.store') }}" class="hover:text-pink-700 transition-colors duration-200">
                    <i class="fas fa-store mr-1"></i> Tienda
                </a>
                <i class="fas fa-chevron-right mx-2 text-pink-400"></i>
                <span class="text-pink-800 font-medium">Carrito de compras</span>
            </div>
            
            <div class="flex items-center space-x-3">
                <div class="bg-pink-100 p-3 rounded-full">
                    <i class="fas fa-shopping-cart text-2xl text-pink-600"></i>
                </div>
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-pink-700">Tu carrito de compras</h1>
                    @if(!$cartItems->isEmpty())
                        <p class="text-pink-600 mt-1">{{ $cartItems->count() }} {{ $cartItems->count() == 1 ? 'producto' : 'productos' }} en tu carrito</p>
                    @endif
                </div>
            </div>
        </div>

        @if($cartItems->isEmpty())
            <!-- Estado vacío mejorado -->
            <div class="bg-white rounded-2xl shadow-lg border border-pink-100 p-12 text-center">
                <div class="mb-6">
                    <div class="w-24 h-24 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-cart text-4xl text-pink-300"></i>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-700 mb-2">Tu carrito está vacío</h2>
                    <p class="text-gray-500 max-w-md mx-auto">Parece que aún no has agregado ningún producto. ¡Explora nuestra tienda y encuentra algo que te encante!</p>
                </div>
                
                <a href="{{ route('cliente.store') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-xl font-semibold hover:from-pink-600 hover:to-pink-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                   <i class="fas fa-store mr-2"></i>
                   Explorar productos
                </a>
            </div>
        @else
            <!-- Contenido del carrito -->
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Lista de productos -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg border border-pink-100 overflow-hidden">
                        <!-- Header de la tabla -->
                        <div class="bg-gradient-to-r from-pink-50 to-rose-50 px-6 py-4 border-b border-pink-100">
                            <div class="grid grid-cols-12 gap-4 text-sm font-semibold text-pink-700 uppercase tracking-wide">
                                <div class="col-span-12 md:col-span-5">Producto</div>
                                <div class="col-span-3 md:col-span-1 text-center hidden md:block">Talla</div>
                                <div class="col-span-3 md:col-span-2 text-center">Cantidad</div>
                                <div class="col-span-3 md:col-span-2 text-right">Precio</div>
                                <div class="col-span-3 md:col-span-2 text-center">Acciones</div>
                            </div>
                        </div>

                        <!-- Items del carrito -->
                        <div class="divide-y divide-pink-50">
                            @foreach($cartItems as $item)
                                <div class="p-6 hover:bg-pink-25 transition-colors duration-200">
                                    <div class="grid grid-cols-12 gap-4 items-center">
                                        <!-- Producto -->
                                        <div class="col-span-12 md:col-span-5">
                                            <div class="flex items-center space-x-4">
                                                <div class="relative group">
                                                    @if($item->product && $item->product->imagen)
                                                        <img src="{{ asset('storage/' . $item->product->imagen) }}" 
                                                             alt="{{ $item->product->nombre }}" 
                                                             class="w-20 h-20 object-cover rounded-xl shadow-md group-hover:shadow-lg transition-shadow duration-200">
                                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-xl transition-all duration-200"></div>
                                                    @else
                                                        <div class="w-20 h-20 bg-gradient-to-br from-pink-100 to-pink-200 rounded-xl flex items-center justify-center shadow-md">
                                                            <i class="fas fa-image text-pink-400 text-xl"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h3 class="text-gray-800 font-semibold text-lg leading-tight">
                                                        {{ $item->product->nombre ?? 'Producto eliminado' }}
                                                    </h3>
                                                    <div class="flex items-center mt-2 md:hidden">
                                                        <span class="text-sm text-gray-500 mr-4">
                                                            <i class="fas fa-tag mr-1"></i>
                                                            Talla: {{ $item->size?->etiqueta ?? '—' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Talla (solo desktop) -->
                                        <div class="col-span-1 text-center hidden md:block">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-700">
                                                {{ $item->size?->etiqueta ?? '—' }}
                                            </span>
                                        </div>

                                        <!-- Cantidad (editable) -->
                                        <div class="col-span-4 md:col-span-2 text-center">
                                            <form action="{{ route('cliente.cart.update', $item->id) }}" method="POST" class="inline-flex items-center justify-center space-x-2">
                                                @csrf
                                                <input type="number" name="cantidad" value="{{ $item->cantidad }}" min="1"
                                                    class="w-16 text-center border border-pink-200 rounded-lg px-2 py-1 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent transition">
                                                <button type="submit"
                                                    class="text-pink-600 hover:text-white hover:bg-pink-600 border border-pink-200 hover:border-pink-600 rounded-lg px-3 py-1 font-medium text-sm transition-all duration-200">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </form>
                                        </div>


                                        <!-- Precio -->
                                        <div class="col-span-4 md:col-span-2 text-right">
                                            <div class="space-y-1">
                                                <div class="text-sm text-gray-500">
                                                    ${{ number_format($item->precio_unitario, 2) }} c/u
                                                </div>
                                                <div class="text-lg font-bold text-pink-600">
                                                    ${{ number_format($item->cantidad * $item->precio_unitario, 2) }}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Acciones -->
                                        <div class="col-span-4 md:col-span-2 text-center">
                                            <button 
                                                @click="itemToDelete = {{ $item->id }}; showModal = true" 
                                                class="inline-flex items-center px-4 py-2 text-pink-600 hover:text-white hover:bg-pink-600 border border-pink-200 hover:border-pink-600 rounded-lg font-medium transition-all duration-200 transform hover:scale-105"
                                            >
                                                <i class="fas fa-trash-alt mr-2"></i>
                                                <span class="hidden sm:inline">Eliminar</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Resumen del pedido -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg border border-pink-100 p-6 sticky top-8">
                        <h2 class="text-xl font-bold text-pink-700 mb-6 flex items-center">
                            <i class="fas fa-calculator mr-2"></i>
                            Resumen del pedido
                        </h2>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center py-2 border-b border-pink-100">
                                <span class="text-gray-600">Productos ({{ $cartItems->count() }})</span>
                                <span class="font-semibold text-gray-800">${{ number_format($total, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 border-b border-pink-100">
                                <span class="text-gray-600">Envío</span>
                                <span class="text-green-600 font-medium">Gratis</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-3 border-t-2 border-pink-200">
                                <span class="text-lg font-bold text-gray-800">Total</span>
                                <span class="text-2xl font-bold text-pink-600">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('cliente.checkout') }}" 
                           class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-xl font-semibold hover:from-pink-600 hover:to-pink-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-credit-card mr-2"></i>
                            Proceder al pago
                        </a>
                        
                        <div class="mt-4 p-4 bg-pink-50 rounded-lg">
                            <div class="flex items-center text-sm text-pink-700">
                                <i class="fas fa-shield-alt mr-2"></i>
                                <span>Compra 100% segura</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal Confirmación Eliminar -->
        <div
            x-show="showModal"
            class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="display: none;"
        >
            <div 
                class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
            >
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Confirmar eliminación</h2>
                    </div>
                    
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        ¿Estás seguro que deseas eliminar este producto del carrito?
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                        <button 
                            @click="showModal = false; itemToDelete = null" 
                            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-colors duration-200 order-2 sm:order-1"
                        >
                            Cancelar
                        </button>
                        
                        <form :action="`{{ route('cliente.cart.remove', '') }}/${itemToDelete}`" method="POST" class="order-1 sm:order-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-semibold hover:from-red-600 hover:to-red-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i class="fas fa-trash-alt mr-2"></i>
                                Eliminar producto
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection