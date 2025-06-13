@extends('layouts.admin')

@section('title', 'Editar Producto')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10">
    <form action="{{ route('admin.products.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Columna Izquierda -->
            <div class="space-y-6">
                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-pink-700 font-semibold mb-1">Nombre del Producto</label>
                    <input 
                        type="text" 
                        id="nombre" 
                        name="nombre" 
                        value="{{ old('nombre', $producto->nombre) }}"
                        class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500 @error('nombre') border-red-500 @enderror"
                        placeholder="Ej: Vestido de verano"
                        required
                    >
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div>
                    <label for="descripcion" class="block text-pink-700 font-semibold mb-1">Descripción</label>
                    <textarea 
                        id="descripcion" 
                        name="descripcion" 
                        rows="4"
                        class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500 @error('descripcion') border-red-500 @enderror"
                        placeholder="Describe el producto (opcional)"
                    >{{ old('descripcion', $producto->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Columna Derecha -->
            <div class="space-y-6">
                <!-- Precio -->
                <div>
                    <label for="precio" class="block text-pink-700 font-semibold mb-1">Precio ($)</label>
                    <input 
                        type="number" 
                        id="precio" 
                        name="precio" 
                        step="0.01" 
                        min="0" 
                        value="{{ old('precio', $producto->precio) }}"
                        class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500 @error('precio') border-red-500 @enderror"
                        placeholder="0.00"
                        required
                    >
                    @error('precio')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-pink-700 font-semibold mb-1">Color</label>
                    <input 
                        type="text" 
                        id="color" 
                        name="color" 
                        value="{{ old('color', $producto->color) }}"
                        class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500 @error('color') border-red-500 @enderror"
                        placeholder="Ej: Rojo, Azul marino"
                    >
                    @error('color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categoría -->
                <div>
                    <label for="categoria_id" class="block text-pink-700 font-semibold mb-1">Categoría </label>
                    <select 
                        id="categoria_id" 
                        name="categoria_id" 
                        class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500 @error('categoria_id') border-red-500 @enderror"
                        required
                    >
                        <option value="">Seleccione una categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" 
                                {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Imagen -->
        <div x-data="imagePreview('{{ $producto->imagen ? asset('storage/' . $producto->imagen) : '' }}')">
            <label for="imagen" class="block text-pink-700 font-semibold mb-1">Imagen del Producto</label>
            <input 
                type="file" 
                id="imagen" 
                name="imagen" 
                accept="image/jpeg,image/png,image/webp"
                @change="preview"
                class="block w-full text-gray-700"
            >
            @error('imagen')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <template x-if="imageUrl">
                <img :src="imageUrl" class="mt-3 h-48 object-contain rounded-lg border border-pink-100" alt="Vista previa de imagen">
            </template>
        </div>

        <!-- Estado -->
        <div>
            <label class="block text-pink-700 font-semibold mb-1">Estado </label>
            <div class="flex items-center gap-6">
                <label class="inline-flex items-center">
                    <input 
                        type="radio" 
                        name="status" 
                        value="1" 
                        class="form-radio text-pink-500" 
                        {{ old('status', $producto->status) == '1' ? 'checked' : '' }}
                    >
                    <span class="ml-2 text-gray-700">Activo</span>
                </label>
                <label class="inline-flex items-center">
                    <input 
                        type="radio" 
                        name="status" 
                        value="0" 
                        class="form-radio text-pink-500" 
                        {{ old('status', (string)$producto->status) === '0' ? 'checked' : '' }}
                    >
                    <span class="ml-2 text-gray-700">Inactivo</span>
                </label>
            </div>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tallas y Stock -->
        <div class="border-t border-pink-100 pt-6">
            <h2 class="text-xl font-bold text-pink-600 mb-4 flex items-center gap-2">
                <i class="fas fa-ruler-combined"></i> Tallas y Stock
            </h2>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($tallas as $talla)
                    @php
                        $tallaRelacionada = $producto->sizes->firstWhere('id', $talla->id);
                        $checked = $tallaRelacionada ? 'true' : 'false';
                        $stock = $tallaRelacionada ? $tallaRelacionada->pivot->stock : 0;
                    @endphp

                    <div class="border-2 border-pink-100 rounded-xl p-4 hover:bg-pink-50 transition"
                        x-data="{ isChecked: {{ $checked }} }">
                        <label class="flex items-center mb-3">
                            <input 
                                type="checkbox" 
                                name="sizes[]" 
                                value="{{ $talla->id }}"
                                x-model="isChecked"
                                {{ $checked === 'true' ? 'checked' : '' }}
                                class="form-checkbox h-5 w-5 text-pink-500 rounded border-2 border-pink-200 focus:ring-pink-300"
                            >
                            <span class="ml-2 font-medium text-gray-700">{{ $talla->etiqueta }}</span>
                        </label>
                        <input 
                            type="number" 
                            name="stocks[{{ $talla->id }}]" 
                            value="{{ old('stocks.' . $talla->id, $stock) }}" 
                            min="0" 
                            placeholder="0"
                            x-bind:disabled="!isChecked"
                            class="w-full px-3 py-2 border-2 border-pink-100 rounded-lg focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition bg-pink-50/20"
                        >
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-between items-center mt-8">
            <a href="{{ route('admin.products') }}"
                class="inline-flex items-center text-pink-600 hover:text-pink-700 font-semibold transition">
                <i class="fas fa-arrow-left mr-2"></i>Volver a Productos
            </a>
            <button type="submit"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white rounded-xl shadow-md hover:shadow-lg font-semibold transition-all duration-300">
                <i class="fas fa-save mr-2"></i>Actualizar Producto
            </button>
        </div>
    </div>

    </form>
</div>

{{-- Alpine & JS --}}
<script>
    // Preview de imagen con Alpine
    function imagePreview(initialUrl = null) {
        return {
            imageUrl: initialUrl,
            preview(event) {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => this.imageUrl = e.target.result;
                reader.readAsDataURL(file);
            }
        }
    }
</script>
@endsection
