<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Pequeñosaurios') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="icon" href="{{ asset('img/logo-pequeño.png') }}" type="image/x-icon">
</head>
<body class="font-sans text-gray-800 antialiased bg-pink-50">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Logo -->
        <div>
            <a href="/">
                <img src="{{ asset('img/logo-pequeño.png') }}" alt="Pequeñosaurios Logo" class="h-20 w-auto">
            </a>
        </div>

        <!-- Contenido -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-lg border border-pink-200 rounded-2xl">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
