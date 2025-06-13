

<?php $__env->startSection('title', 'Usuarios Registrados'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        /* Mejoras visuales para la tabla */
        thead th {
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.75rem;
        }

        tbody tr {
            transition: background-color 0.2s ease;
        }

        tbody td {
            vertical-align: middle;
        }

        /* Efecto hover más suave */
        .hover\:bg-pink-50:hover {
            background-color: rgba(249, 168, 212, 0.05);
        }

        /* Mejorar el enfoque en los campos de formulario */
        .focus\:ring-pink-400:focus {
            box-shadow: 0 0 0 3px rgba(249, 168, 212, 0.3);
        }
    </style>

    <div class="max-w-7xl mx-auto p-6">
        
        <div class="mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Total Usuarios Registrados: <?php echo e($users->total()); ?></h2>
        </div>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between ">
            
            <form method="GET" action="<?php echo e(route('admin.users')); ?>" class="mb-6 flex flex-wrap items-end gap-4">
                <div>
                    
                    <label for="tipo" class="block text-sm font-medium text-gray-700">Rol</label>
                    <select name="tipo" id="tipo" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="">Todos</option>
                        <option value="admin" <?php echo e(request('tipo') == 'admin' ? 'selected' : ''); ?>>Administrador</option>
                        <option value="inventario" <?php echo e(request('tipo') == 'inventario' ? 'selected' : ''); ?>>Analista de
                            Inventario</option>
                        <option value="ventas" <?php echo e(request('tipo') == 'ventas' ? 'selected' : ''); ?>>Analista de Ventas
                        </option>
                        <option value="soporte" <?php echo e(request('tipo') == 'soporte' ? 'selected' : ''); ?>>Soporte de Usuarios
                        </option>
                        <option value="cliente" <?php echo e(request('tipo') == 'cliente' ? 'selected' : ''); ?>>Cliente</option>
                    </select>
                </div>
                <div>
                    
                    <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="">Todos</option>
                        <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>Activo</option>
                        <option value="0" <?php echo e(request('status') == '0' ? 'selected' : ''); ?>>Bloqueado</option>
                    </select>
                </div>
                
                <div>
                    <button type="submit"
                        class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded">Filtrar</button>
                </div>
            </form>
            <div class="mt-4 md:mt-0 flex items-center space-x-3">
                
                <div class="relative">
                    <input type="text" placeholder="Buscar usuarios..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-400 focus:border-transparent"
                        id="searchInput">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-2.5"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                
                <a href="<?php echo e(route('admin.users.create')); ?>"
                    class="inline-flex items-center px-4 py-2 bg-pink-600 text-white rounded-lg shadow hover:bg-pink-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                    Agregar Usuario
                </a>
            </div>
        </div>


        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="usersTable">
                    <thead class="bg-pink-50 text-pink-800">
                        <tr>
                            <th class="py-4 px-6 text-left">ID</th>
                            <th class="py-4 px-6 text-left">Usuario</th>
                            <th class="py-4 px-6 text-left">Email</th>
                            <th class="py-4 px-6 text-left">Rol</th>
                            <th class="py-4 px-6 text-left">Estado</th>
                            <th class="py-4 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-pink-50 transition-colors" data-name="<?php echo e(strtolower($user->name)); ?>"
                                data-email="<?php echo e(strtolower($user->email)); ?>" data-id="<?php echo e(strtolower($user->id)); ?>"
                                data-rol="<?php echo e(strtolower($user->tipo)); ?>">
                                <td class="py-4 px-6 font-medium text-gray-500"><?php echo e($user->id); ?></td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="font-medium text-gray-900"><?php echo e($user->name); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo e($user->direccion ?? 'Sin dirección'); ?>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6"><?php echo e($user->email); ?></td>
                                <td class="py-4 px-6">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800 capitalize">
                                        <?php echo e($user->tipo ?? 'N/A'); ?>

                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <?php if($user->status): ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Activo
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Bloqueado
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex flex-col md:flex-row justify-center items-center gap-2">
                                        
                                        <button data-modal-target="modal-edit-<?php echo e($user->id); ?>"
                                            data-modal-toggle="modal-edit-<?php echo e($user->id); ?>"
                                            class="inline-flex items-center px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50"
                                            type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Editar
                                        </button>

                                        
                                        <div x-data="{ confirmingDelete<?php echo e($user->id); ?>: false }">
                                            <form id="delete-user-<?php echo e($user->id); ?>" method="POST"
                                                action="<?php echo e(route('admin.users.destroy', $user->id)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>

                                                <button type="button"
                                                    @click="confirmingDelete<?php echo e($user->id); ?> = true"
                                                    class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>

                                            
                                            <div x-show="confirmingDelete<?php echo e($user->id); ?>" x-cloak
                                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                                                x-transition>
                                                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4"
                                                    @click.away="confirmingDelete<?php echo e($user->id); ?> = false">
                                                    <h2 class="text-lg font-bold text-red-600">¿Eliminar usuario?</h2>
                                                    <p class="text-sm text-gray-600 mt-2">¿Estás seguro de que deseas
                                                        eliminar este usuario? Esta acción no se puede deshacer.</p>

                                                    <div class="flex justify-end space-x-3 mt-6">
                                                        <button @click="confirmingDelete<?php echo e($user->id); ?> = false"
                                                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                                                            Cancelar
                                                        </button>

                                                        <button
                                                            @click="document.getElementById('delete-user-<?php echo e($user->id); ?>').submit()"
                                                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                                            Sí, eliminar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            
                            <div id="modal-edit-<?php echo e($user->id); ?>"
                                class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4"
                                aria-hidden="true">
                                <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full">
                                    <div class="p-6">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="text-xl font-semibold text-gray-800">Editar Usuario</h3>
                                            <button type="button" data-modal-hide="modal-edit-<?php echo e($user->id); ?>"
                                                class="text-gray-400 hover:text-gray-700 focus:outline-none"
                                                aria-label="Cerrar modal">
                                                <!-- Aquí puedes poner el ícono SVG de cerrar si quieres -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="flex items-center mb-6">
                                            <div
                                                class="bg-gray-200 border-2 border-dashed rounded-xl w-12 h-12 flex items-center justify-center text-gray-500 mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-semibold"><?php echo e($user->name); ?></div>
                                                <div class="text-sm text-gray-500">ID: <?php echo e($user->id); ?></div>
                                            </div>
                                        </div>

                                        <form method="POST" action="<?php echo e(route('admin.users.update', $user->id)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>

                                            <div class="space-y-4">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <!-- Nombre -->
                                                    <div>
                                                        <label for="name-<?php echo e($user->id); ?>"
                                                            class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                                        <input id="name-<?php echo e($user->id); ?>" name="name"
                                                            type="text" required
                                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent"
                                                            value="<?php echo e(old('name', $user->name)); ?>" />
                                                    </div>

                                                    <!-- Email -->
                                                    <div>
                                                        <label for="email-<?php echo e($user->id); ?>"
                                                            class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                                        <input id="email-<?php echo e($user->id); ?>" name="email"
                                                            type="email" required
                                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent"
                                                            value="<?php echo e(old('email', $user->email)); ?>" />
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <!-- Tipo -->
                                                    <div>
                                                        <label for="tipo-<?php echo e($user->id); ?>"
                                                            class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
                                                        <select id="tipo-<?php echo e($user->id); ?>" name="tipo"
                                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent">
                                                            <option value="admin"
                                                                <?php echo e(old('tipo', $user->tipo) == 'admin' ? 'selected' : ''); ?>>
                                                                Admin</option>
                                                            <option value="cliente"
                                                                <?php echo e(old('tipo', $user->tipo) == 'cliente' ? 'selected' : ''); ?>>
                                                                Cliente</option>
                                                            <option value="inventario"
                                                                <?php echo e(old('tipo', $user->tipo) == 'inventario' ? 'selected' : ''); ?>>
                                                                Inventario</option>
                                                            <option value="ventas"
                                                                <?php echo e(old('tipo', $user->tipo) == 'ventas' ? 'selected' : ''); ?>>
                                                                Ventas</option>
                                                            <option value="soporte"
                                                                <?php echo e(old('tipo', $user->tipo) == 'soporte' ? 'selected' : ''); ?>>
                                                                Soporte</option>
                                                        </select>
                                                    </div>

                                                    <!-- Estado -->
                                                    <div>
                                                        <label for="status-<?php echo e($user->id); ?>"
                                                            class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                                                        <select id="status-<?php echo e($user->id); ?>" name="status"
                                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent">
                                                            <option value="1"
                                                                <?php echo e(old('status', $user->status) == 1 ? 'selected' : ''); ?>>
                                                                Activo</option>
                                                            <option value="0"
                                                                <?php echo e(old('status', $user->status) == 0 ? 'selected' : ''); ?>>
                                                                Bloqueado</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Dirección -->
                                                <div>
                                                    <label for="direccion-<?php echo e($user->id); ?>"
                                                        class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                                    <input id="direccion-<?php echo e($user->id); ?>" name="direccion"
                                                        type="text"
                                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent"
                                                        value="<?php echo e(old('direccion', $user->direccion)); ?>" />
                                                </div>

                                                <!-- Contraseña  -->
                                                <div>
                                                    <label for="password-<?php echo e($user->id); ?>"
                                                        class="block text-pink-700 font-semibold mb-1">
                                                        Contraseña
                                                        <span class="text-xs text-gray-500">(dejar vacío para no
                                                            cambiar)</span>

                                                    </label>
                                                </div>
                                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                                    <div class="space-y-4">
                                                        <div>

                                                            <div class="mt-1 relative">
                                                                <input id="password-<?php echo e($user->id); ?>" name="password"
                                                                    type="password" autocomplete="new-password"
                                                                    placeholder="Nueva contraseña"
                                                                    class="w-full px-4 py-3 pr-12 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500" />
                                                                <button type="button"
                                                                    onclick="togglePasswordVisibility('<?php echo e($user->id); ?>', 'password')"
                                                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-500 hover:text-pink-700"
                                                                    tabindex="-1"
                                                                    aria-label="Mostrar / ocultar contraseña">
                                                                    <svg id="eye-password-<?php echo e($user->id); ?>"
                                                                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                </button>
                                                            </div>

                                                            <!-- Barra de fortaleza de contraseña -->
                                                            <div class="mt-2">
                                                                <div class="flex justify-between items-center mb-1">
                                                                    <span class="text-xs text-pink-600">Fortaleza:</span>
                                                                    <span id="strengthText-<?php echo e($user->id); ?>"
                                                                        class="text-xs font-medium">Débil</span>
                                                                </div>
                                                                <div class="w-full bg-pink-200 rounded-full h-2">
                                                                    <div id="strengthBar-<?php echo e($user->id); ?>"
                                                                        class="h-2 rounded-full transition-all duration-300 password-strength-weak"
                                                                        style="width: 0%"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Confirmar Contraseña -->
                                                        <div>
                                                            <label for="password_confirmation-<?php echo e($user->id); ?>"
                                                                class="block text-pink-700 font-semibold mb-1">Confirmar
                                                                Contraseña</label>
                                                            <div class="mt-1 relative">
                                                                <input id="password_confirmation-<?php echo e($user->id); ?>"
                                                                    name="password_confirmation" type="password"
                                                                    autocomplete="new-password"
                                                                    placeholder="Confirmar contraseña"
                                                                    class="w-full px-4 py-3 border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500" />
                                                                <button type="button"
                                                                    onclick="togglePasswordVisibility('<?php echo e($user->id); ?>', 'password_confirmation')"
                                                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-500 hover:text-pink-700"
                                                                    tabindex="-1"
                                                                    aria-label="Mostrar / ocultar confirmar contraseña">
                                                                    <svg id="eye-password_confirmation-<?php echo e($user->id); ?>"
                                                                        xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <!-- Validación de coincidencia de contraseñas -->
                                                            <div id="password-match-<?php echo e($user->id); ?>"
                                                                class="mt-1 text-sm hidden">
                                                                <span id="match-message-<?php echo e($user->id); ?>"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Requisitos de contraseña -->
                                                    <div class="lg:pl-4">
                                                        <div class="h-full flex flex-col justify-center">
                                                            <div class="mt-3 p-3 bg-pink-50 rounded-lg">
                                                                <p class="text-sm font-medium text-pink-700 mb-2">
                                                                    Requisitos de contraseña:</p>
                                                                <ul class="space-y-1 text-sm">
                                                                    <li id="length-req-<?php echo e($user->id); ?>"
                                                                        class="flex items-center requirement-unmet">
                                                                        <svg class="w-4 h-4 mr-2 text-pink-500"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                        <span>Al menos 8 caracteres</span>
                                                                    </li>
                                                                    <li id="uppercase-req-<?php echo e($user->id); ?>"
                                                                        class="flex items-center requirement-unmet">
                                                                        <svg class="w-4 h-4 mr-2 text-pink-500"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                        <span>Una letra mayúscula</span>
                                                                    </li>
                                                                    <li id="number-req-<?php echo e($user->id); ?>"
                                                                        class="flex items-center requirement-unmet">
                                                                        <svg class="w-4 h-4 mr-2 text-pink-500"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                        <span>Un número</span>
                                                                    </li>
                                                                    <li id="special-req-<?php echo e($user->id); ?>"
                                                                        class="flex items-center requirement-unmet">
                                                                        <svg class="w-4 h-4 mr-2 text-pink-500"
                                                                            fill="none" stroke="currentColor"
                                                                            stroke-width="2" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                        <span>Un carácter especial (!@#$%^&*)</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-100">
                                                <button type="button" data-modal-hide="modal-edit-<?php echo e($user->id); ?>"
                                                    class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                                    Cancelar
                                                </button>
                                                <button type="submit" id="save-btn-<?php echo e($user->id); ?>"
                                                    class="px-5 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-400">
                                                    Guardar Cambios
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>
            </div>
        </div>

        <?php if($users->hasPages()): ?>
            <div class="mt-6 bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 rounded-b-lg">
                <div class="text-sm text-gray-700">
                    Mostrando <?php echo e($users->firstItem()); ?> - <?php echo e($users->lastItem()); ?> de <?php echo e($users->total()); ?> usuarios
                </div>
                <div class="flex space-x-2">
                    <?php if($users->onFirstPage()): ?>
                        <span
                            class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Anterior</span>
                    <?php else: ?>
                        <a href="<?php echo e($users->previousPageUrl()); ?>"
                            class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Anterior</a>
                    <?php endif; ?>

                    <?php if($users->hasMorePages()): ?>
                        <a href="<?php echo e($users->nextPageUrl()); ?>"
                            class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">Siguiente</a>
                    <?php else: ?>
                        <span
                            class="px-3 py-1 rounded border border-gray-300 text-gray-400 cursor-not-allowed">Siguiente</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Buscador de usuarios
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();

            document.querySelectorAll('tbody tr').forEach(row => {
                const name = row.getAttribute('data-name');
                const email = row.getAttribute('data-email');
                const id = row.getAttribute('data-id');
                const rol = row.getAttribute('data-rol');

                if (name.includes(searchTerm) || email.includes(searchTerm) || id.includes(searchTerm) ||
                    rol.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Manejo de modales
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            const modalId = button.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);

            button.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            });
            // Inicializar validación de contraseña al abrir el modal
            const userId = modalId.split('-')[2]; // Obtener el ID del usuario del ID del modal
            initPasswordValidation(userId);
        });

        document.querySelectorAll('[data-modal-hide]').forEach(button => {
            const modalId = button.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);

            button.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            });
        });

        // Cerrar modal si se clickea fuera del contenido
        document.querySelectorAll('.fixed.inset-0.bg-black.bg-opacity-50').forEach(modal => {
            modal.addEventListener('click', e => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        });

        // Función para mostrar/ocultar contraseña (inputIdPrefix: 'password' o 'password_confirmation')
        function togglePasswordVisibility(userId, inputIdPrefix) {
            const input = document.getElementById(`${inputIdPrefix}-${userId}`);
            const eyeIcon = document.getElementById(`eye-${inputIdPrefix}-${userId}`);

            if (!input || !eyeIcon) return;

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.958 9.958 0 012.223-3.583m1.665-1.665A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.293 2.503M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
            `; // ojo tachado
            } else {
                input.type = 'password';
                eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `; // ojo normal
            }
        }

        // Función para validar requisitos de contraseña
        function validatePassword(userId) {
            const passwordInput = document.getElementById(`password-${userId}`);
            const strengthBar = document.getElementById(`strengthBar-${userId}`);
            const strengthText = document.getElementById(`strengthText-${userId}`);

            const lengthReq = document.getElementById(`length-req-${userId}`);
            const uppercaseReq = document.getElementById(`uppercase-req-${userId}`);
            const numberReq = document.getElementById(`number-req-${userId}`);
            const specialReq = document.getElementById(`special-req-${userId}`);

            const password = passwordInput.value;

            const validations = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                number: /\d/.test(password),
                special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
            };

            // Actualiza los íconos y clases según validaciones
            function updateRequirement(element, valid) {
                const svg = element.querySelector('svg');
                if (valid) {
                    element.classList.remove('requirement-unmet');
                    element.classList.add('requirement-met');
                    if (svg) {
                        svg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    `; // check icon
                    }
                } else {
                    element.classList.remove('requirement-met');
                    element.classList.add('requirement-unmet');
                    if (svg) {
                        svg.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    `; // x icon
                    }
                }
            }

            updateRequirement(lengthReq, validations.length);
            updateRequirement(uppercaseReq, validations.uppercase);
            updateRequirement(numberReq, validations.number);
            updateRequirement(specialReq, validations.special);

            // Calcular fortaleza
            let validCount = Object.values(validations).filter(v => v).length;

            // Actualizar barra de fortaleza
            let strength = 0;
            let strengthLabel = 'Muy débil';
            let strengthClass = 'password-strength-weak';

            if (password.length === 0) {
                strength = 0;
                strengthLabel = 'Muy débil';
            } else if (validCount === 1) {
                strength = 25;
                strengthLabel = 'Débil';
            } else if (validCount === 2) {
                strength = 50;
                strengthLabel = 'Regular';
                strengthClass = 'password-strength-medium';
            } else if (validCount === 3) {
                strength = 75;
                strengthLabel = 'Buena';
                strengthClass = 'password-strength-medium';
            } else if (validCount === 4) {
                strength = 100;
                strengthLabel = 'Fuerte';
                strengthClass = 'password-strength-strong';
            }

            strengthBar.style.width = strength + '%';
            strengthBar.className = 'h-2 rounded-full transition-all duration-300 ' + strengthClass;
            strengthText.textContent = strengthLabel;
            strengthText.className = 'text-xs font-medium ' + (strength >= 75 ? 'text-green-600' : strength >= 50 ?
                'text-yellow-600' : 'text-red-600');
        }

        // Validar coincidencia de contraseñas
        function validatePasswordMatch(userId) {
            const password = document.getElementById(`password-${userId}`).value;
            const confirmPassword = document.getElementById(`password_confirmation-${userId}`).value;
            const passwordMatchDiv = document.getElementById(`password-match-${userId}`);
            const matchMessage = document.getElementById(`match-message-${userId}`);

            if (!confirmPassword) {
                passwordMatchDiv.classList.add('hidden');
                return;
            }

            passwordMatchDiv.classList.remove('hidden');

            if (password === confirmPassword) {
                matchMessage.textContent = '✓ Las contraseñas coinciden';
                matchMessage.className = 'text-green-600';
            } else {
                matchMessage.textContent = '✗ Las contraseñas no coinciden';
                matchMessage.className = 'text-red-600';
            }
        }

        // Asignar eventos a los inputs para cada usuario (debes llamar esto cuando abras el modal)
        function initPasswordValidation(userId) {
            const passwordInput = document.getElementById(`password-${userId}`);
            const confirmPasswordInput = document.getElementById(`password_confirmation-${userId}`);
            const saveButton = document.getElementById(`save-btn-${userId}`);

            if (!passwordInput || !confirmPasswordInput || !saveButton) return;

            function updateButtonState() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                const lengthValid = password.length >= 8;
                const uppercaseValid = /[A-Z]/.test(password);
                const numberValid = /\d/.test(password);
                const specialValid = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);

                const allRequirementsMet = lengthValid && uppercaseValid && numberValid && specialValid;
                const passwordsMatch = password === confirmPassword;

                if (password.length === 0) {
                    saveButton.disabled = false;
                    saveButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    saveButton.classList.add('cursor-pointer');
                } else {
                    if (allRequirementsMet && passwordsMatch) {
                        saveButton.disabled = false;
                        saveButton.classList.remove('opacity-50', 'cursor-not-allowed');
                        saveButton.classList.add('cursor-pointer');
                    } else {
                        saveButton.disabled = true;
                        saveButton.classList.add('opacity-50', 'cursor-not-allowed');
                        saveButton.classList.remove('cursor-pointer');
                    }
                }
            }

            passwordInput.addEventListener('input', () => {
                validatePassword(userId);
                validatePasswordMatch(userId);
                updateButtonState();
            });

            confirmPasswordInput.addEventListener('input', () => {
                validatePasswordMatch(userId);
                updateButtonState();
            });

            // Ejecutar validación inicial
            validatePassword(userId);
            validatePasswordMatch(userId);
            updateButtonState();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/admin/users.blade.php ENDPATH**/ ?>