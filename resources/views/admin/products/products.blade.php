@extends('layouts.admin')

@section('title', 'Inventario')

@section('content')

    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-rose-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Encabezado --}}
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-pink-100/50 p-6">
                <div class="flex flex-col items-center gap-6">
                    {{-- Botones de acción --}}
                    <div class="flex flex-wrap justify-center items-center gap-4">
                        {{-- Agregar Producto --}}
                        <a href="{{ route('admin.products.create') }}"
                            class="group bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-medium flex items-center space-x-2">
                            <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                            <span>Agregar Producto</span>
                        </a>

                        {{-- Ver Categorías --}}
                        <a href="{{ route('admin.products.categories.index') }}"
                            class="group bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-medium flex items-center space-x-2">
                            <i class="fas fa-tags group-hover:scale-110 transition-transform duration-300"></i>
                            <span>Categorías</span>
                        </a>

                        {{-- Ver Tallas --}}
                        <a href="{{ route('admin.products.sizes.index') }}"
                            class="group bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-medium flex items-center space-x-2">
                            <i class="fas fa-ruler group-hover:scale-110 transition-transform duration-300"></i>
                            <span>Tallas</span>
                        </a>
                    </div>
                </div>
            </div>


            {{-- Panel de filtros mejorado --}}
            <div class="bg-white/90 backdrop-blur-sm border border-pink-100/50 rounded-2xl shadow-xl overflow-hidden">
                {{-- Header de filtros con gradiente --}}
                <div class="bg-gradient-to-r from-pink-100 via-blue-50 to-green-50 px-6 py-5 border-b border-pink-100/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-600 rounded-lg flex items-center justify-center shadow-md">
                                <i class="fas fa-filter text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Filtros de Búsqueda</h3>
                            </div>
                        </div>
                        <button id="clearFilters"
                            class="group flex items-center space-x-2 px-4 py-2 text-sm text-gray-600 hover:text-pink-600 hover:bg-pink-50 rounded-lg transition-all duration-200">
                            <i class="fas fa-times group-hover:rotate-90 transition-transform duration-200"></i>
                            <span>Limpiar filtros</span>
                        </button>
                    </div>
                </div>

                {{-- Contenido de filtros --}}
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        {{-- Búsqueda general --}}
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <div class="w-5 h-5 bg-pink-100 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-search text-pink-500 text-xs"></i>
                                </div>
                                Buscar producto
                            </label>
                            <div class="relative">
                                <input type="text" placeholder="Nombre del producto..." id="searchInput"
                                    class="w-full px-4 py-3 pl-12 border-2 border-pink-100 rounded-xl text-sm focus:ring-4 focus:ring-pink-200 focus:border-pink-400 transition-all duration-300 bg-gradient-to-r from-pink-50/30 to-rose-50/30 hover:from-pink-50/50 hover:to-rose-50/50 placeholder-gray-400">
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-search text-pink-400"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Filtro por categoría --}}
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-tags text-blue-500 text-xs"></i>
                                </div>
                                Categoría
                            </label>
                            <div class="relative">
                                <select id="filterCategoria"
                                    class="w-full px-4 py-3 pl-12 border-2 border-blue-100 rounded-xl text-sm focus:ring-4 focus:ring-blue-200 focus:border-blue-400 transition-all duration-300 bg-gradient-to-r from-blue-50/30 to-cyan-50/30 hover:from-blue-50/50 hover:to-cyan-50/50 appearance-none cursor-pointer">
                                    <option value="">Todas las categorías</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-tag text-blue-400"></i>
                                </div>
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-blue-400 text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Filtro por talla --}}
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-ruler text-green-500 text-xs"></i>
                                </div>
                                Talla
                            </label>
                            <div class="relative">
                                <select id="filterTalla"
                                    class="w-full px-4 py-3 pl-12 border-2 border-green-100 rounded-xl text-sm focus:ring-4 focus:ring-green-200 focus:border-green-400 transition-all duration-300 bg-gradient-to-r from-green-50/30 to-emerald-50/30 hover:from-green-50/50 hover:to-emerald-50/50 appearance-none cursor-pointer">
                                    <option value="">Todas las tallas</option>
                                    @foreach ($tallas as $talla)
                                        <option value="{{ $talla->etiqueta }}">{{ $talla->etiqueta }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-ruler-combined text-green-400"></i>
                                </div>
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-green-400 text-xs"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Filtro por estado --}}
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <div class="w-5 h-5 bg-pink-100 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-toggle-on text-pink-500 text-xs"></i>
                                </div>
                                Estado
                            </label>
                            <div class="relative">
                                <select id="filterEstado"
                                    class="w-full px-4 py-3 pl-12 border-2 border-pink-100 rounded-xl text-sm focus:ring-4 focus:ring-pink-200 focus:border-pink-400 transition-all duration-300 bg-gradient-to-r from-pink-50/30 to-rose-50/30 hover:from-pink-50/50 hover:to-rose-50/50 appearance-none cursor-pointer">
                                    <option value="">Todos los estados</option>
                                    <option value="1">Activos</option>
                                    <option value="0">Inactivos</option>
                                </select>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                    <i class="fas fa-circle-dot text-pink-400"></i>
                                </div>
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-pink-400 text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Estadísticas rápidas mejoradas --}}
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div
                                class="group relative overflow-hidden bg-gradient-to-br from-pink-50 to-pink-100 hover:from-pink-100 hover:to-pink-200 rounded-2xl p-4 transition-all duration-300 hover:shadow-lg border border-pink-200/50">
                                <div
                                    class="absolute top-2 right-2 w-8 h-8 bg-pink-200/50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-box text-pink-600 text-sm"></i>
                                </div>
                                <div class="text-2xl font-bold text-pink-700" id="totalProducts">{{ $products->total() }}
                                </div>
                                <div class="text-sm text-pink-600 font-medium">Total productos</div>
                            </div>

                            <div
                                class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-2xl p-4 transition-all duration-300 hover:shadow-lg border border-blue-200/50">
                                <div
                                    class="absolute top-2 right-2 w-8 h-8 bg-blue-200/50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-eye text-blue-600 text-sm"></i>
                                </div>
                                <div class="text-2xl font-bold text-blue-700" id="visibleProducts">{{ $products->count() }}
                                </div>
                                <div class="text-sm text-blue-600 font-medium">Mostrando</div>
                            </div>

                            <div
                                class="group relative overflow-hidden bg-gradient-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-2xl p-4 transition-all duration-300 hover:shadow-lg border border-green-200/50">
                                <div
                                    class="absolute top-2 right-2 w-8 h-8 bg-green-200/50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check-circle text-green-600 text-sm"></i>
                                </div>
                                <div class="text-2xl font-bold text-green-700" id="activeProducts">
                                    {{ $products->where('status', 1)->count() }}</div>
                                <div class="text-sm text-green-600 font-medium">Activos</div>
                            </div>

                            <div
                                class="group relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 rounded-2xl p-4 transition-all duration-300 hover:shadow-lg border border-gray-200/50">
                                <div
                                    class="absolute top-2 right-2 w-8 h-8 bg-gray-200/50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-pause-circle text-gray-600 text-sm"></i>
                                </div>
                                <div class="text-2xl font-bold text-gray-700" id="inactiveProducts">
                                    {{ $products->where('status', 0)->count() }}</div>
                                <div class="text-sm text-gray-600 font-medium">Inactivos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla de productos mejorada --}}
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-pink-100/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gradient-to-r from-pink-100 via-rose-100 to-pink-100">
                            <tr>
                                <th class="px-4 py-4 text-left font-semibold text-pink-800">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-box text-pink-600"></i>
                                        <span>Producto</span>
                                    </div>
                                </th>
                                <th class="px-3 py-4 text-left font-semibold text-pink-800">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-tags text-pink-600"></i>
                                        <span>Categoría</span>
                                    </div>
                                </th>
                                <th class="px-3 py-4 text-left font-semibold text-pink-800">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-ruler text-pink-600"></i>
                                        <span>Tallas & Stock</span>
                                    </div>
                                </th>
                                <th class="px-3 py-4 text-right font-semibold text-pink-800">
                                    <div class="flex items-center justify-end space-x-2">
                                        <i class="fas fa-dollar-sign text-pink-600"></i>
                                        <span>Precio</span>
                                    </div>
                                </th>
                                <th class="px-3 py-4 text-center font-semibold text-pink-800">
                                    <div class="flex items-center justify-center space-x-2">
                                        <i class="fas fa-toggle-on text-pink-600"></i>
                                        <span>Estado</span>
                                    </div>
                                </th>
                                <th class="px-4 py-4 text-center font-semibold text-pink-800">
                                    <div class="flex items-center justify-center space-x-2">
                                        <i class="fas fa-cogs text-pink-600"></i>
                                        <span>Acciones</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="productsTable" class="divide-y divide-gray-100 bg-white">
                            @foreach ($products as $producto)
                                @php
                                    $tallasLabels = $producto->sizes
                                        ->pluck('etiqueta')
                                        ->map(fn($e) => strtolower($e))
                                        ->toArray();
                                    $dataTalla = implode(' ', $tallasLabels);
                                    $stockTotal = $producto->sizes->sum(fn($size) => $size->pivot->stock);
                                @endphp
                                <tr class="producto-row hover:bg-gradient-to-r hover:from-pink-50/50 hover:to-rose-50/50 transition-all duration-200 group"
                                    data-nombre="{{ strtolower($producto->nombre) }}"
                                    data-categoria="{{ $producto->categoria_id }}" data-talla="{{ $dataTalla }}"
                                    data-estado="{{ $producto->status }}">

                                    {{-- Nombre del Producto + Imagen --}}
                                    <td class="px-4 py-4">
                                        <div class="flex items-center space-x-3">
                                            @if ($producto->nombre && $producto->imagen)
                                                <img src="{{ asset('storage/' . $producto->imagen) }}"
                                                    alt="{{ $producto->nombre }}"
                                                    class="w-10 h-10 object-cover rounded-lg">
                                            @else
                                                <div
                                                    class="bg-gray-200 border-2 border-dashed rounded-xl w-10 h-10 flex items-center justify-center text-gray-500">
                                                    <i class="fas fa-box text-sm"></i>
                                                </div>
                                            @endif
                                            <div class="font-medium text-gray-900 leading-tight">
                                                {{ $producto->nombre }}
                                            </div>
                                        </div>
                                    </td>


                                    {{-- Categoría --}}
                                    <td class="px-3 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200 whitespace-nowrap">
                                            {{ $producto->categoria->nombre }}
                                        </span>
                                    </td>

                                    {{-- Tallas y Stock --}}
                                    <td class="px-3 py-4">
                                        @if ($producto->sizes->isEmpty())
                                            <div class="flex items-center justify-center">
                                                <span class="text-gray-400 text-xs italic flex items-center">
                                                    <i class="fas fa-minus mr-1"></i>
                                                    Sin tallas
                                                </span>
                                            </div>
                                        @else
                                            <div class="space-y-1">
                                                @php
                                                    $sizesCount = $producto->sizes->count();
                                                    $showLimit = 3; // Mostrar máximo 3 tallas inicialmente
                                                @endphp

                                                @foreach ($producto->sizes->take($showLimit) as $size)
                                                    <div
                                                        class="flex items-center justify-between bg-gradient-to-r from-green-50 to-emerald-50 rounded-md px-2 py-1 border border-green-100">
                                                        <span
                                                            class="font-medium text-green-700 text-xs">{{ $size->etiqueta }}</span>
                                                        <span
                                                            class="text-xs text-green-600 bg-green-100 px-1.5 py-0.5 rounded-full font-medium">
                                                            {{ $size->pivot->stock }}
                                                        </span>
                                                    </div>
                                                @endforeach

                                                @if ($sizesCount > $showLimit)
                                                    <div class="text-center">
                                                        <button type="button"
                                                            onclick="toggleSizes(this, {{ $producto->id }})"
                                                            class="text-xs text-blue-600 hover:text-blue-800 font-medium flex items-center mx-auto space-x-1 hover:bg-blue-50 px-2 py-1 rounded transition-colors">
                                                            <span class="show-more">+{{ $sizesCount - $showLimit }}
                                                                más</span>
                                                            <span class="show-less hidden">Mostrar menos</span>
                                                            <i class="fas fa-chevron-down show-more"></i>
                                                            <i class="fas fa-chevron-up show-less hidden"></i>
                                                        </button>
                                                    </div>

                                                    <div class="hidden-sizes-{{ $producto->id }} hidden space-y-1">
                                                        @foreach ($producto->sizes->skip($showLimit) as $size)
                                                            <div
                                                                class="flex items-center justify-between bg-gradient-to-r from-green-50 to-emerald-50 rounded-md px-2 py-1 border border-green-100">
                                                                <span
                                                                    class="font-medium text-green-700 text-xs">{{ $size->etiqueta }}</span>
                                                                <span
                                                                    class="text-xs text-green-600 bg-green-100 px-1.5 py-0.5 rounded-full font-medium">
                                                                    {{ $size->pivot->stock }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Precio --}}
                                    <td class="px-3 py-4 text-right">
                                        <span class="font-semibold text-gray-900 whitespace-nowrap">
                                            ${{ number_format($producto->precio, 2) }}
                                        </span>
                                    </td>

                                    {{-- Estado --}}
                                    <td class="px-3 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium whitespace-nowrap
                                {{ $producto->status ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200' }}">
                                            <i
                                                class="fas {{ $producto->status ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                            {{ $producto->status ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.products.edit', $producto->id) }}"
                                                class="group inline-flex items-center px-3 py-2 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 text-xs font-medium">
                                                <i
                                                    class="fas fa-edit mr-1 group-hover:scale-110 transition-transform duration-200"></i>
                                                <span class="hidden sm:inline">Editar</span>
                                            </a>

                                            <div x-data="{ confirmId: null }" class="inline">
                                                <button type="button" @click="confirmId = {{ $producto->id }}"
                                                    class="group inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 text-xs font-medium">
                                                    <i
                                                        class="fas fa-trash-alt mr-1 group-hover:scale-110 transition-transform duration-200"></i>
                                                    <span class="hidden sm:inline">Eliminar</span>
                                                </button>

                                                <form id="delete-{{ $producto->id }}"
                                                    action="{{ route('admin.products.destroy', $producto->id) }}"
                                                    method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <x-confirm-delete-modal :id="$producto->id"
                                                    title="Confirmar eliminación de Producto"
                                                    message="¿Estás seguro que deseas eliminar el Producto <strong>{{ $producto->nombre }}</strong>?<br>Esta acción no se puede deshacer."
                                                    confirmIdVar="confirmId" confirmText="Sí, eliminar producto"
                                                    confirmColor="red" formSelector="#delete-{{ $producto->id }}" />
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        {{-- Fila de no resultados --}}
                        <tbody id="noResults" style="display: none;">
                            <tr class="text-center text-gray-500 bg-gray-50">
                                <td colspan="7" class="px-4 py-12">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                            <i class="fas fa-search text-gray-400 text-2xl"></i>
                                        </div>
                                        <div class="text-gray-600 font-medium">No se encontraron productos</div>
                                        <div class="text-sm text-gray-500">Intenta ajustar los filtros de búsqueda</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Script para mostrar/ocultar tallas --}}
                <script>
                    function toggleSizes(button, productId) {
                        const hiddenSizes = document.querySelector(`.hidden-sizes-${productId}`);
                        const showMore = button.querySelectorAll('.show-more');
                        const showLess = button.querySelectorAll('.show-less');

                        if (hiddenSizes.classList.contains('hidden')) {
                            // Mostrar más tallas
                            hiddenSizes.classList.remove('hidden');
                            showMore.forEach(el => el.classList.add('hidden'));
                            showLess.forEach(el => el.classList.remove('hidden'));
                        } else {
                            // Ocultar tallas adicionales
                            hiddenSizes.classList.add('hidden');
                            showMore.forEach(el => el.classList.remove('hidden'));
                            showLess.forEach(el => el.classList.add('hidden'));
                        }
                    }
                </script>

                {{-- Paginación mejorada --}}
                @if ($products->hasPages())
                    <div class="bg-gradient-to-r from-gray-50 to-pink-50 px-6 py-4 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
                            {{-- Información de resultados --}}
                            <div class="flex items-center space-x-2 text-sm text-gray-700">
                                <i class="fas fa-info-circle text-pink-500"></i>
                                <span>
                                    Mostrando <span
                                        class="font-semibold text-pink-600">{{ $products->firstItem() }}</span> -
                                    <span class="font-semibold text-pink-600">{{ $products->lastItem() }}</span> de
                                    <span class="font-semibold text-pink-600">{{ $products->total() }}</span> productos
                                </span>
                            </div>

                            {{-- Paginación --}}
                            <div class="flex items-center space-x-1">
                                {{-- Botón Anterior --}}
                                @if ($products->onFirstPage())
                                    <span
                                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-400 cursor-not-allowed bg-gray-100 flex items-center space-x-1">
                                        <i class="fas fa-chevron-left text-xs"></i>
                                        <span>Anterior</span>
                                    </span>
                                @else
                                    <a href="{{ $products->previousPageUrl() }}"
                                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-pink-50 hover:border-pink-300 hover:text-pink-600 transition-all duration-200 flex items-center space-x-1">
                                        <i class="fas fa-chevron-left text-xs"></i>
                                        <span>Anterior</span>
                                    </a>
                                @endif

                                {{-- Páginas numéricas --}}
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <span
                                            class="px-4 py-2 rounded-lg bg-gradient-to-r from-pink-500 to-pink-600 text-white font-semibold shadow-md">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-pink-50 hover:border-pink-300 hover:text-pink-600 transition-all duration-200">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Botón Siguiente --}}
                                @if ($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}"
                                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-pink-50 hover:border-pink-300 hover:text-pink-600 transition-all duration-200 flex items-center space-x-1">
                                        <span>Siguiente</span>
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </a>
                                @else
                                    <span
                                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-400 cursor-not-allowed bg-gray-100 flex items-center space-x-1">
                                        <span>Siguiente</span>
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const filterCategoria = document.getElementById('filterCategoria');
        const filterTalla = document.getElementById('filterTalla');
        const filterEstado = document.getElementById('filterEstado');
        const clearFiltersBtn = document.getElementById('clearFilters');
        const activeFiltersContainer = document.getElementById('activeFilters');
        const visibleProductsCounter = document.getElementById('visibleProducts');

        function aplicarFiltros() {
            const search = searchInput.value.toLowerCase();
            const categoria = filterCategoria.value;
            const talla = filterTalla.value.toLowerCase(); // Talla seleccionada
            const estado = filterEstado.value;

            let visibleCount = 0;

            document.querySelectorAll('.producto-row').forEach(row => {
                const nombre = row.dataset.nombre;
                const cat = row.dataset.categoria;
                const tallas = row.dataset.talla.split(' '); // lista de tallas del producto
                const est = row.dataset.estado;

                const tallaCoincide = talla === "" || tallas.includes(talla);
                const coincide =
                    nombre.includes(search) &&
                    (categoria === "" || cat === categoria) &&
                    tallaCoincide &&
                    (estado === "" || est === estado);

                row.style.display = coincide ? '' : 'none';
                if (coincide) visibleCount++;
            });
            const noResults = document.getElementById('noResults');
            if (noResults) {
                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }

            visibleProductsCounter.textContent = visibleCount;
        }

        function limpiarFiltros() {
            searchInput.value = '';
            filterCategoria.value = '';
            filterTalla.value = '';
            filterEstado.value = '';
            aplicarFiltros();
        }

        // Event listeners
        [searchInput, filterCategoria, filterTalla, filterEstado].forEach(el => {
            el.addEventListener('input', aplicarFiltros);
            el.addEventListener('change', aplicarFiltros);
        });

        clearFiltersBtn.addEventListener('click', limpiarFiltros);

        // Agregar efectos de hover mejorados
        document.addEventListener('DOMContentLoaded', function() {
            // Efecto de hover en las estadísticas
            const statsCards = document.querySelectorAll('[id$="Products"]').forEach(card => {
                if (card.parentElement) {
                    card.parentElement.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-2px)';
                    });
                    card.parentElement.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0)';
                    });
                }
            });

            // Efecto de focus mejorado en inputs
            const inputs = document.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>

@endsection
