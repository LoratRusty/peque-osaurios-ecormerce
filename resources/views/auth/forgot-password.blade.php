<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Pequeñosaurios</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('img/logo-pequeño.png') }}" type="image/x-icon">
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md mx-auto" data-aos="fade-up">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Encabezado -->
        <div class="bg-green-100 px-6 py-8 text-center">
            <a href="/" class="inline-flex items-center">
                <img class="h-12 w-12" src="{{ asset('img/logo-pequeño.png') }}" alt="Logo Pequeñosaurios">
                <span class="ml-2 text-2xl font-bold text-pink-600">Pequeñosaurios</span>
            </a>
        </div>

        <!-- Contenido del formulario -->
        <div class="px-6 py-8">
            @if (session('mensaje_exito'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg">
                    {{ session('mensaje_exito') }}
                </div>
            @endif
            <h1 class="text-3xl font-bold text-pink-600 mb-6 text-center">Recuperar Contraseña</h1>


            <p class="mb-6 text-sm text-gray-600">
                ¿Olvidaste tu contraseña? Ingresa tu correo electrónico y te enviaremos un enlace para restablecerla.
            </p>

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-pink-700 font-semibold mb-1">Correo electrónico</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                               class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('login') }}" class="text-sm text-pink-600 hover:text-pink-500">
                        ← Volver al login
                    </a>

                    <button type="submit"
                            class="px-6 py-3 bg-pink-500 text-white font-medium rounded-full hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors">
                        Enviar enlace
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
</script>
</body>
</html>