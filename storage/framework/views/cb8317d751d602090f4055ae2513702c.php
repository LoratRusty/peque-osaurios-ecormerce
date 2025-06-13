

<?php $__env->startSection('title', 'Métodos de Pago'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto p-6 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10" x-data="{ confirmId: null }">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-pink-700">Listado de Métodos de Pago</h2>
        <a href="<?php echo e(route('admin.payments.create')); ?>"
           class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-5 py-3 rounded-xl shadow-md hover:shadow-lg transition duration-300 font-semibold flex items-center gap-2">
            <i class="fas fa-plus"></i> Agregar
        </a>
    </div>

    <div class="overflow-x-auto rounded-xl border border-pink-100">
        <table class="w-full text-sm text-left">
            <thead class="bg-pink-50 text-pink-700 font-semibold">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Nombre</th>
                    <th class="px-6 py-3">Descripción</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t border-pink-100 hover:bg-pink-50 transition duration-150">
                        <td class="px-6 py-4"><?php echo e($payment->id); ?></td>
                        <td class="px-6 py-4 font-medium text-pink-600"><?php echo e($payment->nombre); ?></td>
                        <td class="px-6 py-4 text-gray-700"><?php echo e($payment->descripcion ?? '—'); ?></td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center gap-2">

                                
                                <a href="<?php echo e(route('admin.payments.edit', $payment->id)); ?>"
                                   class="inline-flex items-center px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition font-medium">
                                    <i class="fas fa-edit mr-1"></i> Editar
                                </a>

                                
                                <button type="button" @click="confirmId = <?php echo e($payment->id); ?>"
                                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-medium">
                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                </button>

                                
                                <form id="delete-<?php echo e($payment->id); ?>"
                                      action="<?php echo e(route('admin.payments.destroy', $payment->id)); ?>"
                                      method="POST" class="hidden">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                </form>

                                
                                <?php if (isset($component)) { $__componentOriginal1978ea6189800d3ead8e1d285a55da54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1978ea6189800d3ead8e1d285a55da54 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirm-delete-modal','data' => ['id' => $payment->id,'title' => '¿Eliminar método de pago?','message' => '¿Estás seguro de que deseas eliminar <strong>'.e($payment->nombre).'</strong>? Esta acción no se puede deshacer.','confirmIdVar' => 'confirmId','confirmText' => 'Sí, eliminar','formSelector' => '#delete-'.e($payment->id).'','titleColor' => 'text-red-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirm-delete-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($payment->id),'title' => '¿Eliminar método de pago?','message' => '¿Estás seguro de que deseas eliminar <strong>'.e($payment->nombre).'</strong>? Esta acción no se puede deshacer.','confirmIdVar' => 'confirmId','confirmText' => 'Sí, eliminar','formSelector' => '#delete-'.e($payment->id).'','titleColor' => 'text-red-600']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1978ea6189800d3ead8e1d285a55da54)): ?>
<?php $attributes = $__attributesOriginal1978ea6189800d3ead8e1d285a55da54; ?>
<?php unset($__attributesOriginal1978ea6189800d3ead8e1d285a55da54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1978ea6189800d3ead8e1d285a55da54)): ?>
<?php $component = $__componentOriginal1978ea6189800d3ead8e1d285a55da54; ?>
<?php unset($__componentOriginal1978ea6189800d3ead8e1d285a55da54); ?>
<?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center py-10 text-pink-400 font-medium">
                            No hay métodos de pago registrados aún.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <?php if($payments->hasPages()): ?>
        <div class="mt-6 flex justify-between items-center text-sm text-gray-600">
            <span>
                Mostrando <?php echo e($payments->firstItem()); ?> – <?php echo e($payments->lastItem()); ?> de <?php echo e($payments->total()); ?> resultados
            </span>
            <div class="space-x-2">
                <?php if($payments->onFirstPage()): ?>
                    <span class="px-3 py-1 border border-gray-300 text-gray-400 rounded cursor-not-allowed">Anterior</span>
                <?php else: ?>
                    <a href="<?php echo e($payments->previousPageUrl()); ?>" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Anterior</a>
                <?php endif; ?>

                <?php if($payments->hasMorePages()): ?>
                    <a href="<?php echo e($payments->nextPageUrl()); ?>" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Siguiente</a>
                <?php else: ?>
                    <span class="px-3 py-1 border border-gray-300 text-gray-400 rounded cursor-not-allowed">Siguiente</span>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/admin/payments/index.blade.php ENDPATH**/ ?>