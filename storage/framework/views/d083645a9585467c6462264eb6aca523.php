

<?php $__env->startSection('title', 'Inventario'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-rose-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        
        <div class="bg-white border border-pink-100 rounded-2xl shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <input type="text" placeholder="Buscar producto..." id="searchInput"
                    class="w-full px-4 py-2 border rounded-lg text-sm focus:ring-pink-400 focus:border-pink-400">

                <select id="filterCategoria" class="w-full px-4 py-2 border rounded-lg text-sm">
                    <option value="">Todas las categorías</option>
                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($categoria->id); ?>"><?php echo e($categoria->nombre); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <select id="filterTalla" class="w-full px-4 py-2 border rounded-lg text-sm">
                    <option value="">Todas las tallas</option>
                    <?php $__currentLoopData = $tallas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $talla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($talla->etiqueta); ?>"><?php echo e($talla->etiqueta); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <select id="filterEstado" class="w-full px-4 py-2 border rounded-lg text-sm">
                    <option value="">Todos los estados</option>
                    <option value="1">Activos</option>
                    <option value="0">Inactivos</option>
                </select>
            </div>
        </div>

        
        <div class="overflow-x-auto bg-white rounded-xl shadow-md border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-pink-100 text-pink-800">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Categoría</th>
                        <th class="px-4 py-2 text-left">Talla</th>
                        <th class="px-4 py-2 text-left">Color</th>
                        <th class="px-4 py-2 text-left">Precio</th>
                        <th class="px-4 py-2 text-left">Stock</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody id="productosTable" class="divide-y divide-gray-100">
                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr 
                            class="producto-row"
                            data-nombre="<?php echo e(strtolower($producto->nombre)); ?>"
                            data-categoria="<?php echo e($producto->categoria_id); ?>"
                            data-talla="<?php echo e(strtolower($producto->talla)); ?>"
                            data-estado="<?php echo e($producto->status); ?>"
                        >
                            <td class="px-4 py-2"><?php echo e($producto->id); ?></td>
                            <td class="px-4 py-2"><?php echo e($producto->nombre); ?></td>
                            <td class="px-4 py-2"><?php echo e($producto->categoria->nombre); ?></td>
                            <td class="px-4 py-2"><?php echo e($producto->talla ?? '-'); ?></td>
                            <td class="px-4 py-2"><?php echo e($producto->color ?? '-'); ?></td>
                            <td class="px-4 py-2"><?php echo e(number_format($producto->precio, 2)); ?> Bs</td>
                            <td class="px-4 py-2"><?php echo e($producto->stock); ?></td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 text-xs rounded <?php echo e($producto->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e($producto->status ? 'Activo' : 'Inactivo'); ?>

                                </span>
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="<?php echo e(route('productos.edit', $producto->id)); ?>" class="text-blue-500 hover:underline">Editar</a>
                                <form action="<?php echo e(route('productos.destroy', $producto->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este producto?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="text-red-500 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <div class="mt-6">
            <?php echo e($productos->links()); ?>

        </div>

    </div>
</div>


<script>
    const searchInput = document.getElementById('searchInput');
    const filterCategoria = document.getElementById('filterCategoria');
    const filterTalla = document.getElementById('filterTalla');
    const filterEstado = document.getElementById('filterEstado');

    function aplicarFiltros() {
        const search = searchInput.value.toLowerCase();
        const categoria = filterCategoria.value;
        const talla = filterTalla.value.toLowerCase();
        const estado = filterEstado.value;

        document.querySelectorAll('.producto-row').forEach(row => {
            const nombre = row.dataset.nombre;
            const cat = row.dataset.categoria;
            const tall = row.dataset.talla;
            const est = row.dataset.estado;

            const coincide = 
                (nombre.includes(search)) &&
                (categoria === "" || cat === categoria) &&
                (talla === "" || tall === talla) &&
                (estado === "" || est === estado);

            row.style.display = coincide ? '' : 'none';
        });
    }

    [searchInput, filterCategoria, filterTalla, filterEstado].forEach(el => {
        el.addEventListener('input', aplicarFiltros);
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/admin/products.blade.php ENDPATH**/ ?>