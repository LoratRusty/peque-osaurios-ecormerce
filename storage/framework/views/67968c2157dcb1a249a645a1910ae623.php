<?php $__env->startSection('title', 'Tienda - Pequeñosaurios'); ?>
<?php $__env->startSection('content'); ?>

    
    <div class="bg-white shadow-lg rounded-2xl max-w-7xl mx-auto border border-pink-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            
            <div class="flex items-center justify-between mb-2">
                <button id="toggle-filters"
                    class="flex items-center text-pink-700 hover:text-pink-800 transition-all duration-300 group">
                    <div
                        class="w-10 h-10 bg-white-200 rounded-full flex items-center justify-center mr-3 group-hover:bg-pink-300 transition-colors duration-300">
                        <i class="fas fa-filter text-pink-600 text-lg"></i>
                    </div>
                    <div>
                        <span class="font-bold text-lg block">Filtros de búsqueda</span>
                        <span class="text-sm text-pink-600">Personaliza tu búsqueda</span>
                    </div>
                    <i id="filter-chevron"
                        class="fas fa-chevron-down ml-4 text-pink-600 text-sm transition-transform duration-300"></i>
                </button>

                
                <?php
                    $hasFilters =
                        request()->has('search') ||
                        request()->has('category') ||
                        request()->has('price_min') ||
                        request()->has('price_max') ||
                        request()->has('sort');
                ?>
                <button id="clear-filters"
                    class="text-sm bg-pink-100 hover:bg-pink-200 text-pink-700 px-4 py-2 rounded-full transition-all duration-300 flex items-center shadow-sm hover:shadow-md <?php echo e($hasFilters ? '' : 'opacity-0 invisible'); ?>">
                    <i class="fas fa-broom mr-2"></i>
                    Limpiar todo
                </button>
            </div>

            
            <div id="filters-container" class="<?php echo e($hasFilters ? '' : 'hidden'); ?> mt-6 animate-fadeInUp">
                <div class="pb-2"></div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 filter-grid">
                    
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-pink-700 flex items-center">
                            <i class="fas fa-search text-pink-500 mr-2"></i>
                            Buscar productos
                        </label>
                        <div class="relative">
                            <input type="text" id="search-input" name="search" placeholder="Nombre, descripción..."
                                value="<?php echo e(request('search')); ?>"
                                class="w-full px-4 py-3 pl-11 border border-pink-200 rounded-xl bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition-all duration-300 shadow-sm">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-pink-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-pink-700 flex items-center">
                            <i class="fas fa-tags text-pink-500 mr-2"></i>
                            Categoría
                        </label>
                        <div class="relative">
                            <select id="category-filter" name="category"
                                class="w-full px-4 py-3 pl-10 border border-pink-200 rounded-xl bg-white appearance-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition-all duration-300 shadow-sm">
                                <option value="">Todas las categorías</option>
                                <?php $__currentLoopData = $categoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->id); ?>"
                                        <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>>
                                        <?php echo e($cat->nombre); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-400">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-pink-400">
                                <i class="fas fa-tag"></i>
                            </div>
                        </div>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-pink-700 flex items-center">
                            <i class="fas fa-dollar-sign text-pink-500 mr-2"></i>
                            Rango de precio
                        </label>
                        <div class="flex space-x-3">
                            <div class="relative flex-1">
                                <input type="number" id="price-min" name="price_min" placeholder="Mínimo"
                                    value="<?php echo e(request('price_min')); ?>"
                                    class="w-full px-4 py-3 pl-10 border border-pink-200 rounded-xl bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition-all duration-300 shadow-sm">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-pink-400">
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                            </div>
                            <div class="relative flex-1">
                                <input type="number" id="price-max" name="price_max" placeholder="Máximo"
                                    value="<?php echo e(request('price_max')); ?>"
                                    class="w-full px-4 py-3 pl-10 border border-pink-200 rounded-xl bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition-all duration-300 shadow-sm">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-pink-400">
                                    <i class="fas fa-arrow-up"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-pink-700 flex items-center">
                            <i class="fas fa-sort-amount-down text-pink-500 mr-2"></i>
                            Ordenar por
                        </label>
                        <div class="relative">
                            <select id="sort-filter" name="sort"
                                class="w-full px-4 py-3 pl-10 border border-pink-200 rounded-xl bg-white appearance-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition-all duration-300 shadow-sm">
                                <option value="" <?php echo e(request('sort') == '' ? 'selected' : ''); ?>>Por defecto</option>
                                <option value="name_asc" <?php echo e(request('sort') == 'name_asc' ? 'selected' : ''); ?>>Nombre A-Z
                                </option>
                                <option value="name_desc" <?php echo e(request('sort') == 'name_desc' ? 'selected' : ''); ?>>Nombre Z-A
                                </option>
                                <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>Precio
                                    menor a mayor</option>
                                <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>Precio
                                    mayor a menor</option>
                                <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Más recientes
                                </option>
                            </select>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-400">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-pink-400">
                                <i class="fas fa-sort"></i>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div id="active-filters" class="mt-6 <?php echo e($hasFilters ? '' : 'hidden'); ?>">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-check-circle text-pink-500 mr-2"></i>
                        <span class="text-sm font-medium text-pink-700">Filtros aplicados:</span>
                    </div>
                    <div id="filter-badges" class="flex flex-wrap gap-2">
                        <?php if(request('search')): ?>
                            <span
                                class="bg-white border border-pink-200 text-pink-700 px-3 py-1 rounded-full text-xs flex items-center space-x-1 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <span>Buscar: "<?php echo e(request('search')); ?>"</span>
                                <a href="<?php echo e(url()->current()); ?>" class="ml-1 hover:text-pink-900 font-bold">&times;</a>
                            </span>
                        <?php endif; ?>
                        <?php if(request('category')): ?>
                            <?php
                                $catName = $categoria->firstWhere('id', request('category'))->nombre ?? 'Categoría';
                            ?>
                            <span
                                class="bg-white border border-pink-200 text-pink-700 px-3 py-1 rounded-full text-xs flex items-center space-x-1 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <span>Categoría: <?php echo e($catName); ?></span>
                                <a href="<?php echo e(url()->current()); ?>" class="ml-1 hover:text-pink-900 font-bold">&times;</a>
                            </span>
                        <?php endif; ?>
                        <?php if(request('price_min') || request('price_max')): ?>
                            <span
                                class="bg-white border border-pink-200 text-pink-700 px-3 py-1 rounded-full text-xs flex items-center space-x-1 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <span>Precio: <?php echo e(request('price_min') ?? 'Min'); ?> -
                                    <?php echo e(request('price_max') ?? 'Max'); ?></span>
                                <a href="<?php echo e(url()->current()); ?>" class="ml-1 hover:text-pink-900 font-bold">&times;</a>
                            </span>
                        <?php endif; ?>
                        <?php if(request('sort')): ?>
                            <?php
                                $sortLabels = [
                                    'name_asc' => 'Nombre A-Z',
                                    'name_desc' => 'Nombre Z-A',
                                    'price_asc' => 'Precio menor a mayor',
                                    'price_desc' => 'Precio mayor a menor',
                                    'newest' => 'Más recientes',
                                ];
                            ?>
                            <span
                                class="bg-white border border-pink-200 text-pink-700 px-3 py-1 rounded-full text-xs flex items-center space-x-1 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <span>Orden: <?php echo e($sortLabels[request('sort')] ?? 'Por defecto'); ?></span>
                                <a href="<?php echo e(url()->current()); ?>" class="ml-1 hover:text-pink-900 font-bold">&times;</a>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="mt-8 flex justify-center">
                    <button id="apply-filters"
                        class="px-8 py-3 bg-gradient-to-r from-pink-500 to-pink-600 text-white font-semibold rounded-xl hover:from-pink-600 hover:to-pink-700 shadow-lg hover:shadow-xl transition-all duration-300 flex items-center transform hover:-translate-y-0.5">
                        <i class="fas fa-search mr-2"></i>
                        Aplicar filtros
                        <div class="ml-2 animate-spin hidden" id="filter-spinner">
                            <i class="fas fa-spinner"></i>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-pink-700 mb-6 flex items-center">
            <i class="fas fa-box-open mr-2"></i>
            Productos disponibles
        </h2>

        <?php if($productos->isEmpty()): ?>
            <div class="text-center py-12">
                <div class="inline-block bg-pink-100 rounded-full p-4 mb-4">
                    <i class="fas fa-search text-pink-500 text-3xl"></i>
                </div>
                <p class="text-lg text-pink-700">No hay productos para mostrar.</p>
                <p class="text-pink-500 mt-2">Prueba ajustando tus filtros de búsqueda</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div
                        class="bg-white border border-pink-100 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col max-w-xl mx-auto overflow-hidden">
                        
                        <div class="aspect-w-4 aspect-h-3 rounded-t-xl overflow-hidden">
                            <img src="<?php echo e(asset('storage/' . $producto->imagen)); ?>" alt="<?php echo e($producto->nombre); ?>"
                                class="object-cover w-full h-full hover:scale-105 transition-transform duration-500">
                        </div>

                        
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-semibold text-pink-800"><?php echo e($producto->nombre); ?></h3>
                            <p class="text-gray-600 mt-2 flex-grow"><?php echo e(Str::limit($producto->descripcion, 100)); ?></p>
                            <p class="text-pink-600 font-bold mt-3 text-lg">$<?php echo e(number_format($producto->precio, 2)); ?></p>

                            
                            <div class="mt-2">
                                <?php if(isset($producto->stockTotal) && $producto->stockTotal > 0): ?>
                                    <span class="text-green-600 font-semibold text-sm flex items-center">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Stock disponible: <?php echo e($producto->stockTotal); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-red-500 font-semibold text-sm flex items-center">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Agotado
                                    </span>
                                <?php endif; ?>
                            </div>

                            
                            <div class="mt-2 text-sm text-gray-500">
                                <i class="fas fa-tag mr-1 text-pink-400"></i>
                                Categoría:
                                <a href="<?php echo e(route('cliente.store.category', ['category' => $producto->categoria->id])); ?>"
                                    class="text-pink-600 hover:underline">
                                    <?php echo e($producto->categoria->nombre); ?>

                                </a>
                            </div>

                            
                            <form action="<?php echo e(route('cliente.cart.add')); ?>" method="POST"
                                class="mt-5 flex flex-col space-y-4">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?php echo e($producto->id); ?>">

                                
                                <?php if($producto->sizes->isNotEmpty()): ?>
                                    <div>
                                        <label for="size_id" class="text-gray-700 font-medium">Talla:</label>
                                        <select name="size_id" id="size_id" required
                                            class="w-full border border-pink-200 rounded-lg px-3 py-2 text-sm 
                        focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 bg-white">
                                            <option value="" disabled selected>Selecciona talla</option>
                                            <?php $__currentLoopData = $producto->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($size->id); ?>"
                                                    data-stock="<?php echo e($size->pivot->stock); ?>"
                                                    <?php if($size->pivot->stock == 0): ?> disabled <?php endif; ?>>
                                                    <?php echo e($size->etiqueta); ?> (Stock: <?php echo e($size->pivot->stock); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                <?php endif; ?>

                                
                                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-4 sm:space-y-0">
                                    <div>
                                        <label for="quantity" class="text-gray-700 font-medium">Cantidad:</label>
                                        <input type="number" name="quantity" id="quantity" value="1"
                                            min="1" class="w-24 border rounded px-2 py-1 text-center" required>
                                    </div>

                                    <button type="submit"
                                        class="w-full sm:w-auto px-5 py-2 bg-gradient-to-r from-green-400 to-green-500 text-white rounded-lg 
                   hover:from-green-500 hover:to-green-600 transition duration-200 font-semibold shadow-sm hover:shadow-md 
                   disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                                        <?php if($producto->stockTotal <= 0): ?> disabled <?php endif; ?>>
                                        <i class="fas fa-cart-plus mr-2"></i>
                                        Agregar
                                    </button>
                                </div>
                            </form>

                            
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const sizeSelect = document.getElementById('size_id');
                                    const quantityInput = document.getElementById('quantity');

                                    if (sizeSelect && quantityInput) {
                                        function updateStockLimit() {
                                            const selected = sizeSelect.options[sizeSelect.selectedIndex];
                                            const stock = parseInt(selected.getAttribute('data-stock')) || 1;
                                            quantityInput.max = stock;
                                            if (parseInt(quantityInput.value) > stock) {
                                                quantityInput.value = stock;
                                            }
                                        }

                                        sizeSelect.addEventListener('change', updateStockLimit);
                                        updateStockLimit(); // Ejecutar al cargar
                                    }
                                });
                            </script>


                            
                            <a href="<?php echo e(route('cliente.store.product', ['product' => $producto->id])); ?>"
                                class="mt-5 block text-center text-pink-600 text-sm font-medium hover:underline flex items-center justify-center">
                                <i class="fas fa-eye mr-2"></i>
                                Ver detalles
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
    </div>


    <script>
        // Toggle de filtros
        document.getElementById('toggle-filters').addEventListener('click', function() {
            const filtersContainer = document.getElementById('filters-container');
            const chevron = document.getElementById('filter-chevron');
            const clearButton = document.getElementById('clear-filters');
            window.categorias = <?php echo json_encode($categoria, 15, 512) ?>;

            filtersContainer.classList.toggle('hidden');

            if (filtersContainer.classList.contains('hidden')) {
                chevron.style.transform = 'rotate(0deg)';
                clearButton.style.opacity = '0';
                clearButton.style.visibility = 'hidden'; // corregido de 'invisible'
            } else {
                chevron.style.transform = 'rotate(180deg)';
                clearButton.style.opacity = '1';
                clearButton.style.visibility = 'visible';
            }
        });

        // Sistema de filtros dinámicos
        class FilterSystem {
            constructor() {
                this.filters = {};
                this.init();
            }

            loadFiltersFromURL() {
                const params = new URLSearchParams(window.location.search);
                params.forEach((value, key) => {
                    if (value && value.trim() !== '') {
                        this.filters[key] = value;

                        const input = document.querySelector(`[name="${key}"], #${key.replace('_', '-')}`);
                        if (input) {
                            input.value = value;
                        }
                    }
                });

                this.updateFilterBadges();
            }

            init() {
                this.loadFiltersFromURL();

                // Event listeners para los filtros
                document.getElementById('search-input').addEventListener('input', (e) => {
                    this.updateFilter('search', e.target.value);
                });

                document.getElementById('category-filter').addEventListener('change', (e) => {
                    this.updateFilter('category', e.target.value);
                });

                document.getElementById('price-min').addEventListener('input', (e) => {
                    this.updateFilter('price_min', e.target.value);
                });

                document.getElementById('price-max').addEventListener('input', (e) => {
                    this.updateFilter('price_max', e.target.value);
                });

                document.getElementById('sort-filter').addEventListener('change', (e) => {
                    this.updateFilter('sort', e.target.value);
                });

                // Botón aplicar filtros
                document.getElementById('apply-filters').addEventListener('click', () => {
                    this.applyFilters();
                });

                // Botón limpiar filtros
                document.getElementById('clear-filters').addEventListener('click', () => {
                    this.clearFilters();
                });
            }

            updateFilter(key, value) {
                if (value && value.trim() !== '') {
                    this.filters[key] = value;
                } else {
                    delete this.filters[key];
                }
                this.updateFilterBadges();
            }

            updateFilterBadges() {
                const badgeContainer = document.getElementById('filter-badges');
                const activeFiltersContainer = document.getElementById('active-filters');

                badgeContainer.innerHTML = '';

                if (Object.keys(this.filters).length === 0) {
                    activeFiltersContainer.classList.add('hidden');
                    return;
                }

                activeFiltersContainer.classList.remove('hidden');

                Object.entries(this.filters).forEach(([key, value]) => {
                    const badge = document.createElement('span');
                    badge.className = 'filter-badge';
                    badge.innerHTML = `
                    ${this.getFilterLabel(key)}: ${this.getFilterValue(key, value)}
                    <i class="fas fa-times ml-2 cursor-pointer" onclick="filterSystem.removeFilter('${key}')"></i>
                `;
                    badgeContainer.appendChild(badge);
                });
            }

            getFilterValue(key, value) {
                if (key === 'category') {
                    const cat = window.categorias?.find(c => c.id == value);
                    return cat ? cat.nombre : value;
                }
                return value;
            }

            getFilterLabel(key) {
                const labels = {
                    search: 'Búsqueda',
                    price_min: 'Precio mín',
                    price_max: 'Precio máx',
                    sort: 'Ordenar'
                };

                if (key === 'category') {
                    return 'Categoría';
                }

                return labels[key] || key;
            }

            removeFilter(key) {
                delete this.filters[key];

                // Limpiar el input correspondiente
                const input = document.querySelector(`[name="${key}"], #${key.replace('_', '-')}`);
                if (input) {
                    input.value = '';
                }

                this.updateFilterBadges();
            }

            clearFilters() {
                this.filters = {};

                // Limpiar todos los inputs
                document.getElementById('search-input').value = '';
                document.getElementById('category-filter').value = '';
                document.getElementById('price-min').value = '';
                document.getElementById('price-max').value = '';
                document.getElementById('sort-filter').value = '';

                this.updateFilterBadges();
            }

            applyFilters() {
                const spinner = document.getElementById('filter-spinner');
                const button = document.getElementById('apply-filters');

                // Mostrar spinner
                spinner.classList.remove('hidden');
                button.disabled = true;

                // Construir URL con parámetros
                const params = new URLSearchParams();
                Object.entries(this.filters).forEach(([key, value]) => {
                    params.append(key, value);
                });

                // Redirigir a la URL con los filtros aplicados
                window.location.href = window.location.pathname + '?' + params.toString();
            }
        }

        // Inicializar sistema de filtros
        const filterSystem = new FilterSystem();
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.cliente', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/cliente/store.blade.php ENDPATH**/ ?>