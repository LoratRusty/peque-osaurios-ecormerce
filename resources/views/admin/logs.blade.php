@extends('layouts.admin')

@section('title', 'Logs del sistema')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-rose-50 py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Filtros y búsqueda mejorados --}}
            <div class="bg-white rounded-2xl shadow-lg border border-pink-100 overflow-hidden">
                {{-- Header del panel de filtros --}}
                <div class="bg-gradient-to-r from-pink-500 to-rose-500 px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white/20 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Panel de Filtros</h3>
                        </div>
                    </div>
                </div>

                {{-- Contenido del panel --}}
                <div class="p-6 space-y-6">
                    {{-- Búsqueda principal --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" placeholder="Buscar por ID, usuario o acción..." id="searchInput"
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent text-sm bg-gray-50 transition-all duration-200 hover:bg-white">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <kbd
                                class="hidden sm:inline-flex items-center px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded">
                                Ctrl+K
                            </kbd>
                        </div>
                    </div>

                    {{-- Filtros adicionales --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-4 border-t border-gray-100">
                        {{-- Filtro por fecha --}}
                        <div class="space-y-2">
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Período</label>
                            <select id="dateFilter"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white">
                                <option value="all">Todas las fechas</option>
                                <option value="today">Hoy</option>
                                <option value="week">Esta semana</option>
                                <option value="month">Este mes</option>
                            </select>
                        </div>

                        {{-- Ordenar por --}}
                        <div class="space-y-2">
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Ordenar por</label>
                            <select id="sortFilter"
                                class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white">
                                <option value="newest">Más recientes</option>
                                <option value="oldest">Más antiguos</option>
                                <option value="user">Usuario A-Z</option>
                            </select>
                        </div>

                        {{-- Botón de limpiar filtros --}}
                        <div class="space-y-2">
                            <label class="text-xs font-semibold text-gray-600 uppercase tracking-wide">Acciones</label>
                            <button type="button" onclick="clearAllFilters()"
                                class="w-full px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Limpiar filtros</span>
                            </button>
                        </div>
                    </div>

                    {{-- Estadísticas rápidas --}}

                    <div class="bg-gradient-to-r from-pink-50 to-rose-50 rounded-xl p-4 border border-pink-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-pink-100 rounded-lg">
                                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700">Total de Registros</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-pink-600" id="totalCount">{{ $logs->total() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla de logs --}}
            <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-pink-100 text-pink-800 text-sm">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold">ID</th>
                            <th class="px-6 py-2 text-left font-semibold min-w-[180px]">Usuario</th>
                            <th class="px-4 py-2 text-left font-semibold">Acción</th>
                            <th class="px-4 py-2 text-left font-semibold">Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="logsTable" class="divide-y divide-gray-100 text-sm">
                        @foreach ($logs as $log)
                            <tr data-id="{{ $log->id }}" data-user="{{ strtolower($log->user->name ?? '') }}"
                                data-action="{{ strtolower($log->accion) }}"
                                data-date="{{ \Carbon\Carbon::parse($log->fecha)->format('Y-m-d H:i:s') }}"
                                class="hover:bg-gray-50 transition-colors duration-200 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="px-4 py-2">{{ $log->id }}</td>
                                <td class="px-4 py-2">
                                    {{ $log->user->id ?? 'Desconocido' }} - {{ $log->user->name ?? 'Desconocido' }}
                                </td>
                                <td class="px-4 py-2">{{ ucfirst($log->accion) }}</td>
                                <td class="px-4 py-2 text-gray-500">
                                    {{ \Carbon\Carbon::parse($log->fecha)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if ($logs->hasPages())
                <div
                    class="mt-6 bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 rounded-b-lg">
                    <div class="text-sm text-gray-700">
                        Mostrando {{ $logs->firstItem() }} - {{ $logs->lastItem() }} de {{ $logs->total() }} Logs
                    </div>
                    <div class="flex space-x-2">
                        @if ($logs->onFirstPage())
                            <span
                                class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Anterior</span>
                        @else
                            <a href="{{ $logs->previousPageUrl() }}"
                                class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Anterior</a>
                        @endif

                        @if ($logs->hasMorePages())
                            <a href="{{ $logs->nextPageUrl() }}"
                                class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Siguiente</a>
                        @else
                            <span
                                class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Siguiente</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        let currentSearch = '';
        const searchInput = document.getElementById('searchInput');
        const dateFilter = document.getElementById('dateFilter');
        const sortFilter = document.getElementById('sortFilter');
        const tbody = document.getElementById('logsTable');

        // Atajo Ctrl+K
        document.addEventListener('keydown', e => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
            }
        });

        // Eventos
        searchInput.addEventListener('input', onFilterChange);
        dateFilter.addEventListener('change', onFilterChange);
        sortFilter.addEventListener('change', onSortChange);

        function onFilterChange() {
            currentSearch = searchInput.value.toLowerCase();
            applyLogFilters();
            updateVisibleCount();
        }

        function onSortChange() {
            sortRows();
        }

        function applyLogFilters() {
            const rows = tbody.querySelectorAll('.log-row');
            const today = new Date();
            rows.forEach(row => {
                const textMatch = ['id', 'user', 'action'].some(key => {
                    const val = row.dataset[key] || '';
                    return val.includes(currentSearch);
                });
                // Filtro de fecha
                let dateMatch = true;
                const dt = new Date(row.dataset.date);
                const diffDays = Math.floor((today - dt) / (1000 * 60 * 60 * 24));
                switch (dateFilter.value) {
                    case 'today':
                        dateMatch = diffDays === 0;
                        break;
                    case 'week':
                        dateMatch = diffDays < 7;
                        break;
                    case 'month':
                        dateMatch = today.getMonth() === dt.getMonth() && today.getFullYear() === dt.getFullYear();
                        break;
                }
                row.style.display = (textMatch && dateMatch) ? '' : 'none';
            });
        }

        function sortRows() {
            const rowsArray = Array.from(tbody.querySelectorAll('.log-row'));
            rowsArray.sort((a, b) => {
                if (sortFilter.value === 'newest' || sortFilter.value === 'oldest') {
                    const da = new Date(a.dataset.date),
                        db = new Date(b.dataset.date);
                    return sortFilter.value === 'newest' ? db - da : da - db;
                } else if (sortFilter.value === 'user') {
                    return a.dataset.user.localeCompare(b.dataset.user);
                }
            });
            rowsArray.forEach(r => tbody.appendChild(r));
        }

        function updateVisibleCount() {
            const visible = tbody.querySelectorAll('.log-row:not([style*="display: none"])').length;
            document.getElementById('visibleCount').textContent = visible;
        }

        function clearAllFilters() {
            searchInput.value = '';
            dateFilter.value = 'all';
            sortFilter.value = 'newest';
            currentSearch = '';
            applyLogFilters();
            sortRows();
            updateVisibleCount();
        }

        // Inicialización
        document.addEventListener('DOMContentLoaded', () => {
            sortRows();
            updateVisibleCount();
        });
        // Ordenar por
        document.getElementById('sortFilter').addEventListener('change', e => {
            const sortValue = e.target.value;
            const tableBody = document.getElementById('logsTable');
            const rows = Array.from(tableBody.querySelectorAll('.log-row'));

            let sortedRows;

            if (sortValue === 'newest') {
                // Ordenar por fecha descendente
                sortedRows = rows.sort((a, b) => {
                    return new Date(b.dataset.date) - new Date(a.dataset.date);
                });
            } else if (sortValue === 'oldest') {
                // Ordenar por fecha ascendente
                sortedRows = rows.sort((a, b) => {
                    return new Date(a.dataset.date) - new Date(b.dataset.date);
                });
            } else if (sortValue === 'user') {
                // Ordenar por usuario A-Z
                sortedRows = rows.sort((a, b) => {
                    return a.dataset.user.localeCompare(b.dataset.user);
                });
            }

            // Re-append de las filas ordenadas
            tableBody.innerHTML = '';
            sortedRows.forEach(row => tableBody.appendChild(row));

            applyLogFilters(); // Volver a aplicar filtros si los hay
            updateVisibleCount();
        });
    </script>
@endsection
