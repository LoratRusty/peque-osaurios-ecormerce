<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Pequeñosaurios</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/logo-pequeño.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />z
    
    <!-- Estilos para validación de contraseña -->
    <style>

    </style>
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-4xl mx-auto" data-aos="fade-up">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Encabezado -->
        <div class="bg-green-100 px-6 py-12 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center">
                <img class="h-16 w-16" src="{{ asset('img/logo-pequeño.png') }}" alt="Logo Pequeñosaurios">
                <span class="ml-3 text-4xl font-bold text-pink-600">Pequeñosaurios</span>
            </a>
        </div>


        <!-- Contenido del formulario -->
        <div class="px-6 py-8">
                <h1 class="text-3xl font-bold text-pink-600 mb-6 text-center">Crea tu cuenta</h1>
            
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Primera fila: Nombre y Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-pink-700 font-semibold mb-1">Nombre Completo</label>
                        <div class="mt-1">
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                                   class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500 @error('name') border-red-500 @enderror"
                                   placeholder="Ingresa tu nombre completo">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-pink-700 font-semibold mb-1">Correo electrónico</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500 @error('email') border-red-500 @enderror"
                                   placeholder="Ingresa tu correo electrónico">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Segunda fila: Dirección (ocupa todo el ancho) -->
                <div>
                    <label for="direccion" class="block text-pink-700 font-semibold mb-1">Dirección</label>
                    <div class="mt-1">
                        <textarea id="direccion" name="direccion" required rows="3"
                                class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500 @error('direccion') border-red-500 @enderror" placeholder="Ingresa tu dirección">{{ old('direccion') }}</textarea>
                        @error('direccion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tercera fila: Contraseñas -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Contraseña -->
                    <div class="space-y-4">
                        <div>
                            <label for="password" class="block text-pink-700 font-semibold mb-1">Contraseña</label>
                            <div class="mt-1 relative">
                                <input id="password" name="password" type="password" required
                                       class="w-full px-4 py-3 pr-12 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500" placeholder="Ingresa tu contraseña">
                                <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-500 hover:text-pink-700">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            
                            <!-- Barra de fortaleza de contraseña -->
                            <div class="mt-2">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-xs text-pink-600">Fortaleza:</span>
                                    <span id="strengthText" class="text-xs font-medium">Débil</span>
                                </div>
                                <div class="w-full bg-pink-200 rounded-full h-2">
                                    <div id="strengthBar" class="h-2 rounded-full transition-all duration-300 password-strength-weak" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div>
                            <label for="password_confirmation" class="block text-pink-700 font-semibold mb-1">Confirmar Contraseña</label>
                            <div class="mt-1 relative">
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                       class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500" placeholder="Confirma tu contraseña">
                                <button type="button" id="toggleConfirmPassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-500 hover:text-pink-700">
                                    <i class="fas fa-eye" id="eyeIconConfirm"></i>
                                </button>
                            </div>
                            <!-- Validación de coincidencia de contraseñas -->
                            <div id="password-match" class="mt-1 text-sm hidden">
                                <span id="match-message"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Requisitos de contraseña -->
                    <div class="lg:pl-4">
                        <div class="h-full flex flex-col justify-center">
                        <div class="mt-3 p-3 bg-pink-50 rounded-lg">
                            <p class="text-sm font-medium text-pink-700 mb-2">Requisitos de contraseña:</p>
                            <ul class="space-y-1 text-sm">
                                <li id="length-req" class="flex items-center requirement-unmet">
                                    <i class="fas fa-times mr-2" id="length-icon"></i>
                                    <span>Al menos 8 caracteres</span>
                                </li>
                                <li id="uppercase-req" class="flex items-center requirement-unmet">
                                    <i class="fas fa-times mr-2" id="uppercase-icon"></i>
                                    <span>Una letra mayúscula</span>
                                </li>
                                <li id="number-req" class="flex items-center requirement-unmet">
                                    <i class="fas fa-times mr-2" id="number-icon"></i>
                                    <span>Un número</span>
                                </li>
                                <li id="special-req" class="flex items-center requirement-unmet">
                                    <i class="fas fa-times mr-2" id="special-icon"></i>
                                    <span>Un carácter especial (!@#$%^&*)</span>
                                </li>
                            </ul>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4">
                    <a href="{{ route('login') }}" class="text-sm text-pink-600 hover:text-pink-500 order-2 sm:order-1">
                        ¿Ya tienes cuenta? Inicia sesión
                    </a>

                    <button id="registerBtn" type="submit"
                            class="w-full sm:w-auto px-8 py-3 bg-pink-500 text-white font-medium rounded-lg hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed order-1 sm:order-2"
                            disabled>
                        Registrarse
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-out-quad',
        once: true
    });
    document.addEventListener('DOMContentLoaded', function() {


        // Variables para elementos del DOM
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
        const eyeIconConfirm = document.getElementById('eyeIconConfirm');
        const eyeIcon = document.getElementById('eyeIcon');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        const passwordMatch = document.getElementById('password-match');
        const matchMessage = document.getElementById('match-message');

        // Elementos de requisitos
        const requirements = {
            length: { element: document.getElementById('length-req'), icon: document.getElementById('length-icon') },
            uppercase: { element: document.getElementById('uppercase-req'), icon: document.getElementById('uppercase-icon') },
            number: { element: document.getElementById('number-req'), icon: document.getElementById('number-icon') },
            special: { element: document.getElementById('special-req'), icon: document.getElementById('special-icon') }
        };

        // Función para validar requisitos de contraseña
        function validatePassword(password) {
            const validations = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                number: /\d/.test(password),
                special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
            };

            // Actualizar indicadores visuales
            Object.keys(validations).forEach(key => {
                const isValid = validations[key];
                const req = requirements[key];
                
                if (isValid) {
                    req.element.classList.remove('requirement-unmet');
                    req.element.classList.add('requirement-met');
                    req.icon.classList.remove('fa-times');
                    req.icon.classList.add('fa-check');
                } else {
                    req.element.classList.remove('requirement-met');
                    req.element.classList.add('requirement-unmet');
                    req.icon.classList.remove('fa-check');
                    req.icon.classList.add('fa-times');
                }
            });

            // Calcular fortaleza
            const validCount = Object.values(validations).filter(v => v).length;
            updateStrengthBar(validCount, password.length);

            return Object.values(validations).every(v => v);
        }

        // Función para actualizar barra de fortaleza
        function updateStrengthBar(validCount, passwordLength) {
            let strength = 0;
            let strengthLabel = 'Muy débil';
            let strengthClass = 'password-strength-weak';

            if (passwordLength === 0) {
                strength = 0;
                strengthLabel = 'Muy débil';
            } else if (validCount === 1) {
                strength = 25;
                strengthLabel = 'Débil';
                strengthClass = 'password-strength-weak';
            } else if (validCount === 2) {
                strength = 50;
                strengthLabel = 'Regular';
                strengthClass = 'password-strength-medium';
            } else if (validCount === 3) {
                strength = 75;
                strengthLabel = 'Buena';
                strengthClass = 'password-strength-medium';
            } else if (validCount === 4) {
                strength = 100;
                strengthLabel = 'Fuerte';
                strengthClass = 'password-strength-strong';
            }

            strengthBar.style.width = strength + '%';
            strengthBar.className = 'h-2 rounded-full transition-all duration-300 ' + strengthClass;
            strengthText.textContent = strengthLabel;
            strengthText.className = 'text-xs font-medium ' + (strength >= 75 ? 'text-green-600' : strength >= 50 ? 'text-yellow-600' : 'text-red-600');
        }

        // Función para validar coincidencia de contraseñas
        function validatePasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (confirmPassword.length === 0) {
                passwordMatch.classList.add('hidden');
                return false;
            }

            passwordMatch.classList.remove('hidden');
            
            if (password === confirmPassword) {
                matchMessage.textContent = '✓ Las contraseñas coinciden';
                matchMessage.className = 'text-green-600';
                return true;
            } else {
                matchMessage.textContent = '✗ Las contraseñas no coinciden';
                matchMessage.className = 'text-red-600';
                return false;
            }
        }

        // Event listeners
        passwordInput.addEventListener('input', function() {
            validatePassword(this.value);
        });

        confirmPasswordInput.addEventListener('input', function() {
            validatePasswordMatch();
        });

        // Toggle para mostrar/ocultar contraseña
        togglePasswordBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            if (type === 'text') {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        toggleConfirmPasswordBtn.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            
            if (type === 'text') {
                eyeIconConfirm.classList.remove('fa-eye');
                eyeIconConfirm.classList.add('fa-eye-slash');
            } else {
                eyeIconConfirm.classList.remove('fa-eye-slash');
                eyeIconConfirm.classList.add('fa-eye');
            }
        });

        // Validación del formulario completo
        const nameInput = document.getElementById('name');
        const direccionInput = document.getElementById('direccion');
        const emailInput = document.getElementById('email');
        const registerBtn = document.getElementById('registerBtn');

        function isFormValid() {
            const passwordValid = validatePassword(passwordInput.value);
            const passwordsMatch = validatePasswordMatch();

            return nameInput.value.trim() !== '' &&
                direccionInput.value.trim() !== '' &&
                emailInput.value.trim() !== '' &&
                passwordValid &&
                passwordsMatch;
        }

        function checkFormValidity() {
            if (isFormValid()) {
                registerBtn.removeAttribute('disabled');
            } else {
                registerBtn.setAttribute('disabled', 'disabled');
            }
        }

        // Eventos que disparan la validación del formulario completo
        nameInput.addEventListener('input', checkFormValidity);
        direccionInput.addEventListener('input', checkFormValidity);
        emailInput.addEventListener('input', checkFormValidity);
        passwordInput.addEventListener('input', checkFormValidity);
        confirmPasswordInput.addEventListener('input', checkFormValidity);

        // Validación inicial al cargar
        checkFormValidity();
    });
</script>
</body>
</html>