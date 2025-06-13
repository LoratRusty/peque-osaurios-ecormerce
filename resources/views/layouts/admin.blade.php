<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Panel Administración - Pequeñosaurios')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="icon" href="{{ asset('img/logo-pequeño.png') }}" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .sidebar-gradient {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #bbf7d0 100%);
        }
        .nav-item-active {
            background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.3);
        }
        .nav-item-hover:hover {
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(236, 72, 153, 0.1);
        }
        .main-content {
            background: linear-gradient(135deg, #fef7ff 0%, #fdf4ff 50%, #fae8ff 100%);
        }
        .header-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #fdf2f8 100%);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-pink-50 via-purple-50 to-rose-50 min-h-screen flex font-sans text-gray-800">

    <button 
        id="btn-menu-mobile" 
        class="fixed left-4 z-50 w-10 h-10 rounded-lg bg-pink-400 text-white flex items-center justify-center md:hidden shadow-lg"
        aria-label="Toggle menu"
        style="top: 64px;">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>


    {{-- Sidebar --}}
        <aside 
            id="sidebar" 
            class="fixed inset-y-0 left-0 z-50 w-72 sidebar-gradient shadow-2xl flex flex-col overflow-hidden transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:flex-shrink-0"
        >
        <!-- Header del Sidebar -->
        <div class="px-6 py-6 flex items-center border-b border-green-200/50 relative z-10">
            <a class="flex items-center space-x-4 group" href="#">
                <div class="relative">
                    <div class="absolute inset-0 bg-pink-400 rounded-xl blur-sm opacity-30 group-hover:opacity-50 transition-opacity"></div>
                    <img class="h-14 w-14 relative z-10 rounded-xl shadow-lg" 
                         src="{{ asset('img/logo-pequeño.png') }}" 
                         alt="Logo Pequeñosaurios" />
                </div>
                <div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-rose-600 bg-clip-text text-transparent">
                        Pequeñosaurios
                    </span>
                    <p class="text-sm text-gray-600 font-medium">Panel de Administración</p>
                </div>
            </a>
        </div>

        <!-- Usuario Info -->
        <a href="{{ route('profile.edit') }}" class="block px-6 py-4 bg-white/50 backdrop-blur-sm mx-4 mt-4 rounded-xl border border-white/20 shadow-sm cursor-pointer hover:bg-white/70 hover:shadow-lg hover:scale-[1.02] transition transform duration-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                    <span class="text-white font-bold text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </span>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ session('usuario.name') }}</p>
                    <p class="inline-block w-auto text-xs text-gray-600 capitalize bg-gradient-to-r from-pink-100 to-purple-100 px-2 py-1 rounded-full">
                        Rol: <strong>{{ getRolNombre(auth()->user()->tipo) }}</strong>
                    </p>
                </div>
            </div>
        </a>
        <!-- Navegación -->
        <nav class="flex-grow mt-6 px-4 space-y-2 relative z-10 overflow-y-auto">
            @php
                // Menú con iconos oficiales de Heroicons Outline
                $menuItems = [
                    [
                        'route' => 'admin.dashboard',
                        'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z',
                        'text' => 'Dashboard',
                        'roles' => ['admin', 'soporte', 'inventario', 'ventas']
                    ],
                    [
                        'route' => 'admin.users',
                        'icon' => 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z',
                        'text' => 'Usuarios',
                        'roles' => ['admin']
                    ],
                    [
                        'route' => 'admin.messages',
                        'icon' => 'M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3',
                        'text' => 'Mensajes',
                        'roles' => ['admin', 'soporte']
                    ],
                    [
                        'route' => 'admin.products',
                        'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                        'text' => 'Productos',
                        'roles' => ['admin', 'inventario']
                    ],
                    [
                        'route' => 'admin.payments',
                        'icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z',
                        'text' => 'Métodos de Pago',
                        'roles' => ['admin', 'ventas']
                    ],
                    [
                        'route' => 'admin.invoice',
                        'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
                        'text' => 'Facturas',
                        'roles' => ['admin', 'ventas']
                    ],
                    [
                        'route' => 'admin.reviews',
                        'icon' => 'M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z',
                        'text' => 'Opiniones',
                        'roles' => ['admin', 'soporte']
                    ],
                    [
                        'route' => 'admin.logs',
                        'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z',
                        'text' => 'Logs',
                        'roles' => ['admin']
                    ],
                ];
            @endphp

            @foreach ($menuItems as $item)
                @if (in_array(auth()->user()->tipo, $item['roles']))
                    <a href="{{ route($item['route']) }}" 
                    class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 nav-item-hover
                    {{ request()->routeIs($item['route'] . '*') ? 'nav-item-active' : 'text-gray-700' }}">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg
                                {{ request()->routeIs($item['route'] . '*') ? 'bg-white/20' : 'bg-pink-100 group-hover:bg-pink-200' }} 
                                transition-colors duration-300">
                                <svg class="w-5 h-5 {{ request()->routeIs($item['route'] . '*') ? 'text-white' : 'text-pink-600' }}" 
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}"></path>
                                </svg>
                            </div>
                            <span class="font-semibold text-sm">{{ $item['text'] }}</span>
                        </div>
                        <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                @endif
            @endforeach
        </nav>
        <!-- Footer del Sidebar -->
        <div class="px-6 py-4 mt-auto bg-white/50 backdrop-blur-sm mx-4 mb-4 rounded-xl border border-white/20 shadow-sm">
            <p class="text-xs text-gray-600">Admin Panel -Pequeñosaurios &copy; {{ date('Y') }}.</p>
            <p class="text-xs text-gray-500">Versión 1.0.0</p>
        </div>
    </aside>

    {{-- Contenido principal --}}
    <main class="flex-1">
        <!-- Header -->
        <header id="main-header" class="header-gradient backdrop-blur-sm border-b border-white/20 shadow-sm sticky top-0 z-40">
            <div class="px-8 py-6 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="w-2 h-8 bg-gradient-to-b from-pink-500 to-purple-600 rounded-full"></div>
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                            @yield('title', 'Panel de Administración')
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">

                    <!-- Botón de Cerrar Sesión -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="group flex items-center w-full px-4 py-3 rounded-xl transition-all duration-300 nav-item-hover text-gray-700">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 group-hover:bg-red-200 transition-colors duration-300">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                                    </svg>
                                </div>
                                <span class="font-semibold text-sm">Cerrar sesión</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </header>
        <div id="content">
            @yield('content')
        </div>
        <div id="toast-container"></div>


    </main>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const icons = {
                success: `
                    <svg class="toast-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>`,
                error: `
                    <svg class="toast-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>`
            };

            const toast = document.createElement('div');
            toast.classList.add('toast', type);
            toast.setAttribute('role', 'alert');

            toast.innerHTML = `
                <div class="toast-content">
                    ${icons[type] || ''}
                    <p class="toast-message">${message}</p>
                </div>
                <button class="toast-close" aria-label="Cerrar">&times;</button>
            `;

            // Cerrar al click en la X
            toast.querySelector('.toast-close').addEventListener('click', () => {
                removeToast(toast);
            });

            container.appendChild(toast);

            // Forzar reflow para activar animación
            void toast.offsetWidth;

            toast.classList.add('show');

            // Auto cerrar tras 5 segundos
            setTimeout(() => removeToast(toast), 5000);
        }

        function removeToast(toast) {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 500);
        }

        // Lanzar los toasts desde Laravel
        window.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif

            @if(session('error'))
                showToast("{{ session('error') }}", 'error');
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    showToast("{{ $error }}", 'error');
                @endforeach
            @endif
        });

        document.addEventListener('DOMContentLoaded', () => {
            const btnMenu = document.getElementById('btn-menu-mobile');
            const sidebar = document.getElementById('sidebar');
            const header = document.querySelector('header');

            if (!btnMenu || !sidebar || !header) return;

            // Función para posicionar el botón
            const positionMenuButton = () => {
                const headerHeight = header.offsetHeight;
                btnMenu.style.top = `${headerHeight + 10}px`;
            };

            // Función para manejar visibilidad del sidebar en resize
            const handleResize = () => {
                const viewportWidth = document.documentElement.clientWidth;
                if (viewportWidth >= 950) {
                    sidebar.classList.remove('-translate-x-full');
                } else {
                    sidebar.classList.add('-translate-x-full');
                }
                positionMenuButton();
            };

            // Función para controlar scroll del botón
            const handleScroll = () => {
                const scrollY = window.scrollY || window.pageYOffset;
                const headerHeight = header.offsetHeight;
                const newTop = Math.max(headerHeight + 10 - scrollY, headerHeight + 10);
                btnMenu.style.top = `${newTop}px`;
            };

            // Click en el botón de menú
            btnMenu.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Cerrar sidebar al hacer clic fuera (modo móvil)
            document.addEventListener('click', (e) => {
                const viewportWidth = document.documentElement.clientWidth;

                if (!sidebar.contains(e.target) && !btnMenu.contains(e.target) && viewportWidth < 950) {
                    sidebar.classList.add('-translate-x-full');
                }
            });

            // Eventos globales
            window.addEventListener('resize', handleResize);
            window.addEventListener('scroll', handleScroll);

            // Estado inicial
            handleResize();
            positionMenuButton();
        });

        
    </script>

</body>
</html>
