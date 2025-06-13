<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Pequeñosaurios</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" href="<?php echo e(asset('img/logo-pequeño.png')); ?>" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md mx-auto" data-aos="fade-up">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Encabezado -->
        <div class="bg-green-100 px-6 py-12 text-center">
            <a href="<?php echo e(url('/')); ?>" class="inline-flex items-center justify-center">
                <img class="h-16 w-16" src="<?php echo e(asset('img/logo-pequeño.png')); ?>" alt="Logo Pequeñosaurios">
                <span class="ml-3 text-4xl font-bold text-pink-600">Pequeñosaurios</span>
            </a>
        </div>

        <!-- Contenido del formulario -->
        <div class="px-6 py-8">
            <!-- Session Status -->
            <?php if(session('error')): ?>
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('status')): ?>
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>
            
            <h1 class="text-3xl font-bold text-pink-600 mb-6 text-center">Inicia sesión</h1>
            
            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-pink-700 font-semibold mb-1">Correo electrónico</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" required autofocus
                               class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Ingresa tu correo electrónico">
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

                <!-- Password -->
                <div>
                    <label for="password" class="block text-pink-700 font-semibold mb-1">Contraseña</label>
                    <div class="mt-1 relative">
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Ingresa tu contraseña">
                        <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-500 hover:text-pink-700">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>

                        <?php $__errorArgs = ['password'];
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

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox"
                           class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-pink-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-pink-700">Recuerdame</label>
                </div>

                <div class="flex items-center justify-between">
                    <?php if(Route::has('password.request')): ?>
                        <a href="<?php echo e(route('password.request')); ?>" class="text-sm text-pink-600 hover:text-pink-500">
                            ¿Olvidaste tu contraseña?
                        </a>
                    <?php endif; ?>

                    <button type="submit"
                            class="px-6 py-3 bg-pink-500 text-white font-medium rounded-lg hover:bg-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors">
                        Iniciar sesión
                    </button>
                </div>
            </form>

            <?php if(Route::has('register')): ?>
                <div class="mt-6 text-center">
                    <p class="text-sm text-pink-600">
                        ¿No tienes una cuenta?
                        <a href="<?php echo e(route('register')); ?>" class="font-medium text-pink-600 hover:text-pink-500">
                            Regístrate
                        </a>
                    </p>
                </div>
            <?php endif; ?>
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

    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');

        toggleBtn.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    });

</script>
</body>
</html><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/auth/login.blade.php ENDPATH**/ ?>