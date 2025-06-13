

<?php $__env->startSection('title', 'Reseñas de Productos'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-rose-100 py-8 px-4 sm:px-6 rounded-lg shadow-inner">
        <div class="max-w-7xl mx-auto">

            <!-- Header con estadísticas -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div class="flex flex-wrap gap-3">
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-pink-100 min-w-[160px]">
                        <p class="text-gray-500 text-sm">Reseñas totales</p>
                        <p class="text-2xl font-bold text-pink-700 mt-1"><?php echo e($totalReviews); ?></p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-pink-100 min-w-[160px]">
                        <p class="text-gray-500 text-sm">Promedio</p>
                        <div class="flex items-center mt-1">
                            <?php $avgRating = round($averageRating, 1); ?>
                            <div class="flex text-yellow-400 mr-2">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php if($i <= floor($avgRating)): ?>
                                        <i class="fas fa-star text-sm"></i>
                                    <?php elseif($i == ceil($avgRating) && $avgRating - floor($avgRating) >= 0.5): ?>
                                        <i class="fas fa-star-half-alt text-sm"></i>
                                    <?php else: ?>
                                        <i class="far fa-star text-sm"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <span class="text-xl font-bold text-pink-700"><?php echo e($avgRating); ?>/5</span>
                        </div>
                    </div>

                    <!-- Mostrar filtros aplicados -->
                    <?php if(request()->hasAny(['searchTerm', 'selectedRating', 'selectedProduct', 'dateFrom', 'dateTo', 'quickFilter'])): ?>
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-pink-100 min-w-[160px]">
                            <p class="text-gray-500 text-sm">Mostrando resultados</p>
                            <p class="text-2xl font-bold text-pink-700 mt-1"><?php echo e($reviews->total()); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sección de Filtros -->
            <div x-data="{
                showFilters: <?php echo e(request()->hasAny(['searchTerm', 'selectedRating', 'selectedProduct', 'dateFrom', 'dateTo', 'quickFilter']) ? 'true' : 'false'); ?>,
                searchTerm: '<?php echo e(request('searchTerm', '')); ?>',
                selectedRating: '<?php echo e(request('selectedRating', '')); ?>',
                selectedProduct: '<?php echo e(request('selectedProduct', '')); ?>',
                dateFrom: '<?php echo e(request('dateFrom', '')); ?>',
                dateTo: '<?php echo e(request('dateTo', '')); ?>',
                quickFilter: '<?php echo e(request('quickFilter', '')); ?>',
                selectedSort: '<?php echo e(request('selectedSort', 'newest')); ?>',
            
                clearFilters() {
                    this.searchTerm = '';
                    this.selectedRating = '';
                    this.selectedProduct = '';
                    this.dateFrom = '';
                    this.dateTo = '';
                    this.quickFilter = '';
                    this.selectedSort = 'newest';
                    this.submitFilters();
                },
            
                submitFilters() {
                    const form = document.getElementById('filtersForm');
                    form.submit();
                },
            
                setQuickFilter(filter) {
                    this.quickFilter = filter;
                    this.dateFrom = '';
                    this.dateTo = '';
                    this.submitFilters();
                }
            }" class="mb-6">

                <!-- Botón Toggle y Filtros Rápidos -->
                <div class="flex flex-col sm:flex-row gap-4 mb-4">
                    <button @click="showFilters = !showFilters"
                        class="inline-flex items-center px-4 py-2 bg-white border border-pink-200 rounded-lg text-pink-700 hover:bg-pink-50 transition">
                        <i class="fas fa-filter mr-2"></i>
                        <span x-text="showFilters ? 'Ocultar Filtros' : 'Mostrar Filtros'"></span>
                        <i class="fas fa-chevron-down ml-2 transition-transform"
                            :class="showFilters ? 'rotate-180' : ''"></i>
                    </button>

                    <!-- Filtros Rápidos de Tiempo -->
                    <div class="flex flex-wrap gap-2">
                        <button @click="setQuickFilter('today')"
                            :class="quickFilter === 'today' ? 'bg-pink-500 text-white' :
                                'bg-white text-pink-700 hover:bg-pink-50'"
                            class="px-3 py-2 border border-pink-200 rounded-lg text-sm transition">
                            Hoy
                        </button>
                        <button @click="setQuickFilter('week')"
                            :class="quickFilter === 'week' ? 'bg-pink-500 text-white' :
                                'bg-white text-pink-700 hover:bg-pink-50'"
                            class="px-3 py-2 border border-pink-200 rounded-lg text-sm transition">
                            Esta Semana
                        </button>
                        <button @click="setQuickFilter('month')"
                            :class="quickFilter === 'month' ? 'bg-pink-500 text-white' :
                                'bg-white text-pink-700 hover:bg-pink-50'"
                            class="px-3 py-2 border border-pink-200 rounded-lg text-sm transition">
                            Este Mes
                        </button>
                    </div>

                    <!-- Contador de filtros activos -->
                    <?php
                        $activeFilters = collect(
                            request()->only([
                                'searchTerm',
                                'selectedRating',
                                'selectedProduct',
                                'dateFrom',
                                'dateTo',
                                'quickFilter',
                            ]),
                        )
                            ->filter(function ($value) {
                                return !empty($value);
                            })
                            ->count();
                    ?>
                    <?php if($activeFilters > 0): ?>
                        <div class="flex items-center text-sm text-pink-600 bg-pink-100 px-3 py-2 rounded-lg">
                            <i class="fas fa-filter mr-1"></i>
                            <?php echo e($activeFilters); ?> filtro<?php echo e($activeFilters > 1 ? 's' : ''); ?>

                            activo<?php echo e($activeFilters > 1 ? 's' : ''); ?>

                        </div>
                    <?php endif; ?>
                </div>

                <!-- Panel de Filtros -->
                <div x-show="showFilters" x-transition class="bg-white rounded-xl shadow-sm border border-pink-100 p-6">
                    <form id="filtersForm" action="<?php echo e(route('admin.reviews')); ?>" method="GET" class="space-y-4">

                        <!-- Primera fila: Búsqueda y Ordenamiento -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Búsqueda -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-search mr-1"></i>
                                    Buscar
                                </label>
                                <input type="text" name="searchTerm" x-model="searchTerm"
                                    placeholder="Buscar por cliente, comentario o producto..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                            </div>

                            <!-- Ordenamiento -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-sort mr-1"></i>
                                    Ordenar por
                                </label>
                                <select name="selectedSort" x-model="selectedSort" @change="submitFilters()"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                    <option value="newest">Más recientes</option>
                                    <option value="oldest">Más antiguos</option>
                                    <option value="highest">Mejor calificados</option>
                                    <option value="lowest">Peor calificados</option>
                                    <option value="product">Por producto (A-Z)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Segunda fila: Calificación y Producto -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Filtro por Calificación -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-star mr-1"></i>
                                    Calificación
                                </label>
                                <select name="selectedRating" x-model="selectedRating"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                    <option value="">Todas las calificaciones</option>
                                    <option value="5">⭐⭐⭐⭐⭐ (5 estrellas)</option>
                                    <option value="4">⭐⭐⭐⭐ (4 estrellas)</option>
                                    <option value="3">⭐⭐⭐ (3 estrellas)</option>
                                    <option value="2">⭐⭐ (2 estrellas)</option>
                                    <option value="1">⭐ (1 estrella)</option>
                                </select>
                            </div>

                            <!-- Filtro por Producto -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-box mr-1"></i>
                                    Producto
                                </label>
                                <select name="selectedProduct" x-model="selectedProduct"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                                    <option value="">Todos los productos</option>
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($product->id); ?>"><?php echo e($product->nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <!-- Tercera fila: Rango de Fechas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Desde
                                </label>
                                <input type="date" name="dateFrom" x-model="dateFrom" @change="quickFilter = ''"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Hasta
                                </label>
                                <input type="date" name="dateTo" x-model="dateTo" @change="quickFilter = ''"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                            </div>
                        </div>

                        <!-- Input oculto para quickFilter -->
                        <input type="hidden" name="quickFilter" x-model="quickFilter">

                        <!-- Botones de acción -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition">
                                <i class="fas fa-search mr-2"></i>
                                Aplicar Filtros
                            </button>

                            <a href="<?php echo e(route('admin.reviews')); ?>"
                                class="inline-flex items-center justify-center px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-times mr-2"></i>
                                Limpiar Filtros
                            </a>


                            <!-- Mostrar filtros activos -->
                            <?php if(request()->hasAny(['searchTerm', 'selectedRating', 'selectedProduct', 'dateFrom', 'dateTo', 'quickFilter'])): ?>
                                <div class="flex flex-wrap gap-2 items-center">
                                    <?php if(request('searchTerm')): ?>
                                        <span
                                            class="inline-flex items-center px-2 py-1 bg-pink-100 text-pink-800 text-xs rounded-full">
                                            Búsqueda: "<?php echo e(request('searchTerm')); ?>"
                                        </span>
                                    <?php endif; ?>
                                    <?php if(request('selectedRating')): ?>
                                        <span
                                            class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                            <?php echo e(request('selectedRating')); ?> ⭐
                                        </span>
                                    <?php endif; ?>
                                    <?php if(request('selectedProduct')): ?>
                                        <?php
                                            $productName =
                                                $products->where('id', request('selectedProduct'))->first()?->nombre ??
                                                'Producto';
                                        ?>
                                        <span
                                            class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                            <?php echo e($productName); ?>

                                        </span>
                                    <?php endif; ?>
                                    <?php if(request('dateFrom') || request('dateTo')): ?>
                                        <span
                                            class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                            <?php if(request('dateFrom') && request('dateTo')): ?>
                                                <?php echo e(request('dateFrom')); ?> a <?php echo e(request('dateTo')); ?>

                                            <?php elseif(request('dateFrom')): ?>
                                                Desde <?php echo e(request('dateFrom')); ?>

                                            <?php else: ?>
                                                Hasta <?php echo e(request('dateTo')); ?>

                                            <?php endif; ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if(request('quickFilter')): ?>
                                        <span
                                            class="inline-flex items-center px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">
                                            <?php switch(request('quickFilter')):
                                                case ('today'): ?>
                                                    Hoy
                                                <?php break; ?>

                                                <?php case ('week'): ?>
                                                    Esta semana
                                                <?php break; ?>

                                                <?php case ('month'): ?>
                                                    Este mes
                                                <?php break; ?>

                                                <?php default: ?>
                                                    <?php echo e(request('quickFilter')); ?>

                                            <?php endswitch; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <?php if($reviews->count()): ?>
                <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-pink-100 text-pink-900 uppercase tracking-wide text-xs font-semibold">
                            <tr>
                                <th class="px-4 py-3 text-left">Producto</th>
                                <th class="px-4 py-3 text-left">Reseña</th>
                                <th class="px-4 py-3 text-center">Calificación</th>
                                <th class="px-4 py-3 text-left">Fecha</th>
                                <th class="px-4 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-pink-50 transition">
                                    <!-- Columna Producto -->
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <?php if($review->producto && $review->producto->imagen): ?>
                                                <img src="<?php echo e(asset('storage/' . $review->producto->imagen)); ?>"
                                                    alt="<?php echo e($review->producto->nombre); ?>"
                                                    class="w-10 h-10 object-cover rounded-lg mr-3">
                                            <?php else: ?>
                                                <div
                                                    class="bg-gray-200 border-2 border-dashed rounded-xl w-10 h-10 mr-3 flex items-center justify-center text-gray-500">
                                                    <i class="fas fa-box text-sm"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-medium text-gray-800">
                                                    <?php echo e($review->producto->nombre ?? 'Producto eliminado'); ?>

                                                </p>
                                                <p class="text-xs text-gray-500">ID: <?php echo e($review->id); ?></p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Columna Reseña -->
                                    <td class="px-4 py-3">
                                        <div class="max-w-[300px]">
                                            <p class="font-medium text-pink-700 truncate" title="<?php echo e($review->nombre); ?>">
                                                <?php echo e($review->nombre); ?>

                                            </p>
                                            <p class="text-gray-600 truncate mt-1" title="<?php echo e($review->comentario); ?>">
                                                <?php echo e(Str::limit($review->comentario, 70)); ?>

                                            </p>
                                        </div>
                                    </td>

                                    <!-- Columna Calificación -->
                                    <td class="px-4 py-3">
                                        <div class="flex justify-center">
                                            <?php if(isset($review->puntuacion)): ?>
                                                <div class="flex flex-col items-center">
                                                    <div class="flex text-yellow-400">
                                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                                            <?php if($i <= $review->puntuacion): ?>
                                                                <i class="fas fa-star"></i>
                                                            <?php else: ?>
                                                                <i class="far fa-star"></i>
                                                            <?php endif; ?>
                                                        <?php endfor; ?>
                                                    </div>
                                                    <span
                                                        class="text-xs bg-pink-100 text-pink-800 px-2 py-1 rounded-full mt-1">
                                                        <?php echo e($review->puntuacion); ?>/5
                                                    </span>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-gray-500">N/A</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- Columna Fecha -->
                                    <td class="px-4 py-3 text-gray-600 text-sm">
                                        <?php echo e($review->created_at->format('d/m/Y')); ?>

                                        <br>
                                        <span class="text-gray-400"><?php echo e($review->created_at->format('H:i')); ?></span>
                                    </td>

                                    <!-- Acciones -->
                                    <td class="px-4 py-3">
                                        <div x-data="{ confirmId: null, openView: false }" class="flex justify-center">
                                            <div class="inline-flex items-center space-x-2">
                                                <!-- Botón Ver -->
                                                <button @click="openView = true"
                                                    class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition"
                                                    title="Ver detalle">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <!-- Botón Eliminar -->
                                                <button @click="confirmId = <?php echo e($review->id); ?>"
                                                    class="flex items-center justify-center w-9 h-9 rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition"
                                                    title="Eliminar reseña">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                                <!-- Form oculto para DELETE -->
                                                <form id="delete-<?php echo e($review->id); ?>"
                                                    action="<?php echo e(route('admin.reviews.destroy', $review->id)); ?>"
                                                    method="POST" class="hidden">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                </form>

                                                <!-- Modal de Confirmación -->
                                                <?php if (isset($component)) { $__componentOriginal1978ea6189800d3ead8e1d285a55da54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1978ea6189800d3ead8e1d285a55da54 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.confirm-delete-modal','data' => ['id' => $review->id,'title' => 'Confirmar eliminación','message' => '¿Eliminar la reseña de <strong>'.e($review->nombre).'</strong> sobre <strong>'.e($review->producto->nombre ?? 'Producto eliminado').'</strong>?','confirmIdVar' => 'confirmId','confirmText' => 'Eliminar','cancelText' => 'Cancelar','confirmColor' => 'red','formSelector' => '#delete-'.e($review->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirm-delete-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($review->id),'title' => 'Confirmar eliminación','message' => '¿Eliminar la reseña de <strong>'.e($review->nombre).'</strong> sobre <strong>'.e($review->producto->nombre ?? 'Producto eliminado').'</strong>?','confirmIdVar' => 'confirmId','confirmText' => 'Eliminar','cancelText' => 'Cancelar','confirmColor' => 'red','formSelector' => '#delete-'.e($review->id).'']); ?>
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

                                                <!-- Modal de Detalle -->
                                                <div x-cloak x-show="openView"
                                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                                                    style="left: 0; right: 0; top: 0; bottom: 0; margin: 0;"
                                                    x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0"
                                                    x-transition:enter-end="opacity-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0" @click.away="openView = false">
                                                    <div
                                                        class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col">
                                                        <!-- Header -->
                                                        <div class="bg-pink-600 text-white px-6 py-4 rounded-t-2xl">
                                                            <div class="flex justify-between items-center">
                                                                <h3 class="text-xl font-semibold tracking-wide">Detalles de
                                                                    la Reseña</h3>
                                                                <button @click="openView = false"
                                                                    class="text-white hover:text-pink-200 text-lg">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- Contenido -->
                                                        <div class="overflow-y-auto flex-1 p-6 space-y-6">
                                                            <!-- Producto -->
                                                            <div class="flex items-start space-x-4">
                                                                <?php if($review->producto && $review->producto->imagen): ?>
                                                                    <img src="<?php echo e(asset('storage/' . $review->producto->imagen)); ?>"
                                                                        alt="<?php echo e($review->producto->nombre); ?>"
                                                                        class="w-16 h-16 rounded-xl object-cover border border-pink-200">
                                                                <?php endif; ?>
                                                                <div>
                                                                    <p class="text-lg font-semibold text-gray-800">
                                                                        <?php echo e($review->producto->nombre ?? 'Producto eliminado'); ?>

                                                                    </p>
                                                                    <p class="text-sm text-gray-500">ID reseña:
                                                                        <?php echo e($review->id); ?></p>
                                                                </div>
                                                            </div>

                                                            <!-- Cliente -->
                                                            <div>
                                                                <h4 class="text-pink-800 font-semibold mb-2">Cliente</h4>
                                                                <div class="flex items-center space-x-3">
                                                                    <div
                                                                        class="bg-pink-100 w-10 h-10 rounded-full flex items-center justify-center text-pink-600">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>
                                                                    <p class="font-medium text-gray-700">
                                                                        <?php echo e($review->nombre ?? 'Anónimo'); ?></p>
                                                                </div>
                                                            </div>

                                                            <!-- Calificación -->
                                                            <div>
                                                                <h4 class="text-pink-800 font-semibold mb-2">Calificación
                                                                </h4>
                                                                <?php if(isset($review->puntuacion)): ?>
                                                                    <div class="flex items-center space-x-3">
                                                                        <div class="text-2xl text-yellow-500 font-bold">
                                                                            <?php echo e($review->puntuacion); ?>.0
                                                                        </div>
                                                                        <div class="flex text-yellow-400">
                                                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                                                <?php if($i <= $review->puntuacion): ?>
                                                                                    <i class="fas fa-star"></i>
                                                                                <?php else: ?>
                                                                                    <i class="far fa-star"></i>
                                                                                <?php endif; ?>
                                                                            <?php endfor; ?>
                                                                        </div>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <p class="text-gray-500">No calificado</p>
                                                                <?php endif; ?>
                                                            </div>

                                                            <!-- Comentario -->
                                                            <div>
                                                                <h4 class="text-pink-800 font-semibold mb-2">Comentario
                                                                </h4>
                                                                <div
                                                                    class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                                                    <p class="text-gray-700 whitespace-pre-line">
                                                                        <?php echo e($review->comentario); ?></p>
                                                                </div>
                                                            </div>

                                                            <!-- Metadata -->
                                                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                                                <div>
                                                                    <p class="text-gray-400">Fecha de creación</p>
                                                                    <p class="font-medium">
                                                                        <?php echo e($review->created_at->format('d/m/Y H:i')); ?></p>
                                                                </div>
                                                                <div>
                                                                    <p class="text-gray-400">Producto ID</p>
                                                                    <p class="font-medium">
                                                                        <?php echo e($review->producto->id ?? 'N/A'); ?></p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Footer -->
                                                        <div class="bg-gray-50 px-6 py-3 flex justify-end rounded-b-2xl">
                                                            <button @click="openView = false"
                                                                class="px-5 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg transition">
                                                                Cerrar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <div class="bg-white px-4 py-3 border-t border-gray-200 rounded-b-xl">
                        <?php echo e($reviews->links()); ?>

                    </div>
                </div>
            <?php else: ?>
                <!-- Estado vacío -->
                <div class="text-center py-16 bg-white rounded-xl shadow-sm">
                    <div class="mx-auto max-w-md">
                        <div class="inline-block bg-pink-100 p-5 rounded-full mb-4">
                            <i class="fas fa-comments text-4xl text-pink-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            <?php if(request()->hasAny(['searchTerm', 'selectedRating', 'selectedProduct', 'dateFrom', 'dateTo', 'quickFilter'])): ?>
                                No se encontraron reseñas
                            <?php else: ?>
                                No hay reseñas aún
                            <?php endif; ?>
                        </h3>
                        <p class="text-gray-600 mb-6">
                            <?php if(request()->hasAny(['searchTerm', 'selectedRating', 'selectedProduct', 'dateFrom', 'dateTo', 'quickFilter'])): ?>
                                No hay reseñas que coincidan con los filtros aplicados. Intenta ajustar los criterios de
                                búsqueda.
                            <?php else: ?>
                                Parece que tus productos aún no han recibido reseñas. Cuando los clientes comiencen a
                                opinar, aparecerán aquí.
                            <?php endif; ?>
                        </p>

                        <?php if(request()->hasAny(['searchTerm', 'selectedRating', 'selectedProduct', 'dateFrom', 'dateTo', 'quickFilter'])): ?>
                            <button onclick="window.location.href='<?php echo e(route('admin.reviews')); ?>'"
                                class="inline-flex items-center px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition">
                                <i class="fas fa-times mr-2"></i>
                                Limpiar filtros
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>