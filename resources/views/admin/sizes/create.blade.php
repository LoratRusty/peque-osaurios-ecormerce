@extends('layouts.admin')

@section('title', $size->id ? 'Editar Talla' : 'Nueva Talla')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-rose-50 py-10">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-3xl shadow-2xl border border-pink-100">
            <h1 class="text-2xl font-bold text-pink-600 mb-6 text-center flex items-center justify-center gap-2">
                <i class="fas fa-tags text-pink-400"></i>
                {{ $size->id ? 'Editar Talla' : 'Agregar Nueva Talla' }}
            </h1>

            <form
                action="{{ $size->id ? route('admin.products.sizes.update', $size->id) : route('admin.products.sizes.store') }}"
                method="POST" class="space-y-6">
                @csrf
                @if ($size->id)
                    @method('PUT')
                @endif

                {{-- Campo: Nombre --}}
                <div>
                    <label for="etiqueta" class="block text-sm font-semibold text-gray-600 mb-1">
                        Nombre de la Talla
                    </label>
                    <input type="text" id="etiqueta" name="etiqueta" value="{{ old('etiqueta', $size->etiqueta) }}"
                        class="w-full px-4 py-3 border-2 border-pink-100 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition duration-200 bg-pink-50/20"
                        placeholder="Ej: XL" required>
                    @error('etiqueta')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botón de acción --}}
                <div class="flex justify-between items-center mt-6">

                    <a href="{{ route('admin.products.sizes.index') }}" class="ml-4 text-pink-500 hover:underline">
                        <i class="fas fa-arrow-left mr-2"></i>Volver a Tallas
                    </a>
                    <button type="submit"
                        class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg font-semibold">
                        <i class="fas fa-save mr-2"></i>{{ $size->id ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
