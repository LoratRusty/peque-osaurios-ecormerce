<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'id',
    'title' => 'Confirmar eliminación',
    'message' => '¿Estás seguro que deseas eliminar este ítem?',
    'confirmIdVar' => 'confirmingDeleteId',
    'cancelText' => 'Cancelar',
    'confirmText' => 'Sí, eliminar',
    'confirmColor' => 'red',
    'formSelector' => null, // Nuevo: selector CSS personalizado
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'id',
    'title' => 'Confirmar eliminación',
    'message' => '¿Estás seguro que deseas eliminar este ítem?',
    'confirmIdVar' => 'confirmingDeleteId',
    'cancelText' => 'Cancelar',
    'confirmText' => 'Sí, eliminar',
    'confirmColor' => 'red',
    'formSelector' => null, // Nuevo: selector CSS personalizado
]); ?>
<?php foreach (array_filter(([
    'id',
    'title' => 'Confirmar eliminación',
    'message' => '¿Estás seguro que deseas eliminar este ítem?',
    'confirmIdVar' => 'confirmingDeleteId',
    'cancelText' => 'Cancelar',
    'confirmText' => 'Sí, eliminar',
    'confirmColor' => 'red',
    'formSelector' => null, // Nuevo: selector CSS personalizado
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div
    x-show="<?php echo e($confirmIdVar); ?> === <?php echo e($id); ?>"
    x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
    style="left: 0; right: 0; top: 0; bottom: 0; margin: 0;"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div 
         class="bg-white rounded-lg p-6 max-w-xl w-full mx-4 shadow-xl min-h-[150px] flex flex-col justify-between overflow-y-auto max-h-[80vh]"
        @click.away="<?php echo e($confirmIdVar); ?> = null"
        @keydown.escape.window="<?php echo e($confirmIdVar); ?> = null"
    >
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-<?php echo e($confirmColor); ?>-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                </svg>
            </div>
            
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <h2 class="text-lg font-bold text-<?php echo e($confirmColor); ?>-600">
                    <?php echo e($title); ?>

                </h2>
                <div class="mt-2 text-sm text-gray-600 break-words">
                    <?php echo $message; ?>

                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <button
                type="button"
                @click="<?php echo e($confirmIdVar); ?> = null"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
            >
                <?php echo e($cancelText); ?>

            </button>

            <button
                type="button"
                @click="
                    <?php echo e($confirmIdVar); ?> = null;
                    setTimeout(() => {
                        document.querySelector('<?php echo e($formSelector ?? '#delete-'.$id); ?>').submit();
                    }, 100);
                "
                class="px-4 py-2 bg-<?php echo e($confirmColor); ?>-600 text-white rounded hover:bg-<?php echo e($confirmColor); ?>-700 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo e($confirmColor); ?>-500"
            >
                <?php echo e($confirmText); ?>

            </button>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/components/confirm-delete-modal.blade.php ENDPATH**/ ?>