<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $__env->yieldContent('title', 'Panel Administración - Pequeñosaurios'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="icon" href="<?php echo e(asset('img/logo-pequeño.png')); ?>" type="image/x-icon" />
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Animaciones personalizadas */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease-out;
        }

        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }

        /* Efectos glassmorphism */
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Efectos de hover */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Gradientes personalizados */
        .gradient-pink {
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 50%, #fbcfe8 100%);
        }

        /* Estilos para filtros dinámicos */
        .filter-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            margin: 0.25rem;
            background: linear-gradient(135deg, #ec4899, #be185d);
            color: white;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .filter-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
        }

        .filter-badge.active {
            background: #be185d;
            box-shadow: 0 0 0 2px rgba(236, 72, 153, 0.3);
        }

        .filter-input {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .filter-input:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
            transform: translateY(-1px);
        }

        /* Estilos para el carrito */
        .cart-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Efectos de scroll suave */
        html {
            scroll-behavior: smooth;
        }

        /* Mejoras para mobile */
        @media (max-width: 768px) {
            .filter-container {
                padding: 1rem;
            }

            .filter-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
    </style>
</head>

<body class="gradient-bg text-gray-800 font-sans overflow-x-hidden min-h-screen flex flex-col">
    <div class="flex-grow">
        <header class="sticky top-0 z-50 glass-effect border-b border-pink-200 bg-white/60 backdrop-blur">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
                
                <a href="<?php echo e(route('cliente.store')); ?>" class="flex items-center space-x-2 hover-lift group">
                    <div class="relative">
                        <img src="<?php echo e(asset('img/logo-pequeño.png')); ?>" alt="Pequeñosaurios logo"
                            class="h-10 w-auto object-contain transition-transform group-hover:scale-110" />
                        <div
                            class="absolute inset-0 bg-pink-400 rounded-full blur-lg opacity-0 group-hover:opacity-20 transition-opacity">
                        </div>
                    </div>
                    <span
                        class="text-xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent hidden sm:inline">
                        Pequeñosaurios
                    </span>
                </a>

                
                <div class="hidden lg:flex items-center space-x-6">
                    <a href="<?php echo e(route('cliente.store')); ?>"
                        class="text-gray-700 hover:text-pink-600 text-sm font-medium transition-all duration-300 hover:scale-105 relative group">
                        Inicio
                    </a>                    
                    <a href="<?php echo e(route('profile.edit')); ?>"
                        class="text-gray-700 hover:text-pink-600 text-sm font-medium transition-all duration-300 hover:scale-105 relative group">
                        <i class="fas fa-user mr-2 text-pink-500"></i>Mi cuenta
                    </a>
                    <a href="<?php echo e(route('cliente.cart')); ?>"
                        class="text-gray-700 hover:text-pink-600 text-sm font-medium relative hover-lift group">
                        <div class="relative">
                            <i class="fas fa-shopping-cart text-lg transition-transform group-hover:scale-110"></i>
                            <span
                                class="absolute -top-2 -right-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white text-xs rounded-full px-1.5 py-0.5 cart-badge shadow-lg">
                                <?php echo e($cartCount ?? 0); ?>

                            </span>
                        </div>
                    </a>
                    <a href="<?php echo e(route('cliente.reviews')); ?>"
                        class="text-gray-700 hover:text-pink-600 text-sm font-medium transition-all duration-300 hover:scale-105 relative group">
                        Reseñas
                    </a>                    
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                            class="flex items-center text-sm text-red-600 hover:text-red-800 transition-all duration-300">
                            <i class="fas fa-sign-out-alt mr-2"></i>Cerrar sesión
                        </button>
                    </form>
                </div>

                
                <button id="mobile-menu-button"
                    class="lg:hidden text-gray-700 hover:text-pink-600 p-2 rounded-lg hover:bg-pink-50 transition-all duration-300">
                    <svg class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </nav>

            
            <div id="mobile-menu" class="hidden lg:hidden glass-effect border-t border-pink-200">
                <div class="px-4 pt-4 pb-6 space-y-3">
                    <a href="<?php echo e(route('cliente.store')); ?>"
                        class="flex items-center text-gray-700 hover:text-pink-600 text-base py-2 px-3 rounded-lg hover:bg-pink-50 transition-all duration-200">
                        <i class="fas fa-store mr-3 text-pink-500"></i>Inicio
                    </a>
                    <a href="<?php echo e(route('cliente.cart')); ?>"
                        class="flex items-center text-gray-700 hover:text-pink-600 text-base py-2 px-3 rounded-lg hover:bg-pink-50 transition-all duration-200">
                        <i class="fas fa-shopping-cart mr-3 text-pink-500"></i>Carrito
                        <span class="ml-auto bg-pink-500 text-white text-xs rounded-full px-2 py-1">
                            <?php echo e($cartCount ?? 0); ?>

                        </span>
                    </a>
                    <a href="<?php echo e(route('profile.edit')); ?>"
                        class="flex items-center text-gray-700 hover:text-pink-600 text-base py-2 px-3 rounded-lg hover:bg-pink-50 transition-all duration-200">
                        <i class="fas fa-user-edit mr-3 text-pink-500"></i>Mi perfil
                    </a>
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                            class="w-full flex items-center text-left text-red-600 hover:bg-red-50 py-2 px-3 rounded-lg text-base transition-all duration-200">
                            <i class="fas fa-sign-out-alt mr-3"></i>Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </header>


        
        <main class="py-8">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
        <div id="toast-container"></div>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-pink-600 to-purple-600 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center md:text-left">
                    <h3 class="text-xl font-bold mb-4">Pequeñosaurios</h3>
                    <p class="text-white-400 text-sm">Ropa infantil para pequeños exploradores</p>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                    <ul class="space-y-2 text-white-400 text-sm">
                        <li><i class="fas fa-phone mr-2"></i>(+58) 412-9452563</li>
                        <li><i class="fas fa-envelope mr-2"></i>info@pequenosaurios.com</li>
                    </ul>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="text-lg font-semibold mb-4">Enlaces</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" onclick="showPoliticas(event)"
                                class="text-white-400 hover:text-white cursor-pointer">Políticas de devolución</a></li>
                        <li><a href="#" onclick="showFAQ(event)"
                                class="text-white-400 hover:text-white cursor-pointer">Preguntas frecuentes</a></li>
                    </ul>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="text-lg font-semibold mb-4">Síguenos</h4>
                    <div class="flex justify-center md:justify-start space-x-4">
                        <a href="#" class="text-white-400 hover:text-pink-500"><i
                                class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white-400 hover:text-pink-500"><i
                                class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white-400 hover:text-pink-500"><i
                                class="fab fa-tiktok fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white-700 mt-8 pt-8 mb-8 text-center text-white-400 text-sm">
                &copy; 2025 Pequeñosaurios. Todos los derechos reservados
            </div>
        </div>
    </footer>

    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            <?php if(session('success')): ?>
                showToast("<?php echo e(session('success')); ?>", 'success');
            <?php endif; ?>

            <?php if(session('error')): ?>
                showToast("<?php echo e(session('error')); ?>", 'error');
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    showToast("<?php echo e($error); ?>", 'error');
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        });
        // Toggle del menú móvil
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');

            // Animar el icono
            const icon = this.querySelector('svg');
            icon.style.transform = menu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(90deg)';
        });

        // Efectos de scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.classList.add('shadow-lg');
            } else {
                header.classList.remove('shadow-lg');
            }
        });

        // Animaciones AOS (si está disponible)
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 600,
                easing: 'ease-in-out',
                once: true
            });
        }

        function showPoliticas(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Políticas de Devolución',
                html: `
                    <div class="text-left space-y-4">
                        <h3 class="text-lg font-bold text-gray-800">Condiciones generales:</h3>
                        <ul class="list-disc pl-5 text-gray-600">
                            <li>Plazo máximo de 15 días para devoluciones</li>
                            <li>Producto debe estar en su empaque original</li>
                            <li>Etiquetas y sellos intactos</li>
                            <li>Recibo de compra obligatorio</li>
                        </ul>
                        
                        <h3 class="text-lg font-bold text-gray-800 mt-4">Proceso:</h3>
                        <ol class="list-decimal pl-5 text-gray-600">
                            <li>Contactar a nuestro servicio al cliente</li>
                            <li>Enviar producto a nuestra dirección</li>
                            <li>Inspección del producto (3-5 días hábiles)</li>
                            <li>Reembolso o reposición</li>
                        </ol>
                    </div>
                `,
                width: '800px',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#ec4899'
            });
        }

        function showFAQ(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Preguntas Frecuentes',
                html: `
                    <div class="text-left space-y-4">
                        <div class="border-b pb-2">
                            <h3 class="font-semibold text-gray-800">¿Cuánto tarda el envío?</h3>
                            <p class="text-gray-600 mt-1">Entre 3-5 días hábiles en área metropolitana</p>
                        </div>
                        
                        <div class="border-b pb-2">
                            <h3 class="font-semibold text-gray-800">¿Hacen envíos internacionales?</h3>
                            <p class="text-gray-600 mt-1">Actualmente solo servimos territorio nacional</p>
                        </div>
                        
                        <div class="border-b pb-2">
                            <h3 class="font-semibold text-gray-800">¿Cómo saber mi talla?</h3>
                            <p class="text-gray-600 mt-1">Consulta nuestra guía de tallas en descripción de productos</p>
                        </div>
                        
                        <div class="border-b pb-2">
                            <h3 class="font-semibold text-gray-800">¿Aceptan pagos en divisas?</h3>
                            <p class="text-gray-600 mt-1">Solo aceptamos pagos en Bolívares y USD a tasa BCV</p>
                        </div>
                    </div>
                `,
                width: '700px',
                confirmButtonText: 'Cerrar',
                confirmButtonColor: '#ec4899'
            });
        }
    </script>
</body>

</html>
<?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/layouts/cliente.blade.php ENDPATH**/ ?>