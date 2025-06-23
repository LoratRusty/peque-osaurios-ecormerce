

<?php $__env->startSection('title', 'Facturas y Carritos Pendientes'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-5xl mx-auto p-6 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10">

        
        <div x-data="{ open: <?php echo e(request()->hasAny(['search', 'status', 'date_from', 'date_to', 'min_total', 'max_total']) ? 'true' : 'false'); ?> }" class="mb-6">
            <button @click="open = !open"
                class="flex items-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg transition">
                <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="mr-2"></i>
                <span x-text="open ? 'Ocultar Filtros' : 'Mostrar Filtros'"></span>
            </button>
            <div x-show="open" x-transition class="mt-4 bg-pink-50 p-4 rounded-xl border border-pink-200">
                <form method="GET" action="<?php echo e(route('admin.invoice')); ?>"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Buscar (usuario, email o
                            ID)</label>
                        <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>"
                            placeholder="Nombre, email o ID"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-pink-300 focus:border-pink-300 transition" />
                    </div>

                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-pink-300 focus:border-pink-300 transition">
                            <option value="">Todos</option>
                            <?php $__currentLoopData = ['pendiente', 'pagado', 'enviado', 'cancelado', 'completado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($st); ?>" <?php if(request('status') === $st): ?> selected <?php endif; ?>
                                    class="capitalize"><?php echo e($st); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700">Fecha Desde</label>
                        <input type="date" name="date_from" id="date_from" value="<?php echo e(request('date_from')); ?>"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-pink-300 focus:border-pink-300 transition" />
                    </div>

                    
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700">Fecha Hasta</label>
                        <input type="date" name="date_to" id="date_to" value="<?php echo e(request('date_to')); ?>"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-pink-300 focus:border-pink-300 transition" />
                    </div>

                    
                    <div>
                        <label for="min_total" class="block text-sm font-medium text-gray-700">Total Mínimo ($)</label>
                        <input type="number" step="0.01" name="min_total" id="min_total"
                            value="<?php echo e(request('min_total')); ?>" placeholder="0.00"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-pink-300 focus:border-pink-300 transition" />
                    </div>

                    
                    <div>
                        <label for="max_total" class="block text-sm font-medium text-gray-700">Total Máximo ($)</label>
                        <input type="number" step="0.01" name="max_total" id="max_total"
                            value="<?php echo e(request('max_total')); ?>" placeholder="0.00"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-pink-300 focus:border-pink-300 transition" />
                    </div>

                    
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg transition">
                            Aplicar Filtros
                        </button>
                        <a href="<?php echo e(route('admin.invoice')); ?>"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Facturas Realizadas</h2>
        <?php if($orders->isEmpty()): ?>
            <p class="text-gray-600">No hay órdenes registradas.</p>
        <?php else: ?>
            <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-pink-100 text-pink-900 uppercase tracking-wide text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-left">ID Orden</th>
                            <th class="px-4 py-3 text-left">Usuario</th>
                            <th class="px-4 py-3 text-left">Total</th>
                            <th class="px-4 py-3 text-left">Estado</th>
                            <th class="px-4 py-3 text-left">Fecha</th>
                            <th class="px-4 py-3 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-pink-50 transition">
                                
                                <td class="px-4 py-3 text-gray-800"><?php echo e($order->id); ?></td>

                                
                                <td class="px-4 py-3 text-gray-800">
                                    <?php echo e(optional($order->user)->name ?? 'Sin usuario'); ?>

                                    <?php if(optional($order->user)->email): ?>
                                        <br>
                                        <span class="text-xs text-gray-500"><?php echo e($order->user->email); ?></span>
                                    <?php endif; ?>
                                </td>

                                
                                <td class="px-4 py-3 text-gray-800">$<?php echo e(number_format($order->total, 2)); ?></td>

                                
                                <td class="px-4 py-3">
                                    <span
                                        class="capitalize inline-block px-2 py-1 text-xs font-medium 
                                    <?php switch($order->status):
                                        case ('pendiente'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                        <?php case ('pagado'): ?> bg-blue-100 text-blue-800 <?php break; ?>
                                        <?php case ('enviado'): ?> bg-indigo-100 text-indigo-800 <?php break; ?>
                                        <?php case ('completado'): ?> bg-green-100 text-green-800 <?php break; ?>
                                        <?php case ('cancelado'): ?> bg-red-100 text-red-800 <?php break; ?>
                                        <?php default: ?> bg-gray-100 text-gray-800
                                    <?php endswitch; ?>
                                ">
                                        <?php echo e($order->status); ?>

                                    </span>
                                </td>

                                
                                <td class="px-4 py-3 text-gray-600">
                                    <?php echo e($order->created_at->format('d/m/Y')); ?>

                                    <br>
                                    <span class="text-xs"><?php echo e($order->created_at->format('H:i')); ?></span>
                                </td>

                                
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center space-x-2">
                                        
                                        <div x-data="{ openDetail: false }" class="relative">
                                            <button @click="openDetail = true"
                                                class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition"
                                                title="Ver detalle de orden">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                            <div x-cloak x-show="openDetail"
                                                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50"
                                                @click.away="openDetail = false" x-transition:enter="ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="ease-in duration-200"
                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                <div class="bg-white rounded-2xl py-8 px-6 max-w-2xl w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto flex flex-col"
                                                    @keydown.escape.window="openDetail = false">
                                                    
                                                    <div class="flex justify-between items-center mb-6">
                                                        <h3 class="text-xl font-semibold text-pink-600">Detalle Orden
                                                            #<?php echo e($order->id); ?></h3>
                                                        <button @click="openDetail = false"
                                                            class="text-gray-500 hover:text-gray-700">
                                                            <i class="fas fa-times text-lg"></i>
                                                        </button>
                                                    </div>
                                                    
                                                    <div class="space-y-4">
                                                        
                                                        <div>
                                                            <h4 class="font-semibold text-gray-700">Usuario</h4>
                                                            <p class="text-gray-800">
                                                                <?php echo e(optional($order->user)->name ?? 'Sin usuario'); ?>

                                                                <?php if(optional($order->user)->email): ?>
                                                                    <br><span
                                                                        class="text-sm text-gray-500"><?php echo e($order->user->email); ?></span>
                                                                <?php endif; ?>
                                                            </p>
                                                        </div>
                                                        
                                                        <div>
                                                            <h4 class="font-semibold text-gray-700">Dirección de Envío</h4>
                                                            <p class="text-gray-800 break-words">
                                                                <?php echo e($order->direccion_envio); ?></p>
                                                        </div>
                                                        
                                                        <?php if($order->payment && $order->payment->paymentType): ?>
                                                            <div>
                                                                <h4 class="font-semibold text-gray-700">Método de Pago</h4>
                                                                <p class="text-gray-800">
                                                                    <?php echo e($order->payment->paymentType->nombre); ?>

                                                                </p>
                                                            </div>
                                                        <?php else: ?>
                                                            <p>Método de pago no disponible</p>
                                                        <?php endif; ?>
                                                        
                                                        <div>
                                                            <h4 class="font-semibold text-gray-700">Items</h4>
                                                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                                                <table class="min-w-full text-sm">
                                                                    <thead class="bg-pink-100 text-pink-900 uppercase tracking-wide text-xs font-semibold">
                                                                        <tr>
                                                                            <th class="px-3 py-2 text-left">Producto</th>
                                                                            <th class="px-3 py-2 text-center">Cant.</th>
                                                                            <th class="px-3 py-2 text-right">Precio Unit.
                                                                            </th>
                                                                            <th class="px-3 py-2 text-right">Subtotal</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php $sumSubtotal = 0; ?>
                                                                        <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php
                                                                                $subtotal =
                                                                                    $item->cantidad *
                                                                                    $item->precio_unitario;
                                                                                $sumSubtotal += $subtotal;
                                                                            ?>
                                                                            <tr class="border-t border-gray-100">
                                                                                <td class="px-3 py-2">
                                                                                    <?php echo e(optional($item->product)->nombre ?? 'Producto eliminado'); ?>

                                                                                </td>
                                                                                <td class="px-3 py-2 text-center">
                                                                                    <?php echo e($item->cantidad); ?></td>
                                                                                <td class="px-3 py-2 text-right">
                                                                                    $<?php echo e(number_format($item->precio_unitario, 2)); ?>

                                                                                </td>
                                                                                <td class="px-3 py-2 text-right">
                                                                                    $<?php echo e(number_format($subtotal, 2)); ?></td>
                                                                            </tr>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr class="bg-gray-50">
                                                                            <td colspan="3"
                                                                                class="px-3 py-2 text-right font-medium">
                                                                                Subtotal:</td>
                                                                            <td class="px-3 py-2 text-right font-semibold">
                                                                                $<?php echo e(number_format($sumSubtotal, 2)); ?></td>
                                                                        </tr>
                                                                        <tr class="bg-gray-50">
                                                                            <td colspan="3"
                                                                                class="px-3 py-2 text-right font-medium">
                                                                                Total:</td>
                                                                            <td class="px-3 py-2 text-right font-semibold">
                                                                                $<?php echo e(number_format($order->total, 2)); ?></td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                                            <div>
                                                                <p>Fecha creación</p>
                                                                <p class="font-medium">
                                                                    <?php echo e($order->created_at->format('d/m/Y H:i')); ?></p>
                                                            </div>
                                                            <div>
                                                                <p>ID Pago</p>
                                                                <p class="font-medium"><?php echo e($order->pago_id ?? '—'); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mt-6 flex justify-end space-x-2">
                                                        <button @click="openDetail = false"
                                                            class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                                                            Cerrar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div x-data="{ openStatus: false, newStatus: '<?php echo e($order->status); ?>' }" class="relative">
                                            <button @click="openStatus = true"
                                                class="flex items-center justify-center w-9 h-9 rounded-full bg-green-100 text-green-600 hover:bg-green-200 transition"
                                                title="Cambiar estado">
                                                <i class="fas fa-exchange-alt"></i>
                                            </button>
                                            
                                            <div x-cloak x-show="openStatus"
                                                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50"
                                                @click.away="openStatus = false"
                                                x-transition:enter="ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="ease-in duration-200"
                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                <div class="bg-white rounded-2xl py-6 px-6 max-w-sm w-full mx-4 shadow-2xl"
                                                    @keydown.escape.window="openStatus = false">
                                                    <h4 class="text-lg font-semibold text-gray-700 mb-4">Cambiar Estado
                                                        Orden #<?php echo e($order->id); ?></h4>
                                                    <form method="POST"
                                                        action="<?php echo e(route('admin.invoice.updateStatus', $order->id)); ?>"
                                                        class="w-full max-w-sm">
                                                        <?php echo csrf_field(); ?>

                                                        <label for="status-select-<?php echo e($order->id); ?>"
                                                            class="block text-sm font-medium text-gray-700 mb-2">
                                                            Estado
                                                        </label>

                                                        <select id="status-select-<?php echo e($order->id); ?>" name="status"
                                                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
               focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition"
                                                            aria-label="Seleccionar estado del pedido">
                                                            <?php $__currentLoopData = ['pendiente', 'pagado', 'enviado', 'cancelado', 'completado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($st); ?>"
                                                                    <?php if($order->status === $st): ?> selected <?php endif; ?>
                                                                    class="capitalize">
                                                                    <?php echo e(ucfirst($st)); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>

                                                        <div class="mt-4 flex justify-end space-x-3">
                                                            <button type="button" @click="openStatus = false"
                                                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                                                                Cancelar
                                                            </button>

                                                            <button type="submit"
                                                                class="px-5 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg font-semibold transition">
                                                                Actualizar
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                
                <div class="mt-4">
                    <?php echo e($orders->withQueryString()->links()); ?>

                </div>
            </div>
        <?php endif; ?>
    </div>

    
    <div class="max-w-5xl mx-auto p-6 bg-white rounded-3xl shadow-lg border border-pink-100 mt-10">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Carritos Pendientes</h2>
        <?php if($carts->isEmpty()): ?>
            <p class="text-gray-600">No hay carritos pendientes.</p>
        <?php else: ?>
            <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-pink-100 text-pink-900 uppercase tracking-wide text-xs font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-left">ID Carrito</th>
                            <th class="px-4 py-3 text-left">Usuario</th>
                            <th class="px-4 py-3 text-left">Creado</th>
                            <th class="px-4 py-3 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-pink-50 transition">
                                
                                <td class="px-4 py-3 text-gray-800"><?php echo e($cart->id); ?></td>

                                
                                <td class="px-4 py-3 text-gray-800">
                                    <?php echo e(optional($cart->user)->name ?? 'Sin usuario'); ?>

                                    <?php if(optional($cart->user)->email): ?>
                                        <br>
                                        <span class="text-xs text-gray-500"><?php echo e($cart->user->email); ?></span>
                                    <?php endif; ?>
                                </td>

                                
                                <td class="px-4 py-3 text-gray-600">
                                    <?php echo e($cart->created_at->format('d/m/Y H:i')); ?>

                                </td>

                                
                                <td class="px-4 py-3">
                                    <div x-data="{ openDetail: false }" class="flex justify-center">
                                        <button @click="openDetail = true"
                                            class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition"
                                            title="Ver detalle de carrito">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        
                                        <div x-cloak x-show="openDetail"
                                            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50"
                                            @click.away="openDetail = false" x-transition:enter="ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="ease-in duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                            <div class="bg-white rounded-2xl py-8 px-6 max-w-2xl w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto flex flex-col"
                                                @keydown.escape.window="openDetail = false">
                                                
                                                <div class="flex justify-between items-center mb-6">
                                                    <h3 class="text-xl font-semibold text-pink-600">Detalle Carrito
                                                        #<?php echo e($cart->id); ?></h3>
                                                    <button @click="openDetail = false"
                                                        class="text-gray-500 hover:text-gray-700">
                                                        <i class="fas fa-times text-lg"></i>
                                                    </button>
                                                </div>

                                                
                                                <div class="space-y-4">
                                                    
                                                    <div>
                                                        <h4 class="font-semibold text-gray-700">Usuario</h4>
                                                        <p class="text-gray-800">
                                                            <?php echo e(optional($cart->user)->name ?? 'Sin usuario'); ?>

                                                            <?php if(optional($cart->user)->email): ?>
                                                                <br><span
                                                                    class="text-sm text-gray-500"><?php echo e($cart->user->email); ?></span>
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>

                                                    
                                                    <div>
                                                        <h4 class="font-semibold text-gray-700">Items en Carrito</h4>
                                                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                                                            <table class="min-w-full text-sm">
                                                                <thead class="bg-pink-100 text-pink-900 uppercase tracking-wide text-xs font-semibold">
                                                                    <tr>
                                                                        <th class="px-3 py-2 text-left">Producto</th>
                                                                        <th class="px-3 py-2 text-center">Cant.</th>
                                                                        <th class="px-3 py-2 text-right">Precio Unit.</th>
                                                                        <th class="px-3 py-2 text-right">Subtotal</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $cartSum = 0; ?>
                                                                    <?php $__currentLoopData = $cart->cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php
                                                                            $subtotal =
                                                                                $item->cantidad *
                                                                                $item->precio_unitario;
                                                                            $cartSum += $subtotal;
                                                                        ?>
                                                                        <tr class="border-t border-gray-100">
                                                                            <td class="px-3 py-2">
                                                                                <?php echo e(optional($item->product)->nombre ?? 'Producto eliminado'); ?>

                                                                            </td>
                                                                            <td class="px-3 py-2 text-center">
                                                                                <?php echo e($item->cantidad); ?></td>
                                                                            <td class="px-3 py-2 text-right">
                                                                                $<?php echo e(number_format($item->precio_unitario, 2)); ?>

                                                                            </td>
                                                                            <td class="px-3 py-2 text-right">
                                                                                $<?php echo e(number_format($subtotal, 2)); ?></td>
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr class="bg-gray-50">
                                                                        <td colspan="3"
                                                                            class="px-3 py-2 text-right font-medium">
                                                                            Subtotal:</td>
                                                                        <td class="px-3 py-2 text-right font-semibold">
                                                                            $<?php echo e(number_format($cartSum, 2)); ?></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    
                                                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                                        <div>
                                                            <p>Creado</p>
                                                            <p class="font-medium">
                                                                <?php echo e($cart->created_at->format('d/m/Y H:i')); ?></p>
                                                        </div>
                                                        <div>
                                                            <p>Estado</p>
                                                            <p class="font-medium capitalize"><?php echo e($cart->status); ?></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="mt-6 flex justify-end">
                                                    <button @click="openDetail = false"
                                                        class="px-5 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded-lg transition">
                                                        Cerrar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                
                <div class="mt-4">
                    <?php echo e($carts->withQueryString()->links()); ?>

                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/admin/invoice/index.blade.php ENDPATH**/ ?>