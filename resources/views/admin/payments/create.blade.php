@extends('layouts.admin')

@section('title', $payment->id ? 'Editar Método de Pago' : 'Agregar Método de Pago')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-rose-50 py-10">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-3xl shadow-2xl border border-pink-100">
            <h1 class="text-2xl font-bold text-pink-600 mb-6 text-center flex items-center justify-center gap-2">
                <i class="fas fa-credit-card text-pink-400"></i>
                {{ $payment->id ? 'Editar Método de Pago' : 'Agregar Nuevo Método de Pago' }}
            </h1>

            <form 
                action="{{ $payment->id ? route('admin.payments.update', $payment->id) : route('admin.payments.store') }}" 
                method="POST" 
                class="space-y-6"
            >
                @csrf
                @if ($payment->id)
                    @method('PUT')
                @endif

                {{-- Campo: Nombre --}}
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-600 mb-1">
                        Nombre del método de pago
                    </label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="{{ old('nombre', $payment->nombre) }}"
                        class="w-full px-4 py-3 border-2 border-pink-100 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition duration-200 bg-pink-50/20"
                        placeholder="Ej: Tarjeta de crédito"
                        required
                    >
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo: Descripción --}}
                <div>
                    <label for="descripcion" class="block text-sm font-semibold text-gray-600 mb-1">
                        Descripción (opcional)
                    </label>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="4"
                        maxlength="1000"
                        class="w-full px-4 py-3 border-2 border-pink-100 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition duration-200 bg-pink-50/20"
                        placeholder="Descripción del método de pago"
                    >{{ old('descripcion', $payment->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo: Status --}}
                <div class="flex items-center space-x-3">
                    <label for="status" class="block text-sm font-semibold text-gray-600">
                        Activo:
                    </label>
                    <input 
                        type="checkbox" 
                        id="status" 
                        name="status" 
                        value="1" 
                        {{ old('status', $payment->status) ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-pink-300 text-pink-600 focus:ring-pink-500"
                    >
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Botones --}}
                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('admin.payments') }}" class="ml-4 text-pink-500 hover:underline flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Volver a Métodos de Pago
                    </a>
                    <button type="submit"
                        class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg font-semibold flex items-center gap-2">
                        <i class="fas fa-save"></i> {{ $payment->id ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
