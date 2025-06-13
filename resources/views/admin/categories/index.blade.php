@extends('layouts.admin')

@section('title', 'Categorías')

@section('content')
    <div class="max-w-5xl mx-auto p-6 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10" x-data="{ confirmId: null }">
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('admin.products.categories.create') }}"
                class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-5 py-3 rounded-xl shadow-md hover:shadow-lg transition duration-300 font-semibold flex items-center gap-2">
                <i class="fas fa-plus"></i> Agregar Categoría
            </a>
        </div>

        <table class="w-full table-auto border border-pink-200 rounded-xl overflow-hidden">
            <thead class="bg-pink-50 text-pink-700 font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categorias as $categoria)
                    <tr class="border-t border-pink-200 hover:bg-pink-50 transition duration-150">
                        <td class="px-6 py-4">{{ $categoria->id }}</td>
                        <td class="px-6 py-4 font-medium text-pink-600">{{ $categoria->nombre }}</td>
                        <td class="px-6 py-4 text-center space-x-4">

                            {{-- Botón Editar --}}
                            <a href="{{ route('admin.products.categories.edit', $categoria->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar
                            </a>

                            {{-- Botón Eliminar --}}
                            <button type="button" @click="confirmId = {{ $categoria->id }}"
                                class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50"
                                aria-label="Eliminar categoría {{ $categoria->nombre }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Eliminar
                            </button>

                            {{-- Formulario oculto para submit --}}
                            <form id="delete-{{ $categoria->id }}"
                                action="{{ route('admin.products.categories.destroy', $categoria->id) }}" method="POST"
                                class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>

                            {{-- Modal Confirmar Eliminación --}}
                            <x-confirm-delete-modal :id="$categoria->id" title="¿Eliminar categoría?"
                                message="¿Estás seguro que deseas eliminar la categoría <strong>{{ $categoria->nombre }}</strong>? <br> Esta acción no se puede deshacer."
                                confirmIdVar="confirmId" confirmText="Sí, eliminar categoría"
                                formSelector="#delete-{{ $categoria->id }}" titleColor="text-red-600" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-8 text-pink-400 font-medium">
                            No hay categorías registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
                {{-- Paginación (fuera del bucle) --}}
        @if ($categorias->hasPages())
            <div class="mt-6 px-4 py-3 flex items-center justify-between border-t border-gray-200 bg-white rounded-b-lg">
                <div class="text-sm text-gray-700">
                    Mostrando {{ $categorias->firstItem() }} - {{ $categorias->lastItem() }} de {{ $categorias->total() }} Categorias
                </div>
                <div class="flex space-x-2">
                    {{-- Anterior --}}
                    @if ($categorias->onFirstPage())
                        <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Anterior</span>
                    @else
                        <a href="{{ $categorias->previousPageUrl() }}" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Anterior</a>
                    @endif

                    {{-- Siguiente --}}
                    @if ($categorias->hasMorePages())
                        <a href="{{ $categorias->nextPageUrl() }}" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Siguiente</a>
                    @else
                        <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Siguiente</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
