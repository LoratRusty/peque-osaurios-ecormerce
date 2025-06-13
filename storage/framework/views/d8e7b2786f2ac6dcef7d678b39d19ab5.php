<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <title><?php echo e(config('app.name', 'Pequeñosaurios')); ?></title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="icon" href="<?php echo e(asset('img/logo-pequeño.png')); ?>" type="image/x-icon" />
</head>
<body class="font-sans text-gray-800 antialiased bg-pink-50 min-h-screen flex flex-col items-center pt-6">

    
    <div>
        <a href="/">
            <img src="<?php echo e(asset('img/logo-pequeño.png')); ?>" alt="Pequeñosaurios Logo" class="h-20 w-auto" />
        </a>
    </div>

    
    <?php if(View::hasSection('header')): ?>
        <header class="w-full max-w-xl mt-6 px-6 py-4 bg-green-100 rounded-xl shadow-md border border-green-200">
            <h2 class="text-xl font-semibold text-green-700 text-center">
                <?php echo $__env->yieldContent('header'); ?>
            </h2>
        </header>
    <?php endif; ?>

    
    <main class="w-full max-w-xl mt-6 px-6 py-8 bg-white shadow-lg border border-blue-200 rounded-2xl">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

</body>
</html>
<?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/layouts/profile-layout.blade.php ENDPATH**/ ?>