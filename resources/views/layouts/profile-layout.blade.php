<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Pequeñosaurios') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('img/logo-pequeño.png') }}" type="image/x-icon" />
</head>
<body class="font-sans text-gray-800 antialiased bg-pink-50 min-h-screen flex flex-col items-center pt-6">

    {{-- Logo --}}
    <div>
        <a href="/">
            <img src="{{ asset('img/logo-pequeño.png') }}" alt="Pequeñosaurios Logo" class="h-20 w-auto" />
        </a>
    </div>

    {{-- Header --}}
    @if(View::hasSection('header'))
        <header class="w-full max-w-xl mt-6 px-6 py-4 bg-green-100 rounded-xl shadow-md border border-green-200">
            <h2 class="text-xl font-semibold text-green-700 text-center">
                @yield('header')
            </h2>
        </header>
    @endif

    {{-- Contenido --}}
    <main class="w-full max-w-xl mt-6 px-6 py-8 bg-white shadow-lg border border-blue-200 rounded-2xl">
        @yield('content')
    </main>

</body>
</html>
