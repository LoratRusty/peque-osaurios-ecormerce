

<?php $__env->startSection('title', $categoria->id ? 'Editar Categoría' : 'Nueva Categoría'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-rose-50 py-10">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-3xl shadow-2xl border border-pink-100">
            <h1 class="text-2xl font-bold text-pink-600 mb-6 text-center flex items-center justify-center gap-2">
                <i class="fas fa-tags text-pink-400"></i>
                <?php echo e($categoria->id ? 'Editar Categoría' : 'Agregar Nueva Categoría'); ?>

            </h1>

            <form
                action="<?php echo e($categoria->id ? route('admin.products.categories.update', $categoria->id) : route('admin.products.categories.store')); ?>"
                method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php if($categoria->id): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>

                
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-600 mb-1">
                        Nombre de la categoría
                    </label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo e(old('nombre', $categoria->nombre)); ?>"
                        class="w-full px-4 py-3 border-2 border-pink-100 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition duration-200 bg-pink-50/20"
                        placeholder="Ej: Niñas" required>
                    <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="flex justify-between items-center mt-6">

                    <a href="<?php echo e(route('admin.products.categories.index')); ?>" class="ml-4 text-pink-500 hover:underline">
                        <i class="fas fa-arrow-left mr-2"></i>Volver a Categorías
                    </a>
                    <button type="submit"
                        class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg font-semibold">
                        <i class="fas fa-save mr-2"></i><?php echo e($categoria->id ? 'Actualizar' : 'Guardar'); ?>

                    </button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/admin/categories/create.blade.php ENDPATH**/ ?>