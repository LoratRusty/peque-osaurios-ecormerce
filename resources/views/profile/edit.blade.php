@php
    $layout = auth()->user()->tipo !== 'cliente' ? 'layouts.admin' : 'layouts.cliente';
@endphp

@extends($layout)

@section('title', 'Perfil de Usuario')

@section('content')
<div class="max-w-4xl mx-auto p-8 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10">

    <section>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="bg-pink-50 border border-pink-200 rounded-xl p-6 hover:shadow-md transition-shadow duration-300">
                <dt class="text-pink-700 font-semibold mb-1">Nombre</dt>
                <dd class="text-gray-800 select-text">{{ $user->name }}</dd>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 hover:shadow-md transition-shadow duration-300">
                <dt class="text-blue-700 font-semibold mb-1">Correo Electrónico</dt>
                <dd class="text-gray-800 select-text">{{ $user->email }}</dd>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-xl p-6 hover:shadow-md transition-shadow duration-300">
                <dt class="text-green-700 font-semibold mb-1">Rol</dt>
                <dd class="text-gray-800 select-text">{{ ucfirst($user->tipo) }}</dd>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow duration-300">
                <dt class="text-gray-700 font-semibold mb-1">Fecha de Creación</dt>
                <dd class="text-gray-800 select-text">{{ $user->created_at->format('d/m/Y H:i') }}</dd>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow duration-300">
                <dt class="text-gray-700 font-semibold mb-1">Última Actualización</dt>
                <dd class="text-gray-800 select-text">{{ $user->updated_at->format('d/m/Y H:i') }}</dd>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow duration-300">
                <dt class="text-gray-700 font-semibold mb-1">Dirección</dt>
                <dd class="text-gray-800 select-text">{{ $user->direccion ?: 'No disponible' }}</dd>
            </div>
        </dl>
    </section>

</div>
@endsection
