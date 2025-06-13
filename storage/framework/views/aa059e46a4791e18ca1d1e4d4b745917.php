

<?php $__env->startSection('title', 'Categorías'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-5xl mx-auto p-6 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10" x-data="{ confirmId: null }">
        <div class="flex justify-between items-center mb-6">
            <a href="<?php echo e(route('admin.products.categories.create')); ?>"
                class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-5 py-3 rounded-xl shadow-md hover:shadow-lg transition duration-300 font-semibold flex items-center gap-2">
                <i class="fas fa-plus"></i> Agregar Categoría
            </a>
        </div>

        <table class="w-full table-auto border border-pink-200 rounded-xl overflow-hidden">
            <thead class="bg-pink-50 text-pink-700 font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-t border-pink-200 hover:bg-pink-50 transition duration-150">
                        <td class="px-6 py-4"><?php echo e($categoria->id); ?></td>
                        <td class="px-6 py-4 font-medium text-pink-600"><?php echo e($categoria->nombre); ?></td>
                        <td class="px-6 py-4 text-center space-x-4">

                            
                            <a href="<?php echo e(route('admin.products.categories.edit', $categoria->id)); ?>"
                                class="inline-flex items-center px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Editar
                            </a>

                            
                            <button type="button" @click="confirmId = <?php echo e($categoria->id); ?>"
                                class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50"
                                aria-label="Eliminar categoría <?php echo e($categoria->nombre); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Eliminar
                            </button>

                            
                            <form id="delete-<?php echo e($categoria->id); ?>"
                                action="<?php echo e(route('admin.products.categories.destroy', $categoria->id)); ?>" method="POST"
                                class="hidden">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                            </form>

                            
                            <?php if (isset($component)) { $__componentOriginal1978ea6189800d3ead8e1d285a55da54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1978ea6189800d3ead8e1d285a55da54 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirm-delete-modal','data' => ['id' => $categoria->id,'title' => '¿Eliminar categoría?','message' => '¿Estás seguro que deseas eliminar la categoría <strong>'.e($categoria->nombre).'</strong>? <br> Esta acción no se puede deshacer.','confirmIdVar' => 'confirmId','confirmText' => 'Sí, eliminar categoría','formSelector' => '#delete-'.e($categoria->id).'','titleColor' => 'text-red-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirm-delete-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categoria->id),'title' => '¿Eliminar categoría?','message' => '¿Estás seguro que deseas eliminar la categoría <strong>'.e($categoria->nombre).'</strong>? <br> Esta acción no se puede deshacer.','confirmIdVar' => 'confirmId','confirmText' => 'Sí, eliminar categoría','formSelector' => '#delete-'.e($categoria->id).'','titleColor' => 'text-red-600']); ?>
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
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="text-center py-8 text-pink-400 font-medium">
                            No hay categorías registradas.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
                
        <?php if($categorias->hasPages()): ?>
            <div class="mt-6 px-4 py-3 flex items-center justify-between border-t border-gray-200 bg-white rounded-b-lg">
                <div class="text-sm text-gray-700">
                    Mostrando <?php echo e($categorias->firstItem()); ?> - <?php echo e($categorias->lastItem()); ?> de <?php echo e($categorias->total()); ?> Categorias
                </div>
                <div class="flex space-x-2">
                    
                    <?php if($categorias->onFirstPage()): ?>
                        <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Anterior</span>
                    <?php else: ?>
                        <a href="<?php echo e($categorias->previousPageUrl()); ?>" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Anterior</a>
                    <?php endif; ?>

                    
                    <?php if($categorias->hasMorePages()): ?>
                        <a href="<?php echo e($categorias->nextPageUrl()); ?>" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Siguiente</a>
                    <?php else: ?>
                        <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Siguiente</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>