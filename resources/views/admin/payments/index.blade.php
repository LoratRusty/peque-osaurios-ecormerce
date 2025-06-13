@extends('layouts.admin')

@section('title', 'Métodos de Pago')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10" x-data="{ confirmId: null }">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-pink-700">Listado de Métodos de Pago</h2>
        <a href="{{ route('admin.payments.create') }}"
           class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-5 py-3 rounded-xl shadow-md hover:shadow-lg transition duration-300 font-semibold flex items-center gap-2">
            <i class="fas fa-plus"></i> Agregar
        </a>
    </div>

    <div class="overflow-x-auto rounded-xl border border-pink-100">
        <table class="w-full text-sm text-left">
            <thead class="bg-pink-50 text-pink-700 font-semibold">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Descripción</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr class="border-t border-pink-100 hover:bg-pink-50 transition duration-150">
                        <td class="px-6 py-4">{{ $payment->id }}</td>
                        <td class="px-6 py-4 font-medium text-pink-600">{{ $payment->nombre }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $payment->descripcion ?? '—' }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center gap-2">

                                {{-- Botón Editar --}}
                                <a href="{{ route('admin.payments.edit', $payment->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition font-medium">
                                    <i class="fas fa-edit mr-1"></i> Editar
                                </a>

                                {{-- Botón Eliminar --}}
                                <button type="button" @click="confirmId = {{ $payment->id }}"
                                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-medium">
                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                </button>

                                {{-- Formulario oculto --}}
                                <form id="delete-{{ $payment->id }}"
                                      action="{{ route('admin.payments.destroy', $payment->id) }}"
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                {{-- Modal de confirmación --}}
                                <x-confirm-delete-modal
                                    :id="$payment->id"
                                    title="¿Eliminar método de pago?"
                                    message="¿Estás seguro de que deseas eliminar <strong>{{ $payment->nombre }}</strong>? Esta acción no se puede deshacer."
                                    confirmIdVar="confirmId"
                                    confirmText="Sí, eliminar"
                                    formSelector="#delete-{{ $payment->id }}"
                                    titleColor="text-red-600"
                                />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-10 text-pink-400 font-medium">
                            No hay métodos de pago registrados aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    @if ($payments->hasPages())
        <div class="mt-6 flex justify-between items-center text-sm text-gray-600">
            <span>
                Mostrando {{ $payments->firstItem() }} – {{ $payments->lastItem() }} de {{ $payments->total() }} resultados
            </span>
            <div class="space-x-2">
                @if ($payments->onFirstPage())
                    <span class="px-3 py-1 border border-gray-300 text-gray-400 rounded cursor-not-allowed">Anterior</span>
                @else
                    <a href="{{ $payments->previousPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Anterior</a>
                @endif

                @if ($payments->hasMorePages())
                    <a href="{{ $payments->nextPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Siguiente</a>
                @else
                    <span class="px-3 py-1 border border-gray-300 text-gray-400 rounded cursor-not-allowed">Siguiente</span>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
