@extends('layouts.admin')

@section('title', 'Agregar Nuevo Producto')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10">

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

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
                        value="{{ old('nombre') }}"
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
                    >{{ old('descripcion') }}</textarea>
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
                        value="{{ old('precio') }}"
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
                        value="{{ old('color') }}"
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
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
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
        <div x-data="imagePreview()">
            <label for="imagen" class="block text-pink-700 font-semibold mb-1">Imagen del Producto</label>
            <input 
                type="file" 
                id="imagen" 
                name="imagen" 
                accept="image/jpeg,image/png,image/webp"
                @if(old('image')) value="{{ old('image') }}" @endif
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
                        {{ old('status', 1) == 1 ? 'checked' : '' }}
                    >
                    <span class="ml-2 text-gray-700">Activo</span>
                </label>
                <label class="inline-flex items-center">
                    <input 
                        type="radio" 
                        name="status" 
                        value="0" 
                        class="form-radio text-pink-500" 
                        {{ old('status') == '0' ? 'checked' : '' }}
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
                @foreach($tallas as $index => $talla)
                    <div class="border-2 border-pink-100 rounded-xl p-4 hover:bg-pink-50 transition"
                         x-data="{ isChecked: {{ is_array(old('sizes')) && in_array($talla->id, old('sizes')) ? 'true' : 'false' }} }">
                        <label class="flex items-center mb-3">
                            <input 
                                type="checkbox" 
                                name="sizes[]" 
                                value="{{ $talla->id }}"
                                x-model="isChecked"
                                class="form-checkbox h-5 w-5 text-pink-500 rounded border-2 border-pink-200 focus:ring-pink-300"
                            >
                            <span class="ml-2 font-medium text-gray-700">{{ $talla->etiqueta }}</span>
                        </label>
                        <input 
                            type="number" 
                            name="stocks[{{ $talla->id }}]" 
                            value="{{ old('stocks.'.$talla->id, 0) }}" 
                            min="0" 
                            placeholder="0"
                            x-bind:disabled="!isChecked"
                            class="w-full px-3 py-2 border-2 border-pink-100 rounded-lg focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition bg-pink-50/20"
                        />
                    </div>
                @endforeach
            </div>
            
            @error('sizes')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('stocks.')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botones -->
<div class="flex justify-between items-center mt-8 flex-wrap gap-4">

    {{-- Botón Volver a la izquierda --}}
    <a href="{{ route('admin.products') }}"
        class="inline-flex items-center text-pink-600 hover:text-pink-700 font-semibold transition">
        <i class="fas fa-arrow-left mr-2"></i>Volver a Productos
    </a>

    {{-- Botones Limpiar y Guardar a la derecha --}}
    <div class="flex gap-4">
        <button type="reset"
            class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl shadow-md font-semibold transition-all duration-300">
            <i class="fas fa-undo mr-2"></i>Limpiar Formulario
        </button>

        <button type="submit"
            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white rounded-xl shadow-md hover:shadow-lg font-semibold transition-all duration-300">
            <i class="fas fa-save mr-2"></i>Guardar Producto
        </button>
    </div>

</div>

    </form>
</div>

<script>
    // Preview de imagen
    function imagePreview() {
        return {
            imageUrl: null,
            preview(event) {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => this.imageUrl = e.target.result;
                reader.readAsDataURL(file);
            }
        }
    }
    limpiarformulario = () => {
        document.querySelector('form').reset();
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => checkbox.checked = false);
        document.querySelectorAll('input[type="number"]').forEach(input => input.value = 0);
        document.querySelectorAll('.border-2').forEach(el => el.classList.remove('border-pink-500'));
    }
    document.querySelector('button[type="reset"]').addEventListener('click', limpiarformulario);
    


</script>
@endsection