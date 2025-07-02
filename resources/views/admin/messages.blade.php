@extends('layouts.admin')

@section('title', 'Mensajes de Contacto')

@section('content')
    <style>
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .bg-pink-25 {
            background-color: rgb(253 242 248);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        #modal.show {
            animation: fadeIn 0.3s ease-out;
        }
    </style>

    <div class="max-w-7xl mx-auto p-6">
        <div class="bg-white rounded-xl shadow-md p-6 space-y-6">
            {{-- Filtros y búsqueda --}}
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                {{-- Filtros --}}
                <div class="flex flex-wrap items-center gap-2">
                    <div class="flex items-center space-x-2 w-full sm:w-auto">
                        <svg class="w-5 h-5 text-pink-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Filtros:</span>
                    </div>

                    <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                        <button data-status="all" onclick="filterMessages('all', event)"
                            class="filter-btn flex-1 sm:flex-none px-3 py-1 text-sm rounded-full border border-pink-200 text-pink-600 hover:bg-pink-50 transition">
                            Todos
                        </button>

                        <button data-status="responded" onclick="filterMessages('responded', event)"
                            class="filter-btn flex-1 sm:flex-none px-3 py-1 text-sm rounded-full border border-green-200 text-green-600 hover:bg-green-50 transition">
                            Respondidos
                        </button>

                        <button data-status="pending" onclick="filterMessages('pending', event)"
                            class="filter-btn flex-1 sm:flex-none px-3 py-1 text-sm rounded-full border border-red-200 text-red-600 hover:bg-red-50 transition">
                            Pendientes
                        </button>
                    </div>
                </div>

                {{-- Buscador --}}
                <div class="flex items-center space-x-2 w-full lg:w-auto">
                    <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" placeholder="Buscar..." id="searchInput"
                        class="w-full lg:w-64 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm">
                </div>
            </div>

            {{-- Estadísticas resumen --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Total --}}
                <div class="bg-gradient-to-r from-pink-500 to-pink-600 rounded-xl shadow-lg p-4 text-white text-center">
                    <div class="text-2xl font-bold">{{ $messages->total() ?? $messages->count() }}</div>
                    <div class="text-sm text-pink-100">Total Mensajes</div>
                </div>

                {{-- Respondidos --}}
                <div class="bg-gradient-to-r from-green-400 to-green-500 rounded-xl shadow-lg p-4 text-white text-center">
                    <div class="text-2xl font-bold">{{ $messages->where('respondido', true)->count() }}</div>
                    <div class="text-sm text-green-100">Mensajes Respondidos</div>
                </div>

                {{-- Pendientes --}}
                <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-xl shadow-lg p-4 text-white text-center">
                    <div class="text-2xl font-bold">{{ $messages->where('respondido', false)->count() }}</div>
                    <div class="text-sm text-yellow-100">Mensajes Pendientes</div>
                </div>
            </div>
        </div>



        <!-- Messages Table -->
        <div class="bg-white rounded-xl shadow-md mt-6 p-6 w-full max-w-screen-xl mx-auto">
            {{-- Mensajes --}}
            @if ($messages->isEmpty())
                <div class="flex flex-col items-center justify-center py-16">
                    <div class="w-24 h-24 bg-pink-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay mensajes</h3>
                    <p class="text-gray-500 text-center">Aún no has recibido ningún mensaje de contacto.</p>
                </div>
            @else
                <div x-data="{ confirmingDeleteId: null }" class="overflow-x-auto w-full max-w-full">

                    <table class="table-auto w-full divide-y divide-gray-200" id="messagesTable">
                        <thead class="bg-gradient-to-r from-pink-50 to-pink-100">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-pink-800 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span>Nombre</span>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-pink-800 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                            </path>
                                        </svg>
                                        <span>Email</span>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-pink-800 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Fecha Recibido</span>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-pink-800 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-pink-800 uppercase tracking-wider">
                                    Fecha Respuesta
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-pink-800 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="messagesBody">
                            @foreach ($messages as $message)
                                <tr class="message-row" data-name="{{ strtolower($message->nombre) }}"
                                    data-email="{{ strtolower($message->email) }}"
                                    data-status="{{ $message->respondido ? 'responded' : 'pending' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center text-white font-semibold text-sm">
                                                    {{ strtoupper(substr($message->nombre, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $message->nombre }}</div>
                                                <button onclick="openModal({{ $message->id }})"
                                                    class="text-pink-600 hover:text-pink-800 text-xs mt-1 font-medium">Ver
                                                    Mensaje →</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700">{{ $message->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $message->created_at->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $message->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($message->respondido)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Respondido
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($message->respondido)
                                            <div class="text-sm text-gray-900">
                                                {{ $message->updated_at ? $message->updated_at->format('d/m/Y') : 'N/A' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $message->updated_at ? $message->updated_at->format('H:i') : '' }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm">No respondido</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center space-x-2">

                                            {{-- Botón Responder --}}
                                            <button onclick="openModal({{ $message->id }})"
                                                class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-lg hover:from-pink-600 hover:to-pink-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50 shadow-sm hover:shadow-md transform hover:-translate-y-0.5"
                                                title="Responder mensaje">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                                </svg>
                                                <span class="hidden sm:inline">Responder</span>
                                            </button>
                                            {{-- Eliminar --}}
                                            <div x-data="{ confirmingDeleteId: null }">
                                                {{-- Botón Eliminar --}}
                                                <button type="button" @click="confirmingDeleteId = {{ $message->id }}"
                                                    class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50 shadow-sm hover:shadow-md transform hover:-translate-y-0.5"
                                                    title="Eliminar mensaje">
                                                    <i class="fas fa-trash-alt mr-1"></i>Eliminar
                                                </button>

                                                {{-- Formulario oculto para eliminar --}}
                                                <form id="delete-message-{{ $message->id }}"
                                                    action="{{ route('admin.messages.delete', $message->id) }}"
                                                    method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                {{-- Componente de confirmación --}}
                                                <x-confirm-delete-modal :id="$message->id"
                                                    title="Confirmar eliminación de mensaje"
                                                    message="¿Estás seguro que deseas eliminar este mensaje?<br>Esta acción no se puede deshacer."
                                                    confirmIdVar="confirmingDeleteId" confirmText="Sí, eliminar mensaje"
                                                    confirmColor="red"
                                                    formSelector="#delete-message-{{ $message->id }}" />
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                {{-- Paginación --}}
                @if ($messages->hasPages())
                    <div
                        class="mt-6 bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 rounded-b-lg">
                        <div class="text-sm text-gray-700">
                            Mostrando {{ $messages->firstItem() }} - {{ $messages->lastItem() }} de
                            {{ $messages->total() }} Mensajes
                        </div>
                        <div class="flex space-x-2">
                            @if ($messages->onFirstPage())
                                <span
                                    class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Anterior</span>
                            @else
                                <a href="{{ $messages->previousPageUrl() }}"
                                    class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Anterior</a>
                            @endif

                            @if ($messages->hasMorePages())
                                <a href="{{ $messages->nextPageUrl() }}"
                                    class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Siguiente</a>
                            @else
                                <span
                                    class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Siguiente</span>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>

        {{-- Modal --}}
        <div id="modal"
            class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
            <div
                class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl transform transition-all">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            Responder Mensaje
                        </h2>
                        <button onclick="closeModal()" class="text-white hover:text-pink-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="p-6">
                    <div id="modal-content" class="mb-6 bg-gray-50 rounded-xl p-4">
                        {{-- Aquí cargaremos con JS el contenido del mensaje --}}
                    </div>

                    <!-- Response Form -->
                    <form id="response-form" method="POST" action="{{ route('admin.messages.respond') }}"
                        class="space-y-4">
                        @csrf
                        <input type="hidden" name="message_id" id="message_id">

                        <div class="bg-white border-2 border-pink-100 rounded-xl p-4">
                            <label for="response"
                                class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-pink-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                                Tu Respuesta:
                            </label>
                            <textarea id="response" name="response" rows="6" required placeholder="Escribe tu respuesta aquí..."
                                class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent resize-none transition-all duration-200"></textarea>
                            <div class="flex justify-between items-center mt-2 text-xs text-gray-500">
                                <span>Mínimo 10 caracteres</span>
                                <span id="charCount">0 caracteres</span>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                            <button type="button" onclick="closeModal()"
                                class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 font-medium">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="px-6 py-2.5 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center"
                                id="submitBtn">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Enviar Respuesta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        const messages = @json($messages->keyBy('id'));

        let currentFilter = 'all';
        let currentSearchTerm = '';

        function openModal(id) {
            const modal = document.getElementById('modal');
            const content = document.getElementById('modal-content');
            const messageIdInput = document.getElementById('message_id');
            const responseTextarea = document.getElementById('response');

            const message = messages[id];

            if (!message) return;

            content.innerHTML = `
            <div class="space-y-4">
                <!-- Información del remitente -->
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center text-white font-bold">
                            ${message.nombre.charAt(0).toUpperCase()}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">${message.nombre}</p>
                            <p class="text-sm text-gray-600">${message.email}</p>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 bg-white rounded-lg p-2">
                        <strong>Recibido:</strong> ${new Date(message.created_at).toLocaleDateString('es-ES', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}
                    </div>
                </div>

                <!-- Mensaje -->
                <div>
                    <div class="bg-white rounded-lg p-4 border-l-4 border-pink-400">
                        <h4 class="font-semibold text-gray-800 mb-2">Mensaje:</h4>
                        <div class="text-gray-700 leading-relaxed whitespace-pre-wrap">${message.mensaje}</div>
                    </div>
                </div>
            </div>
        `;

            messageIdInput.value = id;
            responseTextarea.value = '';
            updateCharCount();

            modal.classList.remove('hidden');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('modal');
            modal.classList.add('hidden');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        function applyFilters() {
            const rows = document.querySelectorAll('.message-row');
            const searchTerm = currentSearchTerm.toLowerCase();

            rows.forEach(row => {
                const name = (row.dataset.name || '').toLowerCase();
                const email = (row.dataset.email || '').toLowerCase();
                const status = row.dataset.status || '';

                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesFilter = currentFilter === 'all' || status === currentFilter;

                row.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
            });
        }


        function filterMessages(status, event) {
            currentFilter = status;

            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => {
                btn.classList.remove('bg-pink-100', 'text-pink-800', 'border-pink-300');
                btn.classList.add('border', 'border-pink-200', 'text-pink-600');
            });

            if (event && event.currentTarget) {
                const btn = event.currentTarget;
                btn.classList.remove('border-pink-200', 'text-pink-600');
                btn.classList.add('bg-pink-100', 'text-pink-800', 'border-pink-300');
            }

            applyFilters();
        }

        function searchMessages() {
            const input = document.getElementById('searchInput');
            currentSearchTerm = input.value.toLowerCase().trim();
            applyFilters();
        }

        function updateCharCount() {
            const textarea = document.getElementById('response');
            const charCount = document.getElementById('charCount');
            const submitBtn = document.getElementById('submitBtn');

            if (textarea && charCount) {
                const count = textarea.value.length;
                charCount.textContent = `${count} caracteres`;

                if (submitBtn) {
                    if (count < 10) {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        submitBtn.classList.remove('hover:from-pink-600', 'hover:to-pink-700');
                    } else {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        submitBtn.classList.add('hover:from-pink-600', 'hover:to-pink-700');
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const responseTextarea = document.getElementById('response');
            if (responseTextarea) {
                responseTextarea.addEventListener('input', updateCharCount);
            }

            const input = document.getElementById('searchInput');
            if (input) {
                input.addEventListener('input', searchMessages);
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });

            document.getElementById('modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            document.querySelectorAll('form[action*="delete"]').forEach(form => {
                form.addEventListener('submit', confirmDelete);
            });

            filterMessages('all');
        });
    </script>

@endsection
