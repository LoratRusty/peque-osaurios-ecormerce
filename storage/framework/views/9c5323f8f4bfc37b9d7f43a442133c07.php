<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Pequeñosaurios</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="<?php echo e(asset('img/logo-pequeño.png')); ?>" type="image/x-icon">
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md mx-auto" data-aos="fade-up">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Encabezado -->
        <div class="bg-green-100 px-6 py-8 text-center">
            <a href="/" class="inline-flex items-center">
                <img class="h-12 w-12" src="<?php echo e(asset('img/logo-pequeño.png')); ?>" alt="Logo Pequeñosaurios">
                <span class="ml-2 text-2xl font-bold text-pink-600">Pequeñosaurios</span>
            </a>
            <h1 class="mt-4 text-xl font-semibold text-gray-800">Recuperar Contraseña</h1>
        </div>

        <!-- Contenido del formulario -->
        <div class="px-6 py-8">
            <?php if(session('status')): ?>
                <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <p class="mb-6 text-sm text-gray-600">
                ¿Olvidaste tu contraseña? Ingresa tu correo electrónico y te enviaremos un enlace para restablecerla.
            </p>

            <form method="POST" action="<?php echo e(route('password.email')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autofocus
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="<?php echo e(route('login')); ?>" class="text-sm text-pink-600 hover:text-pink-500">
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
</html><?php /**PATH C:\xampp-actual\htdocs\pequesaurios-lavarel\pequenoasurios\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>