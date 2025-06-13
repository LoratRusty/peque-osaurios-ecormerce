

<?php $__env->startSection('title', 'Tallas'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-5xl mx-auto p-6 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10" x-data="{ confirmId: null }">
        <div class="flex justify-between items-center mb-6">
            <a href="<?php echo e(route('admin.products.sizes.create')); ?>"
                class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-5 py-3 rounded-xl shadow-md hover:shadow-lg transition duration-300 font-semibold flex items-center gap-2">
                <i class="fas fa-plus"></i> Agregar Talla
            </a>
        </div>

        <table class="w-full table-auto border border-pink-200 rounded-xl overflow-hidden">
            <thead class="bg-pink-50 text-pink-700 font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Talla</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t border-pink-200 hover:bg-pink-50 transition duration-150">
                        <td class="px-6 py-4"><?php echo e($size->id); ?></td>
                        <td class="px-6 py-4 font-medium text-pink-600"><?php echo e($size->etiqueta); ?></td>
                        <td class="px-6 py-4 text-center space-x-4">
                            
                            <a href="<?php echo e(route('admin.products.sizes.edit', $size->id)); ?>"
                                class="inline-flex items-center px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50">
                                <i class="fas fa-edit mr-2"></i>Editar
                            </a>

                            
                            <div x-data="{ confirmId: null }" class="inline">
                                <button type="button" @click="confirmId = <?php echo e($size->id); ?>"
                                    class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                                    <i class="fas fa-trash-alt mr-2"></i>Eliminar
                                </button>

                                <form id="delete-<?php echo e($size->id); ?>"
                                    action="<?php echo e(route('admin.products.sizes.destroy', $size->id)); ?>"
                                    method="POST" class="hidden">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                </form>

                                <?php if (isset($component)) { $__componentOriginal1978ea6189800d3ead8e1d285a55da54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1978ea6189800d3ead8e1d285a55da54 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirm-delete-modal','data' => ['id' => $size->id,'title' => 'Confirmar eliminación de Talla','message' => '¿Estás seguro que deseas eliminar la Talla <strong>'.e($size->etiqueta).'</strong>?<br>Esta acción no se puede deshacer.','confirmIdVar' => 'confirmId','confirmText' => 'Sí, eliminar Talla','confirmColor' => 'red','formSelector' => '#delete-'.e($size->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirm-delete-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($size->id),'title' => 'Confirmar eliminación de Talla','message' => '¿Estás seguro que deseas eliminar la Talla <strong>'.e($size->etiqueta).'</strong>?<br>Esta acción no se puede deshacer.','confirmIdVar' => 'confirmId','confirmText' => 'Sí, eliminar Talla','confirmColor' => 'red','formSelector' => '#delete-'.e($size->id).'']); ?>
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
                        <td colspan="3" class="text-center py-8 text-pink-400 font-medium">
                            No hay tallas registradas.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        
        <?php if($sizes->hasPages()): ?>
            <div class="mt-6 px-4 py-3 flex items-center justify-between border-t border-gray-200 bg-white rounded-b-lg">
                <div class="text-sm text-gray-700">
                    Mostrando <?php echo e($sizes->firstItem()); ?> - <?php echo e($sizes->lastItem()); ?> de <?php echo e($sizes->total()); ?> Tallas
                </div>
                <div class="flex space-x-2">
                    
                    <?php if($sizes->onFirstPage()): ?>
                        <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Anterior</span>
                    <?php else: ?>
                        <a href="<?php echo e($sizes->previousPageUrl()); ?>" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Anterior</a>
                    <?php endif; ?>

                    
                    <?php if($sizes->hasMorePages()): ?>
                        <a href="<?php echo e($sizes->nextPageUrl()); ?>" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Siguiente</a>
                    <?php else: ?>
                        <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Siguiente</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/admin/sizes/index.blade.php ENDPATH**/ ?>