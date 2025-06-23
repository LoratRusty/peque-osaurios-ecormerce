<?php $__env->startSection('title', 'Tienda - Pequeñosaurios'); ?>
<?php $__env->startSection('content'); ?>
    
    <div class="bg-white shadow-xl rounded-3xl max-w-7xl mx-auto border border-pink-200 backdrop-blur-sm bg-white/95">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 py-8">
            
            <div class="flex items-center justify-between mb-4">
                <button id="toggle-filters"
                    class="flex items-center text-pink-700 hover:text-pink-800 transition-all duration-300 group">
                    <div
                        class="w-12 h-12 bg-pink-50 rounded-full flex items-center justify-center mr-4 group-hover:bg-pink-100 transition-all duration-300 shadow-sm group-hover:shadow-md">
                        <i
                            class="fas fa-filter text-pink-600 text-lg group-hover:scale-110 transition-transform duration-300"></i>
                    </div>
                    <div>
                        <span class="font-bold text-xl block text-pink-800">Filtros de búsqueda</span>
                        <span class="text-sm text-pink-600 font-medium">Personaliza tu búsqueda</span>
                    </div>
                    <i id="filter-chevron"
                        class="fas fa-chevron-down ml-6 text-pink-600 text-lg transition-transform duration-300 group-hover:text-pink-700"></i>
                </button>

                
                <?php
                    $hasFilters =
                        request()->has('search') ||
                        request()->has('category') ||
                        request()->has('price_min') ||
                        request()->has('price_max') ||
                        request()->has('sort');
                ?>
            </div>

            
            <div id="filters-container" class="<?php echo e($hasFilters ? '' : 'hidden'); ?> mt-8 animate-fadeInUp">
                <div class="pb-4"></div>

                
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8 filter-grid">
                    
                    <div class="space-y-3">
                        <label class="text-sm font-semibold text-pink-800 flex items-center">
                            <i class="fas fa-search text-pink-500 mr-2 text-base"></i>
                            Buscar productos
                        </label>
                        <div class="relative group">
                            <input type="text" id="search-input" name="search" placeholder="Nombre, descripción..."
                                value="<?php echo e(request('search')); ?>"
                                class="w-full px-5 py-4 pl-12 border-2 border-pink-200 rounded-xl bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition-all duration-300 shadow-sm hover:shadow-md group-hover:border-pink-300">
                            <div
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 text-pink-400 group-hover:text-pink-500 transition-colors duration-300">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>

                    
                    <div class="space-y-3">
                        <label class="text-sm font-semibold text-pink-800 flex items-center">
                            <i class="fas fa-tags text-pink-500 mr-2 text-base"></i>
                            Categoría
                        </label>
                        <div class="relative group">
                            <select id="category-filter" name="category"
                                class="w-full px-5 py-4 pl-12 border-2 border-pink-200 rounded-xl bg-white appearance-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition-all duration-300 shadow-sm hover:shadow-md group-hover:border-pink-300 cursor-pointer">
                                <option value="">Todas las categorías</option>
                                <?php $__currentLoopData = $categoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->id); ?>"
                                        <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>>
                                        <?php echo e($cat->nombre); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-pink-400 pointer-events-none">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 text-pink-400 pointer-events-none">
                                <i class="fas fa-tag"></i>
                            </div>
                        </div>
                    </div>

                    
                    <div class="space-y-3">
                        <label class="text-sm font-semibold text-pink-800 flex items-center">
                            <i class="fas fa-dollar-sign text-pink-500 mr-2 text-base"></i>
                            Rango de precio
                        </label>
                        <div class="flex space-x-4">
                            <div class="relative flex-1 group">
                                <input type="number" id="price-min" name="price_min" placeholder="Min"
                                    value="<?php echo e(request('price_min')); ?>"
                                    class="w-full px-5 py-4 pl-12 border-2 border-pink-200 rounded-xl bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition-all duration-300 shadow-sm hover:shadow-md group-hover:border-pink-300">
                                <div
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-pink-400 pointer-events-none">
                                    <i class="fas fa-arrow-down text-sm"></i>
                                </div>
                            </div>
                            <div class="relative flex-1 group">
                                <input type="number" id="price-max" name="price_max" placeholder="Max"
                                    value="<?php echo e(request('price_max')); ?>"
                                    class="w-full px-5 py-4 pl-12 border-2 border-pink-200 rounded-xl bg-white focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition-all duration-300 shadow-sm hover:shadow-md group-hover:border-pink-300">
                                <div
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-pink-400 pointer-events-none">
                                    <i class="fas fa-arrow-up text-sm"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="space-y-3">
                        <label class="text-sm font-semibold text-pink-800 flex items-center">
                            <i class="fas fa-sort-amount-down text-pink-500 mr-2 text-base"></i>
                            Ordenar por
                        </label>
                        <div class="relative group">
                            <select id="sort-filter" name="sort"
                                class="w-full px-5 py-4 pl-12 border-2 border-pink-200 rounded-xl bg-white appearance-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition-all duration-300 shadow-sm hover:shadow-md group-hover:border-pink-300 cursor-pointer">
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
                            <div
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-pink-400 pointer-events-none">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 text-pink-400 pointer-events-none">
                                <i class="fas fa-sort"></i>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div id="active-filters" class="mt-8 <?php echo e($hasFilters ? '' : 'hidden'); ?>">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-check-circle text-pink-500 mr-3 text-lg"></i>
                        <span class="text-sm font-semibold text-pink-800">Filtros aplicados:</span>
                    </div>
                    <div id="filter-badges" class="flex flex-wrap gap-3">
                        <?php if(request('search')): ?>
                            <span
                                class="bg-gradient-to-r from-pink-50 to-white border-2 border-pink-200 text-pink-700 px-4 py-2 rounded-full text-sm flex items-center space-x-2 shadow-md hover:shadow-lg transition-all duration-200 font-medium">
                                <span>Buscar: "<strong><?php echo e(request('search')); ?></strong>"</span>
                                <a href="<?php echo e(url()->current()); ?>"
                                    class="ml-2 hover:text-pink-900 font-bold text-lg leading-none">&times;</a>
                            </span>
                        <?php endif; ?>
                        <?php if(request('category')): ?>
                            <?php
                                $catName = $categoria->firstWhere('id', request('category'))->nombre ?? 'Categoría';
                            ?>
                            <span
                                class="bg-gradient-to-r from-pink-50 to-white border-2 border-pink-200 text-pink-700 px-4 py-2 rounded-full text-sm flex items-center space-x-2 shadow-md hover:shadow-lg transition-all duration-200 font-medium">
                                <span>Categoría: <strong><?php echo e($catName); ?></strong></span>
                                <a href="<?php echo e(url()->current()); ?>"
                                    class="ml-2 hover:text-pink-900 font-bold text-lg leading-none">&times;</a>
                            </span>
                        <?php endif; ?>
                        <?php if(request('price_min') || request('price_max')): ?>
                            <span
                                class="bg-gradient-to-r from-pink-50 to-white border-2 border-pink-200 text-pink-700 px-4 py-2 rounded-full text-sm flex items-center space-x-2 shadow-md hover:shadow-lg transition-all duration-200 font-medium">
                                <span>Precio: <strong><?php echo e(request('price_min') ?? 'Min'); ?> -
                                        <?php echo e(request('price_max') ?? 'Max'); ?></strong></span>
                                <a href="<?php echo e(url()->current()); ?>"
                                    class="ml-2 hover:text-pink-900 font-bold text-lg leading-none">&times;</a>
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
                                class="bg-gradient-to-r from-pink-50 to-white border-2 border-pink-200 text-pink-700 px-4 py-2 rounded-full text-sm flex items-center space-x-2 shadow-md hover:shadow-lg transition-all duration-200 font-medium">
                                <span>Orden: <strong><?php echo e($sortLabels[request('sort')] ?? 'Por defecto'); ?></strong></span>
                                <a href="<?php echo e(url()->current()); ?>"
                                    class="ml-2 hover:text-pink-900 font-bold text-lg leading-none">&times;</a>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                
                <div class="mt-10 flex justify-center gap-4 flex-wrap">
                    <!-- Botón Limpiar Filtros -->
                    <button id="clear-filters"
                        class="text-sm bg-gradient-to-br from-pink-100 to-pink-50 hover:from-pink-200 hover:to-pink-100 text-pink-700 px-6 py-3 rounded-full transition-all duration-300 flex items-center shadow-sm hover:shadow-md border border-pink-200 hover:border-pink-300 font-medium disabled:opacity-0 disabled:invisible <?php echo e($hasFilters ? '' : 'opacity-0 invisible'); ?>">
                        <i class="fas fa-broom mr-2 text-pink-600"></i>
                        Limpiar filtros
                    </button>

                    <!-- Botón Aplicar Filtros -->
                    <button id="apply-filters"
                        class="px-8 py-4 bg-gradient-to-br from-pink-500 to-pink-600 text-white font-semibold rounded-full hover:from-pink-600 hover:to-pink-700 shadow-md hover:shadow-lg transition-transform duration-300 flex items-center gap-2 transform hover:-translate-y-0.5 hover:scale-105 text-base">
                        <i class="fas fa-search"></i>
                        Aplicar filtros
                        <div class="ml-2 animate-spin hidden" id="filter-spinner">
                            <i class="fas fa-spinner"></i>
                        </div>
                    </button>
                </div>

            </div>
        </div>
    </div>

    
    <div class="max-w-7xl mx-auto mt-10 px-6 sm:px-8 lg:px-10">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-pink-800 mb-3 flex items-center justify-center">
                Productos disponibles
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-pink-400 to-pink-600 mx-auto rounded-full"></div>
        </div>

        <?php if($productos->isEmpty()): ?>
            <div class="text-center py-16">
                <div class="inline-block bg-gradient-to-br from-pink-100 to-pink-50 rounded-full p-8 mb-6 shadow-lg">
                    <i class="fas fa-search text-pink-500 text-5xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-pink-800 mb-3">No hay productos para mostrar</h3>
                <p class="text-pink-600 text-lg">Prueba ajustando tus filtros de búsqueda</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article
                        class="group bg-white border-2 border-pink-100 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 max-w-xl mx-auto overflow-hidden hover:border-pink-200 hover:-translate-y-1 border-white border-2">

                        
                        <a href="<?php echo e(route('cliente.store.product', ['product' => $producto->id])); ?>"
                            class="block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                            <div
                                class="w-full h-48 md:h-56 lg:h-64 flex items-center justify-center bg-pink-100 overflow-hidden">
                                <img src="<?php echo e(asset('storage/' . $producto->imagen)); ?>" alt="<?php echo e($producto->nombre); ?>"
                                    class="object-contain w-full h-full transition-transform duration-500 group-hover:scale-105 remove-bg"
                                    loading="lazy" />
                            </div>
                        </a>

                        
                        <div class="p-6 flex flex-col flex-grow">
                            
                            <h3
                                class="text-xl font-bold text-pink-800 mb-3 group-hover:text-pink-900 transition-colors duration-300">
                                <?php echo e($producto->nombre); ?>

                            </h3>

                            
                            <p class="text-gray-600 mb-4 flex-grow leading-relaxed">
                                <?php echo e($producto->descripcion); ?>

                            </p>

                            
                            <p class="text-pink-600 font-bold mb-4 text-2xl">
                                $<?php echo e(number_format($producto->precio, 2)); ?>

                            </p>

                            
                            <div class="mb-4">
                                <?php if(isset($producto->stockTotal) && $producto->stockTotal > 0): ?>
                                    <span
                                        class="bg-green-100 text-green-700 font-semibold text-sm px-3 py-2 rounded-full flex items-center w-fit"
                                        aria-label="Stock disponible">
                                        <i class="fas fa-check-circle mr-2" aria-hidden="true"></i>
                                        Stock disponible: <?php echo e($producto->stockTotal); ?>

                                    </span>
                                <?php else: ?>
                                    <span
                                        class="bg-red-100 text-red-700 font-semibold text-sm px-3 py-2 rounded-full flex items-center w-fit"
                                        aria-label="Producto agotado">
                                        <i class="fas fa-times-circle mr-2" aria-hidden="true"></i>
                                        Agotado
                                    </span>
                                <?php endif; ?>
                            </div>

                            
                            <div class="mb-6 text-sm text-gray-600 flex items-center">
                                <i class="fas fa-tag mr-2 text-pink-400" aria-hidden="true"></i>
                                <span class="mr-1">Categoría:</span>
                                <a href="<?php echo e(route('cliente.store', ['category' => $producto->categoria->id])); ?>"
                                    class="text-pink-600 hover:text-pink-800 font-medium hover:underline ml-1 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                    <?php echo e($producto->categoria->nombre); ?>

                                </a>
                            </div>

                            
                            <form action="<?php echo e(route('cliente.cart.add')); ?>" method="POST"
                                class="flex flex-col space-y-5">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?php echo e($producto->id); ?>">

                                
                                <?php if($producto->sizes->isNotEmpty()): ?>
                                    <div>
                                        <label for="size_id-<?php echo e($producto->id); ?>"
                                            class="text-gray-800 font-semibold mb-2 block">                                            
                                            <i class="fas fa-ruler mr-1 text-pink-600"></i> Selecciona tu talla:</label>
                                        <select name="size_id" id="size_id-<?php echo e($producto->id); ?>" required
                                            class="w-full border-2 border-pink-200 rounded-lg px-4 py-3 text-sm 
                                   focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 bg-white hover:border-pink-300 transition-all duration-300">
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

                                
                                <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-4 space-y-4 sm:space-y-0">
                                    <div class="flex-1">
                                        <label for="quantity-<?php echo e($producto->id); ?>"
                                            class="block mb-2 font-semibold text-gray-800">                                            
                                            <i class="fas fa-hashtag mr-1 text-pink-600"></i> Cantidad:</label>
                                        <input type="number" name="quantity" id="quantity-<?php echo e($producto->id); ?>"
                                            value="1" min="1" required
                                            class="w-full rounded-lg border-2 border-pink-200 px-4 py-3 text-center font-semibold text-lg
                                  focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition-all duration-300 hover:border-pink-300" />
                                    </div>

                                    <button type="submit" <?php if(!isset($producto->stockTotal) || $producto->stockTotal <= 0): ?> disabled <?php endif; ?>
                                        class="flex items-center justify-center gap-3 rounded-lg bg-gradient-to-r from-green-500 to-green-600
                               px-6 py-3 font-bold text-white shadow-lg transition-all duration-300
                               hover:from-green-600 hover:to-green-700 hover:shadow-xl hover:-translate-y-0.5
                               disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:translate-y-0
                               sm:self-end text-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400">
                                        <i class="fas fa-cart-plus" aria-hidden="true"></i>
                                        <span>Agregar</span>
                                    </button>
                                </div>
                            </form>

                            
                            <a href="<?php echo e(route('cliente.store.product', ['product' => $producto->id])); ?>"
                                class="mt-5 block text-center bg-gradient-to-r from-pink-50 to-pink-100 hover:from-pink-100 hover:to-pink-200
                   text-pink-700 font-semibold py-3 rounded-lg transition-all duration-300 border-2 border-pink-200 hover:border-pink-300
                   flex items-center justify-center space-x-2 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                                <span>Ver detalles</span>
                            </a>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
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