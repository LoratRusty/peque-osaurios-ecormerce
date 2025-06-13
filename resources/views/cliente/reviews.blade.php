@extends('layouts.cliente')

@section('title', 'Dejar una reseña')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .rating-option input:checked+.rating-card {
            border-color: #ec4899;
            background-color: #fdf2f8;
        }

        .rating-option input:checked+.rating-card .radio-dot {
            opacity: 1;
        }

        .rating-option input:checked+.rating-card .radio-circle {
            border-color: #ec4899;
        }

        .rating-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.15);
        }

        .character-count {
            font-size: 0.75rem;
            color: #6b7280;
            text-align: right;
            margin-top: 0.25rem;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Ajusta el tamaño de las imágenes en el dropdown */
        .select2-container .select2-selection--single {
            height: 42px !important;
            padding-top: 5px;
        }

        /* Estilo para las opciones */
        .select2-results__option {
            padding: 8px !important;
        }

        .select2-container .select2-selection--single {
            height: 42px !important;
            padding: 5px 0 !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            transition: border-color 0.2s, box-shadow 0.2s !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px !important;
            padding-left: 12px !important;
            padding-right: 30px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
            right: 8px !important;
        }

        .select2-container--focus .select2-selection--single {
            border-color: #ec4899 !important;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1) !important;
            outline: none !important;
        }

        .select2-dropdown {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06) !important;
            margin-top: 4px !important;
        }

        .select2-results__option {
            padding: 8px 12px !important;
        }

        .select2-results__option--highlighted {
            background-color: #fdf2f8 !important;
            color: #ec4899 !important;
        }

        /* Clase de error para mantener consistencia */
        .border-pink-500 {
            border-color: #ec4899 !important;
        }

        /* Fondo rosa suave para la opción seleccionada */
        .select2-container--default .select2-results__option[aria-selected="true"] {
            background-color: #fdf2f8 !important;
            /* Rosa muy suave */
            color: #831843 !important;
            /* Texto en rosa oscuro para contraste */
        }

        /* Fondo al pasar el mouse (hover) */
        .select2-container--default .select2-results__option--highlighted[aria-selected="true"] {
            background-color: #fbcfe8 !important;
            /* Rosa un poco más intenso */
            color: #831843 !important;
        }

        .select2-rosa .select2-selection--single {
            background-color: #fdf2f8 !important;
            border-color: #fbcfe8 !important;
        }

        /* Dropdown personalizado */
        .select2-dropdown-rosa {
            border-color: #fbcfe8 !important;
        }

        /* Flecha del dropdown */
        .select2-rosa .select2-selection__arrow b {
            border-color: #ec4899 transparent transparent transparent !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #ec4899 !important;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1) !important;
        }

        .select2-container--open .select2-selection--single {
            background-color: #fdf2f8 !important;
        }

    </style>
    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow mt-10">
        <h2 class="text-2xl font-bold text-pink-700 mb-6">Deja tu reseña</h2>

        <form action="{{ route('cliente.reviews.store') }}" method="POST" id="reviewForm">
            @csrf

            <div class="mb-4">
                <label for="nombre" class="block text-sm font-semibold text-gray-700">Tu nombre</label>
                <input type="text" name="nombre" id="nombre" required autocomplete="nombre"
                    value="{{ Auth::user()->name }}" readonly
                    class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring-pink-500 focus:border-pink-500 bg-gray-50 cursor-not-allowed">
            </div>

            <div class="mb-4">
                <label for="producto_id" class="block text-sm font-semibold text-gray-700">
                    Producto <span class="text-pink-600">*</span>
                </label>
                <select name="producto_id" id="producto_id" class="mi-select-con-imagenes">
                    <option value="" disabled selected>Selecciona un producto</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}
                            data-imagen="{{ asset('storage/' . $producto->imagen) }}"> <!-- Ruta de la imagen -->
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('producto_id')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="comentario" class="block text-sm font-semibold text-gray-700">
                    Comentario <span class="text-pink-600">*</span>
                </label>
                <textarea name="comentario" id="comentario" rows="4" required maxlength="500"
                    placeholder="Comparte tu experiencia con este producto..."
                    class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:ring-pink-500 focus:border-pink-500 transition-colors duration-200 resize-none @error('comentario') border-pink-500 @enderror">{{ old('comentario') }}</textarea>
                <div class="flex justify-between items-center">
                    @error('comentario')
                        <p class="error-message">{{ $message }}</p>
                    @else
                        <span></span>
                    @enderror
                    <div class="character-count">
                        <span id="char-count">{{ strlen(old('comentario', '')) }}</span>/500
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Calificación <span class="text-pink-600">*</span>
                </label>

                <!-- Rating Cards -->
                <div class="grid grid-cols-1 gap-3">
                    <div class="rating-option" data-value="5">
                        <input type="radio" name="puntuacion" id="rating5" value="5" class="hidden"
                            {{ old('puntuacion') == '5' ? 'checked' : '' }}>
                        <label for="rating5"
                            class="rating-card flex items-center justify-between p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-pink-300 hover:bg-pink-50 transition-all duration-200">
                            <div class="flex items-center">
                                <div class="stars text-yellow-400 text-lg mr-3">⭐⭐⭐⭐⭐</div>
                                <span class="font-medium text-gray-700">Excelente</span>
                            </div>
                            <div
                                class="radio-circle w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                <div
                                    class="radio-dot w-2.5 h-2.5 bg-pink-600 rounded-full opacity-0 transition-opacity duration-200">
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="rating-option" data-value="4">
                        <input type="radio" name="puntuacion" id="rating4" value="4" class="hidden"
                            {{ old('puntuacion') == '4' ? 'checked' : '' }}>
                        <label for="rating4"
                            class="rating-card flex items-center justify-between p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-pink-300 hover:bg-pink-50 transition-all duration-200">
                            <div class="flex items-center">
                                <div class="stars text-yellow-400 text-lg mr-3">⭐⭐⭐⭐</div>
                                <span class="font-medium text-gray-700">Muy bueno</span>
                            </div>
                            <div
                                class="radio-circle w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                <div
                                    class="radio-dot w-2.5 h-2.5 bg-pink-600 rounded-full opacity-0 transition-opacity duration-200">
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="rating-option" data-value="3">
                        <input type="radio" name="puntuacion" id="rating3" value="3" class="hidden"
                            {{ old('puntuacion') == '3' ? 'checked' : '' }}>
                        <label for="rating3"
                            class="rating-card flex items-center justify-between p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-pink-300 hover:bg-pink-50 transition-all duration-200">
                            <div class="flex items-center">
                                <div class="stars text-yellow-400 text-lg mr-3">⭐⭐⭐</div>
                                <span class="font-medium text-gray-700">Regular</span>
                            </div>
                            <div
                                class="radio-circle w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                <div
                                    class="radio-dot w-2.5 h-2.5 bg-pink-600 rounded-full opacity-0 transition-opacity duration-200">
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="rating-option" data-value="2">
                        <input type="radio" name="puntuacion" id="rating2" value="2" class="hidden"
                            {{ old('puntuacion') == '2' ? 'checked' : '' }}>
                        <label for="rating2"
                            class="rating-card flex items-center justify-between p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-pink-300 hover:bg-pink-50 transition-all duration-200">
                            <div class="flex items-center">
                                <div class="stars text-yellow-400 text-lg mr-3">⭐⭐</div>
                                <span class="font-medium text-gray-700">Malo</span>
                            </div>
                            <div
                                class="radio-circle w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                <div
                                    class="radio-dot w-2.5 h-2.5 bg-pink-600 rounded-full opacity-0 transition-opacity duration-200">
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="rating-option" data-value="1">
                        <input type="radio" name="puntuacion" id="rating1" value="1" class="hidden"
                            {{ old('puntuacion') == '1' ? 'checked' : '' }}>
                        <label for="rating1"
                            class="rating-card flex items-center justify-between p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-pink-300 hover:bg-pink-50 transition-all duration-200">
                            <div class="flex items-center">
                                <div class="stars text-yellow-400 text-lg mr-3">⭐</div>
                                <span class="font-medium text-gray-700">Muy malo</span>
                            </div>
                            <div
                                class="radio-circle w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                <div
                                    class="radio-dot w-2.5 h-2.5 bg-pink-600 rounded-full opacity-0 transition-opacity duration-200">
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                @error('puntuacion')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="window.history.back()"
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold shadow transition-colors duration-200">
                    Cancelar
                </button>
                <button type="submit" id="submitBtn"
                    class="flex-1 bg-pink-600 hover:bg-pink-700 text-white py-2 rounded-lg font-semibold shadow transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="btn-text">Enviar reseña</span>
                </button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('reviewForm');
            const comentario = document.getElementById('comentario');
            const charCount = document.getElementById('char-count');
            const ratingInputs = document.querySelectorAll('input[name="puntuacion"]');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btn-text');

            // Contador de caracteres
            function updateCharCount() {
                const count = comentario.value.length;
                charCount.textContent = count;
                charCount.style.color = count > 450 ? '#ec4899' : '#6b7280';
            }

            comentario.addEventListener('input', updateCharCount);

            // Forzar selección de rating al hacer clic en la tarjeta
            document.querySelectorAll('.rating-card').forEach(card => {
                card.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    if (input && input.type === 'radio') {
                        input.checked = true;
                        input.dispatchEvent(new Event('change')); // Disparar cambio
                    }
                });
            });

            // Validación y envío del formulario
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const errors = [];

                // Validar producto
                const producto = form.querySelector('[name="producto_id"]');
                if (!producto.value) {
                    errors.push('Debes seleccionar un producto');
                    producto.classList.add('border-pink-500');
                    isValid = false;
                } else {
                    producto.classList.remove('border-pink-500');
                }

                // Validar comentario
                if (!comentario.value.trim()) {
                    errors.push('El comentario es obligatorio');
                    comentario.classList.add('border-pink-500');
                    isValid = false;
                } else if (comentario.value.length < 10) {
                    errors.push('El comentario debe tener al menos 10 caracteres');
                    comentario.classList.add('border-pink-500');
                    isValid = false;
                } else {
                    comentario.classList.remove('border-pink-500');
                }

                // Validar puntuación
                const puntuacion = document.querySelector('input[name="puntuacion"]:checked');
                if (!puntuacion) {
                    errors.push('Debes seleccionar una calificación');
                    document.querySelectorAll('.rating-card').forEach(card => {
                        card.style.borderColor = '#ec4899';
                    });
                    isValid = false;
                } else {
                    document.querySelectorAll('.rating-card').forEach(card => {
                        card.style.borderColor = '';
                    });
                }

                if (!isValid) {
                    e.preventDefault();
                    const firstErrorField = form.querySelector('.border-pink-500') || form.querySelector(
                        '.rating-card');
                    if (firstErrorField) {
                        firstErrorField.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        if (firstErrorField.focus) firstErrorField.focus();
                    }
                } else {
                    submitBtn.disabled = true;
                    btnText.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Enviando...
                `;
                }
            });
        });
        // Inicializar Select2 con imágenes
        $('#producto_id').select2({
            templateResult: formatOption,
            templateSelection: formatSelection,
            escapeMarkup: function(m) {
                return m;
            },
            width: '100%',
            minimumResultsForSearch: Infinity,
            theme: 'default', // Asegúrate de usar el tema por defecto
            containerCssClass: 'select2-rosa', // Clase personalizada
            dropdownCssClass: 'select2-dropdown-rosa' // Clase personalizada para el dropdown
        });

        function formatOption(option) {
            if (!option.id) return option.text;
            return $(`
            <div class="flex items-center">
                <img src="${$(option.element).data('imagen')}" 
                     class="w-8 h-8 mr-2 rounded object-cover"/>
                <span>${option.text}</span>
            </div>
        `);
        }

        function formatSelection(option) {
            if (!option.id) return option.text;
            return $(`
            <div class="flex items-center">
                <img src="${$(option.element).data('imagen')}" 
                     class="w-6 h-6 mr-2 rounded object-cover"/>
                <span>${option.text}</span>
            </div>
        `);
        }

        // Mantener estilos de error si existen
        @error('producto_id')
            setTimeout(() => {
                $('.select2-container').addClass('border-pink-500');
            }, 100);
        @enderror
        $('#producto_id').on('change', function() {
            if ($(this).val()) {
                $('.select2-container').removeClass('border-pink-500');
            }
        });
    </script>

@endsection
