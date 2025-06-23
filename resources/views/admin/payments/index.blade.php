@extends('layouts.admin')

@section('title', 'Métodos de Pago')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-pink-50 py-8">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Contenedor principal con diseño moderno --}}
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-pink-100/50 overflow-hidden"
                x-data="{ confirmId: null, showFilters: false }">

                {{-- Header de la tabla con filtros visuales --}}
                <div class="bg-gradient-to-r from-pink-500/5 to-pink-600/5 border-b border-pink-100 p-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        {{-- Título y botón de filtros --}}
                        <div class="flex items-center gap-4">
                            
                            {{-- Botón para mostrar/ocultar filtros --}}
                            <button @click="showFilters = !showFilters" 
                                class="group flex items-center gap-2 px-4 py-2.5 bg-white border-2 border-pink-200 text-pink-600 rounded-xl hover:bg-pink-50 hover:border-pink-300 transition-all duration-200 font-medium shadow-sm">
                                <i class="fas fa-filter group-hover:rotate-12 transition-transform duration-200" 
                                   :class="showFilters ? 'text-pink-700' : 'text-pink-600'"></i>
                                <span x-text="showFilters ? 'Ocultar Filtros' : 'Mostrar Filtros'"></span>
                                <i class="fas fa-chevron-down transition-transform duration-200" 
                                   :class="showFilters ? 'rotate-180' : ''"></i>
                            </button>
                        </div>

                        <div class="flex items-center gap-3">
                            {{-- Estadística rápida --}}
                            <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-pink-100">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-pink-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm text-gray-600">Medios de Pagos Registrados:
                                        <span
                                            class="font-semibold text-pink-600">{{ $payments->total() ?? count($payments) }}</span>
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('admin.payments.create') }}"
                                class="group bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 font-semibold flex items-center gap-2 transform hover:scale-105">
                                <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                                <span>Nuevo Método</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Sección de Filtros --}}
                <div x-show="showFilters" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-4"
                     class="bg-gradient-to-r from-pink-25 to-transparent border-b border-pink-100 p-6">
                    
                    <form method="GET" action="{{ route('admin.payments') }}" class="space-y-4">
                        {{-- Primera fila de filtros --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- Filtro por nombre --}}
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-semibold text-pink-700">
                                    <i class="fas fa-search text-xs"></i>
                                    <span>Buscar por nombre</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}"
                                           placeholder="Buscar método de pago..."
                                           class="w-full pl-10 pr-4 py-3 border-2 border-pink-100 rounded-xl focus:border-pink-300 focus:ring-4 focus:ring-pink-100 transition-all duration-200 bg-white/70 backdrop-blur-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-pink-400"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Filtro por estado --}}
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-semibold text-pink-700">
                                    <i class="fas fa-toggle-on text-xs"></i>
                                    <span>Estado</span>
                                </label>
                                <select name="status" 
                                        class="w-full px-4 py-3 border-2 border-pink-100 rounded-xl focus:border-pink-300 focus:ring-4 focus:ring-pink-100 transition-all duration-200 bg-white/70 backdrop-blur-sm">
                                    <option value="">Todos los estados</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>

                            {{-- Filtro por descripción --}}
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-semibold text-pink-700">
                                    <i class="fas fa-align-left text-xs"></i>
                                    <span>Con descripción</span>
                                </label>
                                <select name="has_description" 
                                        class="w-full px-4 py-3 border-2 border-pink-100 rounded-xl focus:border-pink-300 focus:ring-4 focus:ring-pink-100 transition-all duration-200 bg-white/70 backdrop-blur-sm">
                                    <option value="">Todos</option>
                                    <option value="1" {{ request('has_description') == '1' ? 'selected' : '' }}>Con descripción</option>
                                    <option value="0" {{ request('has_description') == '0' ? 'selected' : '' }}>Sin descripción</option>
                                </select>
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            {{-- Botón aplicar filtros --}}
                            <button type="submit" 
                                    class="group bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 font-semibold flex items-center gap-2 transform hover:scale-105">
                                <i class="fas fa-filter group-hover:rotate-12 transition-transform duration-200"></i>
                                <span>Aplicar Filtros</span>
                            </button>

                            {{-- Botón limpiar filtros --}}
                            <a href="{{ route('admin.payments') }}" 
                               class="group bg-white hover:bg-gray-50 text-gray-700 px-6 py-2.5 rounded-xl shadow-md hover:shadow-lg border-2 border-gray-200 hover:border-gray-300 transition-all duration-200 font-semibold flex items-center gap-2">
                                <i class="fas fa-times group-hover:rotate-90 transition-transform duration-200"></i>
                                <span>Limpiar</span>
                            </a>

                            {{-- Indicadores de filtros activos --}}
                            @if(request()->hasAny(['search', 'status', 'has_description']))
                                <div class="flex items-center gap-2 ml-4">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm text-green-600 font-medium">Filtros activos</span>
                                </div>
                            @endif
                        </div>

                        {{-- Mostrar filtros aplicados --}}
                        @if(request()->hasAny(['search', 'status', 'has_description']))
                            <div class="flex flex-wrap items-center gap-2 pt-3 border-t border-pink-100">
                                <span class="text-sm text-gray-600 font-medium">Filtros aplicados:</span>
                                
                                @if(request('search'))
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-xs font-medium">
                                        <i class="fas fa-search"></i>
                                        Búsqueda: "{{ request('search') }}"
                                    </span>
                                @endif

                                @if(request('status') !== null && request('status') !== '')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-xs font-medium">
                                        <i class="fas fa-toggle-on"></i>
                                        Estado: {{ request('status') == '1' ? 'Activo' : 'Inactivo' }}
                                    </span>
                                @endif

                                @if(request('has_description') !== null && request('has_description') !== '')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-xs font-medium">
                                        <i class="fas fa-align-left"></i>
                                        {{ request('has_description') == '1' ? 'Con descripción' : 'Sin descripción' }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </form>
                </div>

                {{-- Tabla mejorada --}}
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-pink-50 to-pink-100/50 border-b-2 border-pink-200">
                                <th class="px-6 py-4 text-left">
                                    <div
                                        class="flex items-center gap-2 text-pink-700 font-semibold text-sm uppercase tracking-wider">
                                        <i class="fas fa-hashtag text-xs"></i>
                                        <span>ID</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <div
                                        class="flex items-center gap-2 text-pink-700 font-semibold text-sm uppercase tracking-wider">
                                        <i class="fas fa-tag text-xs"></i>
                                        <span>Nombre</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left">
                                    <div
                                        class="flex items-center gap-2 text-pink-700 font-semibold text-sm uppercase tracking-wider">
                                        <i class="fas fa-align-left text-xs"></i>
                                        <span>Descripción</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-center">
                                    <div
                                        class="flex items-center justify-center gap-2 text-pink-700 font-semibold text-sm uppercase tracking-wider">
                                        <i class="fas fa-toggle-on text-xs"></i>
                                        <span>Estado</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-center">
                                    <div
                                        class="flex items-center justify-center gap-2 text-pink-700 font-semibold text-sm uppercase tracking-wider">
                                        <i class="fas fa-cogs text-xs"></i>
                                        <span>Acciones</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-pink-50">
                            @forelse($payments as $payment)
                                <tr
                                    class="group hover:bg-gradient-to-r hover:from-pink-25 hover:to-transparent transition-all duration-200 hover:shadow-sm">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center group-hover:bg-pink-200 transition-colors">
                                                <span class="text-xs font-bold text-pink-600">{{ $payment->id }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div>
                                                <div
                                                    class="font-semibold text-gray-800 group-hover:text-pink-600 transition-colors">
                                                    {{ $payment->nombre }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="max-w-xs">
                                            @if ($payment->descripcion)
                                                <p class="text-gray-600 text-sm leading-relaxed line-clamp-2">
                                                    {{ $payment->descripcion }}
                                                </p>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-400">
                                                    <i class="fas fa-minus mr-1"></i>
                                                    Sin descripción
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if ($payment->status)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                <i class="fas fa-check-circle mr-1"></i> Activo
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                <i class="fas fa-times-circle mr-1"></i> Inactivo
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="flex justify-center items-center gap-2">

                                            {{-- Botón Editar mejorado --}}
                                            <a href="{{ route('admin.payments.edit', $payment->id) }}"
                                                class="group/edit relative inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-lg hover:from-pink-600 hover:to-pink-700 transition-all duration-200 font-medium shadow-sm hover:shadow-md transform hover:scale-105">
                                                <i
                                                    class="fas fa-edit mr-2 group-hover/edit:rotate-12 transition-transform duration-200"></i>
                                                <span>Editar</span>
                                                <div
                                                    class="absolute inset-0 rounded-lg bg-white/20 opacity-0 group-hover/edit:opacity-100 transition-opacity duration-200">
                                                </div>
                                            </a>

                                            {{-- Botón Eliminar mejorado --}}
                                            <button type="button" @click="confirmId = {{ $payment->id }}"
                                                class="group/delete relative inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 font-medium shadow-sm hover:shadow-md transform hover:scale-105">
                                                <i
                                                    class="fas fa-trash-alt mr-2 group-hover/delete:rotate-12 transition-transform duration-200"></i>
                                                <span>Eliminar</span>
                                                <div
                                                    class="absolute inset-0 rounded-lg bg-white/20 opacity-0 group-hover/delete:opacity-100 transition-opacity duration-200">
                                                </div>
                                            </button>

                                            {{-- Formulario oculto --}}
                                            <form id="delete-{{ $payment->id }}"
                                                action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST"
                                                class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            {{-- Modal de confirmación --}}
                                            <x-confirm-delete-modal :id="$payment->id" title="¿Eliminar método de pago?"
                                                message="¿Estás seguro de que deseas eliminar <strong>{{ $payment->nombre }}</strong>? Esta acción no se puede deshacer."
                                                confirmIdVar="confirmId" confirmText="Sí, eliminar"
                                                formSelector="#delete-{{ $payment->id }}" titleColor="text-red-600" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-16">
                                        <div class="flex flex-col items-center gap-4">
                                            <div
                                                class="w-20 h-20 bg-pink-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-credit-card text-3xl text-pink-400"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-600 mb-1">
                                                    @if(request()->hasAny(['search', 'status', 'has_description']))
                                                        No hay métodos de pago que coincidan
                                                    @else
                                                        No hay métodos de pago
                                                    @endif
                                                </h3>
                                                <p class="text-pink-400 text-sm">
                                                    @if(request()->hasAny(['search', 'status', 'has_description']))
                                                        Intenta ajustar los filtros de búsqueda
                                                    @else
                                                        Comienza agregando tu primer método de pago
                                                    @endif
                                                </p>
                                            </div>
                                            @if(request()->hasAny(['search', 'status', 'has_description']))
                                                <a href="{{ route('admin.payments') }}"
                                                    class="mt-2 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-2.5 rounded-xl shadow-md hover:shadow-lg transition duration-300 font-semibold flex items-center gap-2">
                                                    <i class="fas fa-times"></i> Limpiar Filtros
                                                </a>
                                            @else
                                                <a href="{{ route('admin.payments.create') }}"
                                                    class="mt-2 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-2.5 rounded-xl shadow-md hover:shadow-lg transition duration-300 font-semibold flex items-center gap-2">
                                                    <i class="fas fa-plus"></i> Agregar Método
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginación mejorada --}}
                @if ($payments->hasPages())
                    <div class="bg-gradient-to-r from-gray-50 to-pink-50/30 border-t border-pink-100 px-6 py-4">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-info-circle text-pink-600 text-sm"></i>
                                </div>
                                <span class="text-sm text-gray-600">
                                    Mostrando <span class="font-semibold text-pink-600">{{ $payments->firstItem() }}</span>
                                    – <span class="font-semibold text-pink-600">{{ $payments->lastItem() }}</span> de <span
                                        class="font-semibold text-pink-600">{{ $payments->total() }}</span> resultados
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                @if ($payments->onFirstPage())
                                    <span
                                        class="inline-flex items-center px-4 py-2 border border-gray-200 text-gray-400 rounded-lg cursor-not-allowed bg-gray-50">
                                        <i class="fas fa-chevron-left mr-2 text-xs"></i>
                                        Anterior
                                    </span>
                                @else
                                    <a href="{{ $payments->appends(request()->query())->previousPageUrl() }}"
                                        class="inline-flex items-center px-4 py-2 border border-pink-200 text-pink-600 rounded-lg hover:bg-pink-50 hover:border-pink-300 transition-all duration-200 font-medium">
                                        <i class="fas fa-chevron-left mr-2 text-xs"></i>
                                        Anterior
                                    </a>
                                @endif

                                @if ($payments->hasMorePages())
                                    <a href="{{ $payments->appends(request()->query())->nextPageUrl() }}"
                                        class="inline-flex items-center px-4 py-2 border border-pink-200 text-pink-600 rounded-lg hover:bg-pink-50 hover:border-pink-300 transition-all duration-200 font-medium">
                                        Siguiente
                                        <i class="fas fa-chevron-right ml-2 text-xs"></i>
                                    </a>
                                @else
                                    <span
                                        class="inline-flex items-center px-4 py-2 border border-gray-200 text-gray-400 rounded-lg cursor-not-allowed bg-gray-50">
                                        Siguiente
                                        <i class="fas fa-chevron-right ml-2 text-xs"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Estilos adicionales para efectos visuales --}}
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        tbody tr {
            animation: fadeIn 0.3s ease-out;
        }

        tbody tr:nth-child(even) {
            animation-delay: 0.1s;
        }

        tbody tr:nth-child(odd) {
            animation-delay: 0.05s;
        }

        /* Estilos adicionales para los filtros */
        .from-pink-25 {
            --tw-gradient-from: rgb(253 242 248);
            --tw-gradient-to: rgb(253 242 248 / 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
        }
    </style>
@endsection