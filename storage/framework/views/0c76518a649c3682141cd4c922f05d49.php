

<?php $__env->startSection('title', 'Carrito de compras'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto px-4 py-8" x-data="{ showModal: false, itemToDelete: null }">
    <h1 class="text-3xl font-bold mb-6 text-pink-700">Tu carrito de compras</h1>

    <?php if($cartItems->isEmpty()): ?>
        <p class="text-gray-600 text-lg">Tu carrito está vacío.</p>
        <a href="<?php echo e(route('cliente.store')); ?>" 
           class="inline-block mt-4 px-6 py-3 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition">
           Ir a la tienda
        </a>
    <?php else: ?>
        <div class="overflow-x-auto shadow rounded-lg border border-pink-100">
            <table class="min-w-full bg-white rounded-md divide-y divide-gray-200">
                <thead class="bg-pink-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-pink-700 uppercase">Producto</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-pink-700 uppercase">Talla</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-pink-700 uppercase">Cantidad</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-pink-700 uppercase">Precio unitario</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-pink-700 uppercase">Subtotal</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-pink-700 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap flex items-center space-x-4">
                                <?php if($item->product && $item->product->imagen): ?>
                                    <img src="<?php echo e(asset('storage/' . $item->product->imagen)); ?>" alt="<?php echo e($item->product->nombre); ?>" class="w-16 h-16 object-cover rounded-md">
                                <?php else: ?>
                                    <div class="w-16 h-16 bg-pink-100 rounded-md flex items-center justify-center text-pink-300 text-sm">
                                        Sin imagen
                                    </div>
                                <?php endif; ?>
                                <span class="text-gray-800 font-medium">
                                    <?php echo e($item->product->nombre ?? 'Producto eliminado'); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-gray-700">
                                <?php echo e($item->size?->etiqueta ?? '—'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-gray-700">
                                <?php echo e($item->cantidad); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-gray-700">
                                $<?php echo e(number_format($item->precio_unitario, 2)); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right font-semibold text-pink-600">
                                $<?php echo e(number_format($item->cantidad * $item->precio_unitario, 2)); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button 
                                    @click="itemToDelete = <?php echo e($item->id); ?>; showModal = true" 
                                    class="text-pink-600 hover:text-pink-800 font-semibold"
                                >
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end items-center space-x-6">
            <p class="text-xl font-bold text-gray-800">Total: 
                <span class="text-pink-600">$<?php echo e(number_format($total, 2)); ?></span>
            </p>
            <a href="<?php echo e(route('cliente.checkout')); ?>" 
               class="px-6 py-3 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition">
                Proceder al pago
            </a>
        </div>
    <?php endif; ?>

    <!-- Modal Confirmación Eliminar -->
    <div
        x-show="showModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        x-transition
        style="display: none;"
    >
        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
            <h2 class="text-lg font-semibold text-pink-700 mb-4">Confirmar eliminación</h2>
            <p class="mb-6 text-gray-700">¿Estás seguro que deseas eliminar este producto del carrito?</p>
            <div class="flex justify-end space-x-4">
                <button @click="showModal = false; itemToDelete = null" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancelar</button>
                
                <form :action="`<?php echo e(route('cliente.cart.remove', '')); ?>/${itemToDelete}`" method="POST" class="inline-block">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit"
                        class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition duration-200 font-semibold shadow-sm hover:shadow-md">
                        <i class="fas fa-trash-alt mr-1"></i> Eliminar
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.cliente', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/cliente/cart.blade.php ENDPATH**/ ?>