

<?php $__env->startSection('title', $payment->id ? 'Editar Método de Pago' : 'Agregar Método de Pago'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-rose-50 py-10">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-3xl shadow-2xl border border-pink-100">
            <h1 class="text-2xl font-bold text-pink-600 mb-6 text-center flex items-center justify-center gap-2">
                <i class="fas fa-credit-card text-pink-400"></i>
                <?php echo e($payment->id ? 'Editar Método de Pago' : 'Agregar Nuevo Método de Pago'); ?>

            </h1>

            <form 
                action="<?php echo e($payment->id ? route('admin.payments.update', $payment->id) : route('admin.payments.store')); ?>" 
                method="POST" 
                class="space-y-6"
            >
                <?php echo csrf_field(); ?>
                <?php if($payment->id): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>

                
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-600 mb-1">
                        Nombre del método de pago
                    </label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="<?php echo e(old('nombre', $payment->nombre)); ?>"
                        class="w-full px-4 py-3 border-2 border-pink-100 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition duration-200 bg-pink-50/20"
                        placeholder="Ej: Tarjeta de crédito"
                        required
                    >
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

                
                <div>
                    <label for="descripcion" class="block text-sm font-semibold text-gray-600 mb-1">
                        Descripción (opcional)
                    </label>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="4"
                        maxlength="1000"
                        class="w-full px-4 py-3 border-2 border-pink-100 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition duration-200 bg-pink-50/20"
                        placeholder="Descripción del método de pago"
                    ><?php echo e(old('descripcion', $payment->descripcion)); ?></textarea>
                    <?php $__errorArgs = ['descripcion'];
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

                
                <div class="flex items-center space-x-3">
                    <label for="status" class="block text-sm font-semibold text-gray-600">
                        Activo:
                    </label>
                    <input 
                        type="checkbox" 
                        id="status" 
                        name="status" 
                        value="1" 
                        <?php echo e(old('status', $payment->status) ? 'checked' : ''); ?>

                        class="w-5 h-5 rounded border-pink-300 text-pink-600 focus:ring-pink-500"
                    >
                    <?php $__errorArgs = ['status'];
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
                    <a href="<?php echo e(route('admin.payments')); ?>" class="ml-4 text-pink-500 hover:underline flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Volver a Métodos de Pago
                    </a>
                    <button type="submit"
                        class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg font-semibold flex items-center gap-2">
                        <i class="fas fa-save"></i> <?php echo e($payment->id ? 'Actualizar' : 'Guardar'); ?>

                    </button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/admin/payments/create.blade.php ENDPATH**/ ?>