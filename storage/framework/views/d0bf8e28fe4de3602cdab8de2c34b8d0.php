

<?php $__env->startSection('title', 'Confirmar pedido'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-2xl p-8 mt-10 space-y-8">
        <h2 class="text-3xl font-bold text-pink-700">Confirmación de pedido</h2>

        
        <div class="bg-pink-50 p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-pink-800 mb-4">Datos del cliente</h3>

            <form action="<?php echo e(route('cliente.checkout.placeorder')); ?>" method="POST" class="space-y-6" id="form-checkout">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">
                        Dirección de despacho
                    </label>
                    <input type="text" name="direccion" id="direccion" required
                        value="<?php echo e(old('direccion', Auth::user()->direccion)); ?>"
                        class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none">
                    <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="metodo_pago" class="block text-sm font-medium text-gray-700 mb-1">
                        Método de pago
                    </label>
                    <select name="metodo_pago" id="metodo_pago" required
                        class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none">
                        <option value="">-- Selecciona un método de pago --</option>
                        <?php $__currentLoopData = $paymentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($paymentType->id); ?>" <?php echo e(old('metodo_pago') == $paymentType->id ? 'selected' : ''); ?>>
                                <?php echo e($paymentType->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['metodo_pago'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div id="info_pago"
                    class="text-sm text-gray-600 bg-gray-50 p-4 border border-dashed border-pink-200 rounded-lg hidden mt-2">
                    <?php $__currentLoopData = $paymentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div id="payment_type_<?php echo e($paymentType->id); ?>" class="hidden whitespace-pre-line">
                            <?php echo nl2br(e($paymentType->descripcion)); ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div id="campos_extra_pago" class="space-y-6 hidden mt-4">
                    
                    <div id="tarjeta_fields" class="hidden space-y-4">
                        <h4 class="text-lg font-medium text-pink-700">Datos de la Tarjeta</h4>
                        <div>
                            <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Número de tarjeta</label>
                            <input type="text" name="card_number" id="card_number" maxlength="19"
                                value="<?php echo e(old('card_number')); ?>"
                                placeholder="1234 5678 9012 3456"
                                class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none">
                            <?php $__errorArgs = ['card_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="expiry_month" class="block text-sm font-medium text-gray-700 mb-1">Mes expiración (MM)</label>
                                <input type="text" name="expiry_month" id="expiry_month" maxlength="2"
                                    value="<?php echo e(old('expiry_month')); ?>"
                                    placeholder="MM"
                                    class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none">
                                <?php $__errorArgs = ['expiry_month'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="expiry_year" class="block text-sm font-medium text-gray-700 mb-1">Año expiración (AA)</label>
                                <input type="text" name="expiry_year" id="expiry_year" maxlength="2"
                                    value="<?php echo e(old('expiry_year')); ?>"
                                    placeholder="AA"
                                    class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none">
                                <?php $__errorArgs = ['expiry_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div>
                            <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                            <input type="text" name="cvv" id="cvv" maxlength="4"
                                value="<?php echo e(old('cvv')); ?>"
                                placeholder="123"
                                class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none">
                            <?php $__errorArgs = ['cvv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div id="paypal_fields" class="hidden space-y-4">
                        <h4 class="text-lg font-medium text-pink-700">Datos de PayPal</h4>
                        <div>
                            <label for="paypal_email" class="block text-sm font-medium text-gray-700 mb-1">Email de PayPal</label>
                            <input type="email" name="paypal_email" id="paypal_email"
                                value="<?php echo e(old('paypal_email', Auth::user()->email)); ?>"
                                placeholder="tu-correo@ejemplo.com"
                                class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none">
                            <?php $__errorArgs = ['paypal_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div id="referencia_fields" class="hidden space-y-4">
                        <h4 class="text-lg font-medium text-pink-700">Referencia de pago</h4>
                        <div>
                            <label for="referencia" class="block text-sm font-medium text-gray-700 mb-1">Referencia (p.ej. número de transacción)</label>
                            <input type="text" name="referencia" id="referencia"
                                value="<?php echo e(old('referencia')); ?>"
                                placeholder="Ej: REF123456"
                                class="w-full px-4 py-2 border border-pink-200 rounded-lg focus:ring-2 focus:ring-pink-400 focus:outline-none">
                            <?php $__errorArgs = ['referencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-pink-800 mb-4">Resumen del pedido</h3>
                    <table class="w-full text-sm table-auto border rounded-lg overflow-hidden">
                        <thead class="bg-pink-100 text-pink-800">
                            <tr>
                                <th class="px-4 py-3 text-left">Producto</th>
                                <th class="px-4 py-3 text-center">Talla</th> 
                                <th class="px-4 py-3 text-center">Cantidad</th>
                                <th class="px-4 py-3 text-center">Precio unitario</th>
                                <th class="px-4 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 bg-white">
                            <?php $__empty_1 = true; $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="border-b border-pink-100">
                                    <td class="px-4 py-3"><?php echo e($item->product->nombre ?? 'Producto eliminado'); ?></td>
                                    <td class="px-4 py-3 text-center">
                                        <?php echo e($item->size?->etiqueta ?? '—'); ?>

                                    </td>
                                    <td class="px-4 py-3 text-center"><?php echo e($item->cantidad); ?></td>
                                    <td class="px-4 py-3 text-center">$<?php echo e(number_format($item->precio_unitario, 2)); ?></td>
                                    <td class="px-4 py-3 text-right font-semibold">
                                        $<?php echo e(number_format($item->cantidad * $item->precio_unitario, 2)); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500">Tu carrito está vacío.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

                <div class="text-right mt-4">
                    <p class="text-xl font-bold text-pink-700">
                        Total a pagar: $<?php echo e(number_format($total, 2)); ?>

                    </p>
                </div>

                
                <div class="mt-8 flex justify-between items-center">
                    <a href="<?php echo e(route('cliente.store')); ?>" class="text-sm text-gray-600 hover:text-pink-600 transition-all">
                        ← Seguir comprando
                    </a>
                    <button type="submit"
                        class="bg-pink-600 hover:bg-pink-700 text-white font-semibold px-6 py-2 rounded-lg transition-all">
                        Confirmar pedido
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const metodoPago = document.getElementById('metodo_pago');
        const infoPago = document.getElementById('info_pago');
        const opciones = {};
        const camposExtra = document.getElementById('campos_extra_pago');
        const tarjetaFields = document.getElementById('tarjeta_fields');
        const paypalFields = document.getElementById('paypal_fields');
        const referenciaFields = document.getElementById('referencia_fields');

        <?php $__currentLoopData = $paymentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paymentType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            opciones["<?php echo e($paymentType->id); ?>"] = document.getElementById("payment_type_<?php echo e($paymentType->id); ?>");
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        function mostrarInfoPago() {
            const valor = metodoPago.value;
            // Primero ocultar todo
            infoPago.classList.add('hidden');
            Object.values(opciones).forEach(div => div.classList.add('hidden'));
            tarjetaFields.classList.add('hidden');
            paypalFields.classList.add('hidden');
            referenciaFields.classList.add('hidden');

            if (!valor) {
                camposExtra.classList.add('hidden');
                return;
            }

            // Mostrar descripción genérica
            if (opciones[valor]) {
                infoPago.classList.remove('hidden');
                opciones[valor].classList.remove('hidden');
            }

            // Mostrar campos extra según nombre o ID
            // Ajusta estos IDs o nombres según tu seed de payment_types
            const selectedOption = metodoPago.options[metodoPago.selectedIndex].text.toLowerCase();
            camposExtra.classList.remove('hidden');

            if (selectedOption.includes('tarjeta')) {
                // Si es Tarjeta de Crédito o Débito
                tarjetaFields.classList.remove('hidden');
            } else if (selectedOption.includes('paypal')) {
                paypalFields.classList.remove('hidden');
            } else if (selectedOption.toLowerCase().includes('transferencia')) {
                referenciaFields.classList.remove('hidden');
            } else {
                // Otros métodos (p.ej. efectivo): quizá no requieren datos extra
                // Podrías no mostrar nada o, si es necesario, pedir confirmación manual
            }
        }

        metodoPago.addEventListener('change', mostrarInfoPago);
        document.addEventListener('DOMContentLoaded', mostrarInfoPago);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.cliente', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/cliente/checkout.blade.php ENDPATH**/ ?>