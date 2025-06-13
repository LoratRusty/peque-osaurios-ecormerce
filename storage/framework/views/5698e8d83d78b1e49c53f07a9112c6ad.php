

<?php $__env->startSection('title', 'Inventario'); ?>

<?php $__env->startSection('content'); ?>

    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-rose-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="flex items-center justify-between gap-4 flex-wrap">

                
                <a href="<?php echo e(route('admin.products.create')); ?>"
                    class="bg-gradient-to-r from-pink-500 to-pink-600 text-white px-6 py-3 rounded-xl hover:from-pink-600 hover:to-pink-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                    <i class="fas fa-plus mr-2"></i>Agregar Producto
                </a>

                
                <a href="<?php echo e(route('admin.products.categories.index')); ?>"
                    class="bg-gradient-to-r from-green-400 to-green-500 text-white px-6 py-3 rounded-xl hover:from-green-500 hover:to-green-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                    <i class="fas fa-tags mr-2"></i>Ver Categorías
                </a>

                
                <a href="<?php echo e(route('admin.products.sizes.index')); ?>"
                    class="bg-gradient-to-r from-blue-400 to-blue-500 text-white px-6 py-3 rounded-xl hover:from-blue-500 hover:to-blue-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                    <i class="fas fa-ruler mr-2"></i>Ver Tallas
                </a>

                


            </div>


            
            <div class="bg-white border border-pink-100 rounded-3xl shadow-xl overflow-hidden">
                
                <div class="bg-gradient-to-r from-pink-100 via-blue-50 to-green-50 px-6 py-4 border-b border-pink-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-700 flex items-center">
                            <i class="fas fa-filter mr-2 text-pink-500"></i>
                            Filtros de Búsqueda
                        </h3>
                        <button id="clearFilters"
                            class="text-sm text-gray-500 hover:text-pink-500 transition-colors duration-200 flex items-center">
                            <i class="fas fa-times mr-1"></i>Limpiar filtros
                        </button>
                    </div>
                </div>

                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        
                        <div class="relative group">
                            <label class="block text-sm font-medium text-gray-600 mb-2 flex items-center">
                                <i class="fas fa-search mr-2 text-pink-400"></i>Buscar producto
                            </label>
                            <div class="relative">
                                <input type="text" placeholder="Nombre del producto..." id="searchInput"
                                    class="w-full px-4 py-3 pl-10 border-2 border-pink-100 rounded-xl text-sm focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition-all duration-200 bg-pink-50/30 hover:bg-pink-50/50">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-pink-300 text-sm"></i>
                            </div>
                        </div>

                        
                        <div class="relative group">
                            <label class="block text-sm font-medium text-gray-600 mb-2 flex items-center">
                                <i class="fas fa-tags mr-2 text-blue-400"></i>Categoría
                            </label>
                            <div class="relative">
                                <select id="filterCategoria"
                                    class="w-full px-4 py-3 pl-10 border-2 border-blue-100 rounded-xl text-sm focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all duration-200 bg-blue-50/30 hover:bg-blue-50/50 appearance-none cursor-pointer">
                                    <option value="">Todas las categorías</option>
                                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($categoria->id); ?>"><?php echo e($categoria->nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <i
                                    class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-blue-300 text-sm"></i>
                            </div>
                        </div>

                        
                        <div class="relative group">
                            <label class="block text-sm font-medium text-gray-600 mb-2 flex items-center">
                                <i class="fas fa-ruler mr-2 text-green-400"></i>Talla
                            </label>
                            <div class="relative">
                                <select id="filterTalla"
                                    class="w-full px-4 py-3 pl-10 border-2 border-green-100 rounded-xl text-sm focus:ring-2 focus:ring-green-300 focus:border-green-400 transition-all duration-200 bg-green-50/30 hover:bg-green-50/50 appearance-none cursor-pointer">
                                    <option value="">Todas las tallas</option>
                                    <?php $__currentLoopData = $tallas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $talla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($talla->etiqueta); ?>"><?php echo e($talla->etiqueta); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <i
                                    class="fas fa-ruler-combined absolute left-3 top-1/2 transform -translate-y-1/2 text-green-300 text-sm"></i>
                            </div>
                        </div>

                        
                        <div class="relative group">
                            <label class="block text-sm font-medium text-gray-600 mb-2 flex items-center">
                                <i class="fas fa-toggle-on mr-2 text-pink-400"></i>Estado
                            </label>
                            <div class="relative">
                                <select id="filterEstado"
                                    class="w-full px-4 py-3 pl-10 border-2 border-pink-100 rounded-xl text-sm focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition-all duration-200 bg-pink-50/30 hover:bg-pink-50/50 appearance-none cursor-pointer">
                                    <option value="">Todos los estados</option>
                                    <option value="1">Activos</option>
                                    <option value="0">Inactivos</option>
                                </select>
                                <i
                                    class="fas fa-circle-dot absolute left-3 top-1/2 transform -translate-y-1/2 text-pink-300 text-sm"></i>
                            </div>
                        </div>
                    </div>

                    
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center p-3 bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg">
                                <div class="text-lg font-bold text-pink-600" id="totalProducts"><?php echo e($products->total()); ?>

                                </div>
                                <div class="text-xs text-pink-500">Total productos</div>
                            </div>
                            <div class="text-center p-3 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg">
                                <div class="text-lg font-bold text-blue-600" id="visibleProducts"><?php echo e($products->count()); ?>

                                </div>
                                <div class="text-xs text-blue-500">Mostrando</div>
                            </div>
                            <div class="text-center p-3 bg-gradient-to-br from-green-50 to-green-100 rounded-lg">
                                <div class="text-lg font-bold text-green-600" id="activeProducts">
                                    <?php echo e($products->where('status', 1)->count()); ?>

                                </div>
                                <div class="text-xs text-green-500">Activos</div>
                            </div>
                            <div class="text-center p-3 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg">
                                <div class="text-lg font-bold text-gray-600" id="inactiveProducts">
                                    <?php echo e($products->where('status', 0)->count()); ?>

                                </div>
                                <div class="text-xs text-gray-500">Inactivos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="overflow-x-auto bg-white rounded-xl shadow-md border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200 text-sm table-fixed">
                <thead class="bg-pink-100 text-pink-800">
                    <tr>
                        <th class="px-4 py-2 text-left w-10">ID</th>                 
                        <th class="px-4 py-2 text-left min-w-[140px]">Nombre</th>
                        <th class="px-4 py-2 text-left min-w-[100px]">Categoría</th> 
                        <th class="px-4 py-2 text-left min-w-[180px]">Tallas</th>    
                        <th class="px-4 py-2 text-left w-24">Color</th>
                        <th class="px-4 py-2 text-left w-24">Precio</th>
                        <th class="px-4 py-2 text-left w-24">Stock total</th>
                        <th class="px-4 py-2 text-left w-20">Estado</th>
                        <th class="px-4 py-2 text-left w-44">Acciones</th>
                    </tr>
                </thead>
                <tbody id="productsTable" class="divide-y divide-gray-100">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $tallasLabels = $producto->sizes->pluck('etiqueta')->map(fn($e) => strtolower($e))->toArray();
                            $dataTalla = implode(' ', $tallasLabels);
                            $stockTotal = $producto->sizes->sum(fn($size) => $size->pivot->stock);
                        ?>
                        <tr class="producto-row"
                            data-nombre="<?php echo e(strtolower($producto->nombre)); ?>"
                            data-categoria="<?php echo e($producto->categoria_id); ?>"
                            data-talla="<?php echo e($dataTalla); ?>"
                            data-estado="<?php echo e($producto->status); ?>"
                        >
                            <td class="px-4 py-2 text-center"><?php echo e($producto->id); ?></td>
                            <td class="px-4 py-2 truncate" title="<?php echo e($producto->nombre); ?>"><?php echo e($producto->nombre); ?></td>
                            <td class="px-4 py-2 truncate" title="<?php echo e($producto->categoria->nombre); ?>"><?php echo e($producto->categoria->nombre); ?></td>

                            <td class="px-4 py-2 align-top max-w-[140px] overflow-auto">
                                <?php if($producto->sizes->isEmpty()): ?>
                                    <span class="text-gray-400 text-sm italic">-</span>
                                <?php else: ?>
                                    <ul class="list-disc list-inside space-y-0.5 text-sm leading-snug max-h-32 overflow-y-auto">
                                        <?php $__currentLoopData = $producto->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <span class="font-semibold text-pink-600"><?php echo e($size->etiqueta); ?></span>
                                                <span class="text-gray-600 text-xs ml-1">(Stock: <?php echo e($size->pivot->stock); ?>)</span>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </td>

                            <td class="px-4 py-2 text-center"><?php echo e($producto->color ?? '-'); ?></td>
                            <td class="px-4 py-2 text-right"><?php echo e(number_format($producto->precio, 2)); ?> $</td>

                            <td class="px-4 py-2 text-center">
                                <?php if($producto->sizes->isNotEmpty()): ?>
                                    <?php echo e($stockTotal); ?>

                                <?php else: ?>
                                    <?php echo e($producto->stock ?? '-'); ?>

                                <?php endif; ?>
                            </td>

                            <td class="px-4 py-2 text-center">
                                <span class="inline-block px-2 py-1 text-xs rounded <?php echo e($producto->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e($producto->status ? 'Activo' : 'Inactivo'); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2 whitespace-nowrap">
                                <a href="<?php echo e(route('admin.products.edit', $producto->id)); ?>"
                                class="inline-flex items-center px-3 py-1 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50 text-sm">
                                    <i class="fas fa-edit mr-1"></i>Editar
                                </a>

                                <div x-data="{ confirmId: null }" class="inline">
                                    <button type="button" @click="confirmId = <?php echo e($producto->id); ?>"
                                        class="inline-flex items-center px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50 text-sm">
                                        <i class="fas fa-trash-alt mr-1"></i>Eliminar
                                    </button>

                                    <form id="delete-<?php echo e($producto->id); ?>" action="<?php echo e(route('admin.products.destroy', $producto->id)); ?>" method="POST" class="hidden">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                    </form>

                                    <?php if (isset($component)) { $__componentOriginal1978ea6189800d3ead8e1d285a55da54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1978ea6189800d3ead8e1d285a55da54 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirm-delete-modal','data' => ['id' => $producto->id,'title' => 'Confirmar eliminación de Producto','message' => '¿Estás seguro que deseas eliminar el Producto <strong>'.e($producto->nombre).'</strong>?<br>Esta acción no se puede deshacer.','confirmIdVar' => 'confirmId','confirmText' => 'Sí, eliminar producto','confirmColor' => 'red','formSelector' => '#delete-'.e($producto->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirm-delete-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($producto->id),'title' => 'Confirmar eliminación de Producto','message' => '¿Estás seguro que deseas eliminar el Producto <strong>'.e($producto->nombre).'</strong>?<br>Esta acción no se puede deshacer.','confirmIdVar' => 'confirmId','confirmText' => 'Sí, eliminar producto','confirmColor' => 'red','formSelector' => '#delete-'.e($producto->id).'']); ?>
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tr id="noResults" class="text-center text-gray-500" style="display: none;">
                    <td colspan="9" class="px-4 py-6">No se encontraron productos con los filtros seleccionados.</td>
                </tr>
            </table>

            
            <?php if($products->hasPages()): ?>
                <div class="mt-6 px-4 py-3 flex items-center justify-between border-t border-gray-200 bg-white rounded-b-lg">
                    <div class="text-sm text-gray-700">
                        Mostrando <?php echo e($products->firstItem()); ?> - <?php echo e($products->lastItem()); ?> de <?php echo e($products->total()); ?> Productos
                    </div>
                    <div class="flex space-x-2">
                        
                        <?php if($products->onFirstPage()): ?>
                            <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Anterior</span>
                        <?php else: ?>
                            <a href="<?php echo e($products->previousPageUrl()); ?>" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Anterior</a>
                        <?php endif; ?>

                        
                        <?php if($products->hasMorePages()): ?>
                            <a href="<?php echo e($products->nextPageUrl()); ?>" class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Siguiente</a>
                        <?php else: ?>
                            <span class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Siguiente</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
    <script>
        const searchInput = document.getElementById('searchInput');
        const filterCategoria = document.getElementById('filterCategoria');
        const filterTalla = document.getElementById('filterTalla');
        const filterEstado = document.getElementById('filterEstado');
        const clearFiltersBtn = document.getElementById('clearFilters');
        const activeFiltersContainer = document.getElementById('activeFilters');
        const visibleProductsCounter = document.getElementById('visibleProducts');

function aplicarFiltros() {
    const search = searchInput.value.toLowerCase();
    const categoria = filterCategoria.value;
    const talla = filterTalla.value.toLowerCase(); // Talla seleccionada
    const estado = filterEstado.value;

    let visibleCount = 0;

    document.querySelectorAll('.producto-row').forEach(row => {
        const nombre = row.dataset.nombre;
        const cat = row.dataset.categoria;
        const tallas = row.dataset.talla.split(' '); // lista de tallas del producto
        const est = row.dataset.estado;

        const tallaCoincide = talla === "" || tallas.includes(talla);
        const coincide =
            nombre.includes(search) &&
            (categoria === "" || cat === categoria) &&
            tallaCoincide &&
            (estado === "" || est === estado);

        row.style.display = coincide ? '' : 'none';
        if (coincide) visibleCount++;
    });
    const noResults = document.getElementById('noResults');
    if (noResults) {
        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
    }

    visibleProductsCounter.textContent = visibleCount;
}


        function limpiarFiltros() {
            searchInput.value = '';
            filterCategoria.value = '';
            filterTalla.value = '';
            filterEstado.value = '';
            aplicarFiltros();
        }

        // Event listeners
        [searchInput, filterCategoria, filterTalla, filterEstado].forEach(el => {
            el.addEventListener('input', aplicarFiltros);
            el.addEventListener('change', aplicarFiltros);
        });

        clearFiltersBtn.addEventListener('click', limpiarFiltros);
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/admin/products/products.blade.php ENDPATH**/ ?>