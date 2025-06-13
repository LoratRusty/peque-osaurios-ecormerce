<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pequeñosaurios - Ropa Infantil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-pink-50 text-gray-800 font-sans overflow-x-hidden">

    <!-- Header Mobile First -->
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex-shrink-0 flex items-center">
                    <img class="h-12 w-12" src="https://cdn-icons-png.flaticon.com/512/1962/1962735.png" alt="Logo">
                    <span class="ml-2 text-xl font-bold text-pink-600">Pequeñosaurios</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex space-x-8">
                    <a href="#productos" class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium">Productos</a>
                    <a href="#nosotros" class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium">Nosotros</a>
                    <a href="#contacto" class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium">Contacto</a>
                    <a href="/login" class="ml-4 px-6 py-2 bg-pink-500 text-white rounded-full hover:bg-pink-600 text-sm font-medium">
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
                <a href="/login" class="block w-full text-center mt-2 px-6 py-2 bg-pink-500 text-white rounded-full hover:bg-pink-600 text-base font-medium">
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
                        Ropa infantil que 
                        <span class="text-pink-500 block md:inline">ama el juego</span>
                    </h1>
                    <p class="text-lg text-gray-600 max-w-md mx-auto md:mx-0">
                        Diseños únicos para pequeños exploradores de 8 meses a 8 años
                    </p>
                    <a href="#productos" class="inline-block px-6 py-3 sm:px-8 sm:py-4 bg-green-400 text-white rounded-full text-base font-semibold hover:bg-green-500 transform transition duration-300 hover:scale-105">
                        Descubre nuestra colección
                    </a>
                </div>
                <div class="md:w-1/2 mt-8 md:mt-0" data-aos="fade-left">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl aspect-w-16 aspect-h-9">
                        <img src="https://images.unsplash.com/photo-1604917018137-344b3dd96077?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
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
                        <img src="https://images.unsplash.com/photo-1615381569910-8a7da21872e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80" 
                             alt="Taller de diseño" 
                             class="rounded-lg object-cover w-full h-full shadow-lg">
                    </div>
                    <div class="relative aspect-square mt-8">
                        <img src="https://images.unsplash.com/photo-1620799139652-715e4d5b232d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1972&q=80" 
                             alt="Materiales naturales" 
                             class="rounded-lg object-cover w-full h-full shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos Optimizado -->
    <section id="productos" class="py-12 md:py-24 bg-pink-50" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-8 md:mb-16 text-gray-800">Nueva Colección</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Product Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="aspect-square relative">
                        <img src="https://images.unsplash.com/photo-1599443015574-be5fe8a05783?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                             alt="Conjunto infantil" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Conjunto Dinosaurio</h3>
                        <p class="text-gray-600 mt-2 text-sm sm:text-base">Talla: 2-4 años</p>
                        <div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-3">
                            <span class="text-lg sm:text-xl font-bold text-pink-600">$24.99</span>
                            <button class="w-full sm:w-auto px-4 py-2 bg-green-400 text-white rounded-full hover:bg-green-500 text-sm sm:text-base">
                                <i class="fas fa-cart-plus mr-2"></i>Agregar
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Repetir más productos -->
            </div>
        </div>
    </section>

    <!-- Contacto Responsive -->
    <section id="contacto" class="py-12 md:py-24 bg-white" data-aos="fade-up">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Contáctanos</h2>
                <p class="text-gray-600 mt-2 md:mt-4">¿Tienes preguntas? Escríbenos</p>
            </div>
            <form class="space-y-4 sm:space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-sm sm:text-base text-gray-700 mb-2">Nombre</label>
                        <input type="text" name="nombre" required
                               class="w-full px-4 py-2 sm:py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm sm:text-base">
                    </div>
                    <div>
                        <label class="block text-sm sm:text-base text-gray-700 mb-2">Email</label>
                        <input type="email"  name="email" required
                               class="w-full px-4 py-2 sm:py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm sm:text-base">
                    </div>
                </div>
                <div>
                    <label class="block text-sm sm:text-base text-gray-700 mb-2">Mensaje</label>
                    <textarea rows="4" required 
                              class="w-full px-4 py-2 sm:py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm sm:text-base" name="mensaje"></textarea>
                </div>
                <button type="submit" 
                        class="w-full py-3 sm:py-4 bg-pink-500 text-white rounded-full font-semibold hover:bg-pink-600 text-sm sm:text-base transition-colors">
                    Enviar mensaje
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
                        <li><i class="fas fa-phone mr-2"></i>+1 234 567 890</li>
                        <li><i class="fas fa-envelope mr-2"></i>hola@pequenosaurios.com</li>
                    </ul>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="text-lg font-semibold mb-4">Enlaces</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-white">Políticas de devolución</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Preguntas frecuentes</a></li>
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
                &copy; 2024 Pequeñosaurios. Todos los derechos reservados
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      // Inicializar AOS
      AOS.init({
        duration: 1000,
        easing: 'ease-out-quad',
        once: true,
        offset: 100,
        disable: window.innerWidth < 768
      });

      // Menú móvil
      const mobileMenuButton = document.getElementById('mobile-menu-button');
      const mobileMenu = document.getElementById('mobile-menu');

      mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });

      // Cerrar menú al hacer click fuera
      document.addEventListener('click', (event) => {
        if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
          mobileMenu.classList.add('hidden');
        }
      });
    </script>
</body>
</html>