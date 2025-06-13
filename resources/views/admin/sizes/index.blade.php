@extends('layouts.admin')

@section('title', 'Tallas')

@section('content')
    <div class="max-w-5xl mx-auto p-6 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10" x-data="{ confirmId: null }">
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('admin.products.sizes.create') }}"
                class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-5 py-3 rounded-xl shadow-md hover:shadow-lg transition duration-300 font-semibold flex items-center gap-2">
                <i class="fas fa-plus"></i> Agregar Talla
            </a>
        </div>

        <table class="w-full table-auto border border-pink-200 rounded-xl overflow-hidden">
            <thead class="bg-pink-50 text-pink-700 font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Talla</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sizes as $size)
                    <tr class="border-t border-pink-200 hover:bg-pink-50 transition duration-150">
                        <td class="px-6 py-4">{{ $size->id }}</td>
                        <td class="px-6 py-4 font-medium text-pink-600">{{ $size->etiqueta }}</td>
                        <td class="px-6 py-4 text-center space-x-4">
                            {{-- Botón Editar --}}
                            <a href="{{ route('admin.products.sizes.edit', $size->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50">
                                <i class="fas fa-edit mr-2"></i>Editar
                            </a>

                            {{-- Botón Eliminar --}}
                            <div x-data="{ confirmId: null }" class="inline">
                                <button type="button" @click="confirmId = {{ $size->id }}"
                                    class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                                    <i class="fas fa-trash-alt mr-2"></i>Eliminar
                                </button>

                                <form id="delete-{{ $size->id }}"
                                    action="{{ route('admin.products.sizes.destroy', $size->id) }}"
                                    method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <x-confirm-delete-modal
                                    :id="$size->id"
                                    title="Confirmar eliminación de Talla"
                                    message="¿Estás seguro que deseas eliminar la Talla <strong>{{ $size->etiqueta }}</strong>?<br>Esta acción no se puede deshacer."
                                    confirmIdVar="confirmId"
                                    confirmText="Sí, eliminar Talla"
                                    confirmColor="red"
                                    formSelector="#delete-{{ $size->id }}"
                                />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-8 text-pink-400 font-medium">
                            No hay tallas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginación --}}
        @if ($sizes->hasPages())
            <div class="mt-6 px-4 py-3 flex items-center justify-between border-t border-gray-200 bg-white rounded-b-lg">
                <div class="text-sm text-gray-700">
                    Mostrando {{ $sizes->firstItem() }} - {{ $sizes->lastItem() }} de {{ $sizes->total() }} Tallas
                </div>
                <div class="flex space-x-2">
                    {{-- Anterior --}}
                    @if ($sizes->onFirstPage())
                        <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Anterior</span>
                    @else
                        <a href="{{ $sizes->previousPageUrl() }}" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Anterior</a>
                    @endif

                    {{-- Siguiente --}}
                    @if ($sizes->hasMorePages())
                        <a href="{{ $sizes->nextPageUrl() }}" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Siguiente</a>
                    @else
                        <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Siguiente</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
