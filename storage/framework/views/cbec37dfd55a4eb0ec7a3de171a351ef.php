<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pequeñosaurios - Ropa Infantil</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 para notificaciones -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" href="<?php echo e(asset('img/logo-pequeño.png')); ?>" type="image/x-icon">
</head>
<body class="bg-pink-50 text-gray-800 font-sans overflow-x-hidden">

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 space-y-4 z-50"></div>

    <!-- Header Mobile First -->
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
               <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-2">
                    <img 
                        src="<?php echo e(asset('img/logo-pequeño.png')); ?>" 
                        alt="Pequeñoasurios logo" 
                        class="h-12 w-auto object-contain"
                    />
                    <span class="text-xl font-bold text-pink-600 hidden sm:inline">Pequeñoasurios</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex space-x-8">
                    <a href="#productos" class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium">Productos</a>
                    <a href="#nosotros" class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium">Nosotros</a>
                    <a href="#contacto" class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium">Contacto</a>
                    <a href="<?php echo e(Route('login')); ?>" class="ml-4 px-6 py-2 bg-pink-500 text-white rounded-full hover:bg-pink-600 text-sm font-medium">
                        Ingresar
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="lg:hidden p-2 text-gray-700 hover:text-pink-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden hidden absolute w-full bg-white shadow-lg">
            <div class="px-4 pt-2 pb-3 space-y-1">
                <a href="#productos" class="text-gray-700 hover:text-pink-600 block px-3 py-2 text-base font-medium">Productos</a>
                <a href="#nosotros" class="text-gray-700 hover:text-pink-600 block px-3 py-2 text-base font-medium">Nosotros</a>
                <a href="#contacto" class="text-gray-700 hover:text-pink-600 block px-3 py-2 text-base font-medium">Contacto</a>
                <a href="<?php echo e(Route('login')); ?>" class="block w-full text-center mt-2 px-6 py-2 bg-pink-500 text-white rounded-full hover:bg-pink-600 text-base font-medium">
                    Ingresar
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section Optimizada -->
    <section class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-24">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="md:w-1/2 space-y-6 text-center md:text-left" data-aos="fade-right">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 leading-tight">
                        Ropa hecha con amor para 
                        <span class="text-pink-500 block md:inline">niños felices</span>
                    </h1>
                    <p class="text-lg text-gray-600 max-w-md mx-auto md:mx-0 mt-2">
                        Prendas suaves, seguras y llenas de color para acompañar cada aventura
                    </p>
                    <a href="#productos" class="inline-block px-6 py-3 sm:px-8 sm:py-4 bg-green-400 text-white rounded-full text-base font-semibold hover:bg-green-500 transform transition duration-300 hover:scale-105">
                        Descubre nuestra colección
                    </a>
                </div>
                <div class="md:w-1/2 mt-8 md:mt-0" data-aos="fade-left">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-w-16 aspect-h-9">
                        <img src="<?php echo e(asset('img/image0.png')); ?>" 
                             alt="Niños jugando" 
                             class="object-cover w-full h-full">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Nosotros Responsive -->
    <section id="nosotros" class="bg-white py-12 md:py-24" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8 md:gap-16">
                <div class="md:w-1/2 space-y-6 order-2 md:order-1">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Nuestra historia</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Somos una marca familiar comprometida con crear ropa que combine comodidad, estilo y durabilidad. Cada prenda está diseñada pensando en la libertad de movimiento y la imaginación de tus pequeños.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-pink-50 rounded-lg">
                            <h3 class="text-pink-600 font-bold text-lg">100% Algodón</h3>
                            <p class="text-gray-600 text-sm">Materiales suaves y naturales</p>
                        </div>
                        <div class="p-4 bg-green-50 rounded-lg">
                            <h3 class="text-green-600 font-bold text-lg">Diseño único</h3>
                            <p class="text-gray-600 text-sm">Estampados exclusivos</p>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/2 grid grid-cols-2 gap-4 order-1 md:order-2">
                    <div class="relative aspect-square">
                        <img src="<?php echo e(asset('img/image1.png')); ?>" 
                             alt="Taller de diseño" 
                             class="rounded-lg object-cover w-full h-full shadow-lg">
                    </div>
                    <div class="relative aspect-square mt-8">
                        <img src="<?php echo e(asset('img/image2.png')); ?>" 
                             alt="Materiales naturales" 
                             class="rounded-lg object-cover w-full h-full shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos Optimizado -->
    <section id="productos" class="py-12 md:py-24 bg-pink-50" data-aos="fade-left">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-8 md:mb-16 text-gray-800">Nueva Colección</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Product Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="aspect-square relative">
                        <img src="<?php echo e(asset('img/image3.png')); ?>" 
                            alt="Conjunto infantil" 
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Conjunto Dinosaurio</h3>
                        <p class="text-gray-600 mt-2 text-sm sm:text-base">Talla: 2-4 años</p>
                        <div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-3">
                            <span class="text-lg sm:text-xl font-bold text-pink-600">$24.99</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="aspect-square relative">
                        <img src="<?php echo e(asset('img/image4.png')); ?>" 
                            alt="Vestido primavera" 
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Vestido Primavera</h3>
                        <p class="text-gray-600 mt-2 text-sm sm:text-base">Talla: 3-5 años</p>
                        <div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-3">
                            <span class="text-lg sm:text-xl font-bold text-pink-600">$29.99</span>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="aspect-square relative">
                        <img src="<?php echo e(asset('img/image5.png')); ?>" 
                            alt="Conjunto deportivo" 
                            class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Conjunto Deportivo</h3>
                        <p class="text-gray-600 mt-2 text-sm sm:text-base">Talla: 4-6 años</p>
                        <div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-3">
                            <span class="text-lg sm:text-xl font-bold text-pink-600">$34.99</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Sección de Contacto -->
    <section id="contacto" class="py-12 md:py-24 bg-white" data-aos="fade-rigth">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Contáctanos</h2>
                <p class="text-gray-600 mt-2 md:mt-4">¿Tienes preguntas? Escríbenos</p>
            </div>
            
            <?php if($errors->any()): ?>
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Hay errores en el formulario</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form id="contact-form" method="POST" action="<?php echo e(route('contact.send')); ?>" class="space-y-4 sm:space-y-6">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="name" class="block text-sm sm:text-base text-gray-700 mb-2">Nombre *</label>
                        <input type="text" 
                            id="name"
                            name="name"
                            value="<?php echo e(old('name')); ?>"
                            required
                            class="w-full px-4 py-2 sm:py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm sm:text-base">
                        <div id="name-error" class="mt-1 text-sm text-red-600 hidden"></div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm sm:text-base text-gray-700 mb-2">Email *</label>
                        <input type="email" 
                            id="email"
                            name="email"
                            value="<?php echo e(old('email')); ?>"
                            required
                            class="w-full px-4 py-2 sm:py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm sm:text-base">
                        <div id="email-error" class="mt-1 text-sm text-red-600 hidden"></div>
                    </div>
                </div>
                <div>
                    <label for="message" class="block text-sm sm:text-base text-gray-700 mb-2">Mensaje *</label>
                    <textarea rows="4" 
                            id="message"
                            name="message"
                            required
                            class="w-full px-4 py-2 sm:py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm sm:text-base"><?php echo e(old('message')); ?></textarea>
                    <div id="message-error" class="mt-1 text-sm text-red-600 hidden"></div>
                </div>
                <button type="submit" 
                        id="submit-btn"
                        class="w-full py-3 sm:py-4 bg-pink-500 text-white rounded-full font-semibold hover:bg-pink-600 text-sm sm:text-base transition-colors flex items-center justify-center">
                    <span id="btn-text">Enviar mensaje</span>
                    <div id="btn-spinner" class="hidden ml-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </button>
            </form>
        </div>
    </section>

    <!-- Footer Responsive -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center md:text-left">
                    <h3 class="text-xl font-bold mb-4">Pequeñosaurios</h3>
                    <p class="text-gray-400 text-sm">Ropa infantil para pequeños exploradores</p>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><i class="fas fa-phone mr-2"></i>(+58) 412-9452563</li>
                        <li><i class="fas fa-envelope mr-2"></i>info@pequenosaurios.com</li>
                    </ul>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="text-lg font-semibold mb-4">Enlaces</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" onclick="showPoliticas(event)" class="text-gray-400 hover:text-white cursor-pointer">Políticas de devolución</a></li>
                        <li><a href="#" onclick="showFAQ(event)" class="text-gray-400 hover:text-white cursor-pointer">Preguntas frecuentes</a></li>
                    </ul>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="text-lg font-semibold mb-4">Síguenos</h4>
                    <div class="flex justify-center md:justify-start space-x-4">
                        <a href="#" class="text-gray-400 hover:text-pink-500"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-pink-500"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-pink-500"><i class="fab fa-tiktok fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
                &copy; 2025 Pequeñosaurios. Todos los derechos reservados
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Inicializar AOS
        AOS.init({
            duration: 1000,
            easing: 'ease-out-quad',
            once: true,
            offset: 100,
            disable: window.innerWidth < 768
        });

        // Manejo del formulario
        document.getElementById('contact-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const form = e.target;
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const spinner = document.getElementById('btn-spinner');
            
            // Resetear errores previos
            document.querySelectorAll('[id$="-error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
            
            submitBtn.disabled = true;
            btnText.textContent = 'Enviando...';
            spinner.classList.remove('hidden');
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new FormData(form)
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Mensaje enviado!',
                        text: 'Nos pondremos en contacto contigo pronto',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    form.reset();
                } else {
                    // Mostrar errores de validación
                    if (data.errors) {
                        Object.entries(data.errors).forEach(([field, messages]) => {
                            const errorElement = document.getElementById(`${field}-error`);
                            if (errorElement) {
                                errorElement.textContent = messages[0];
                                errorElement.classList.remove('hidden');
                                // Resaltar el campo con error
                                const inputElement = document.getElementById(field);
                                if (inputElement) {
                                    inputElement.classList.add('border-red-500');
                                    inputElement.addEventListener('input', function clearError() {
                                        inputElement.classList.remove('border-red-500');
                                        errorElement.classList.add('hidden');
                                        inputElement.removeEventListener('input', clearError);
                                    });
                                }
                            }
                        });
                    } else {
                        throw new Error(data.message || 'Error al enviar el mensaje');
                    }
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Ocurrió un error inesperado',
                    showConfirmButton: false,
                    timer: 3000
                });
            } finally {
                submitBtn.disabled = false;
                btnText.textContent = 'Enviar mensaje';
                spinner.classList.add('hidden');
            }
        });

        // Limpiar errores al escribir
        document.querySelectorAll('#contact-form input, #contact-form textarea').forEach(input => {
            input.addEventListener('input', function() {
                if (this.classList.contains('border-red-500')) {
                    this.classList.remove('border-red-500');
                    const errorElement = document.getElementById(`${this.id}-error`);
                    if (errorElement) {
                        errorElement.classList.add('hidden');
                    }
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            menuButton.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
<!-- Agrega este script al final del archivo -->
<script>
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
<div id="modal-container"></div>
</body>
</html><?php /**PATH C:\xampp-actual\htdocs\pequesaurios-lavarel\pequenoasurios\resources\views/landing.blade.php ENDPATH**/ ?>