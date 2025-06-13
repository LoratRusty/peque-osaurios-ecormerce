

<?php $__env->startSection('title', 'Detalles del Producto'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-5xl mx-auto mt-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex flex-col md:flex-row gap-6">
                
                <div class="md:w-1/2">
                    <img src="<?php echo e(asset('storage/' . $producto->imagen)); ?>" alt="<?php echo e($producto->nombre); ?>"
                        class="rounded-lg object-cover w-full h-auto max-h-[400px]">
                </div>

                
                <div class="md:w-1/2 flex flex-col justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-pink-600 mb-4"><?php echo e($producto->nombre); ?></h1>
                        <p class="text-gray-700 mb-6"><?php echo e($producto->descripcion); ?></p>

                        <p class="text-2xl font-semibold text-pink-600 mb-4">$<?php echo e(number_format($producto->precio, 2)); ?></p>

                        <p class="text-sm text-gray-500 mb-4">
                            Categoría:
                            <a href="<?php echo e(route('cliente.store.category', ['category' => $producto->categoria->id])); ?>"
                                class="text-pink-600 hover:underline">
                                <?php echo e($producto->categoria->nombre); ?>

                            </a>
                        </p>
                        <p class="text-sm mb-6">
                            <?php if(isset($producto->stockTotal) && $producto->stockTotal > 0): ?>
                                <span class="text-green-600 font-semibold">Stock disponible:
                                    <?php echo e($producto->stockTotal); ?></span>
                            <?php else: ?>
                                <span class="text-red-600 font-semibold">Agotado</span>
                            <?php endif; ?>
                        </p>
                    </div>

                    
                    <?php if(isset($producto->stockTotal) && $producto->stockTotal > 0): ?>
                        <form action="<?php echo e(route('cliente.cart.add')); ?>" method="POST" class="space-y-4">
                            <?php echo csrf_field(); ?>

                            <?php if($producto->sizes->count()): ?>
                                <div>
                                    <label for="size_id" class="text-gray-700 font-medium">Talla:</label>
                                    <select name="size_id" id="size_id" required
                                            class="w-full border border-pink-200 rounded-lg px-3 py-2">
                                        <option value="" disabled selected>Selecciona talla</option>
                                        <?php $__currentLoopData = $producto->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($size->id); ?>" data-stock="<?php echo e($size->pivot->stock); ?>"
                                                <?php if($size->pivot->stock == 0): ?> disabled <?php endif; ?>>
                                                <?php echo e($size->etiqueta); ?> (Stock: <?php echo e($size->pivot->stock); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                </div>
                            <?php endif; ?>

                            <input type="hidden" name="product_id" value="<?php echo e($producto->id); ?>">

                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-4 sm:space-y-0">
                            <div>
                                <label for="quantity" class="text-gray-700 font-medium">Cantidad:</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1"
                                    class="w-24 border rounded px-2 py-1 text-center" required>
                            </div>
                                    <button type="submit"
                                        class="w-full sm:w-auto px-5 py-2 bg-gradient-to-r from-green-400 to-green-500 text-white rounded-lg hover:from-green-500 hover:to-green-600 transition duration-200 font-semibold shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                                        <?php if($producto->stockTotal <= 0): ?> disabled <?php endif; ?>>
                                        <i class="fas fa-cart-plus mr-2"></i>
                                        Agregar
                                    </button>
                            </div>
                        </form>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const sizeSelect = document.getElementById('size_id');
                                const quantityInput = document.getElementById('quantity');

                                if (sizeSelect && quantityInput) {
                                    sizeSelect.addEventListener('change', function () {
                                        const selected = sizeSelect.options[sizeSelect.selectedIndex];
                                        const stock = parseInt(selected.getAttribute('data-stock')) || 1;
                                        quantityInput.max = stock;
                                        if (parseInt(quantityInput.value) > stock) {
                                            quantityInput.value = stock;
                                        }
                                    });

                                    // Opcional: establecer el max al cargar si ya hay talla seleccionada
                                    if (sizeSelect.value) {
                                        const selected = sizeSelect.options[sizeSelect.selectedIndex];
                                        const stock = parseInt(selected.getAttribute('data-stock')) || 1;
                                        quantityInput.max = stock;
                                    }
                                }
                            });
                        </script>

                    <?php else: ?>
                        <button disabled class="px-5 py-2 bg-gray-400 text-white rounded cursor-not-allowed">
                            Producto agotado
                        </button>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.cliente', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/cliente/product.blade.php ENDPATH**/ ?>