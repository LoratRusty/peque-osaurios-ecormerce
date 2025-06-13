<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <style>
        .requirement-met {
            color: #10b981;
        }
        .requirement-unmet {
            color: #ef4444;
        }
        .password-strength-weak {
            background-color: #ef4444;
        }
        .password-strength-medium {
            background-color: #f59e0b;
        }
        .password-strength-strong {
            background-color: #10b981;
        }
    </style>

    <h1 class="text-3xl font-bold text-pink-600 mb-6 text-center">Restablecer contraseña</h1>

    <form method="POST" action="<?php echo e(route('password.store')); ?>">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="token" value="<?php echo e($request->route('token')); ?>">

        <!-- Correo -->
        <div class="mb-4">
            <label for="email" class="block text-pink-700 font-semibold mb-1">Correo electrónico</label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="<?php echo e(old('email', $request->email)); ?>" 
                required 
                readonly
                class="mt-1 block w-full rounded-xl bg-gray-100 text-pink-800 border border-pink-300 focus:outline-none cursor-not-allowed"
            />
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-red-500 text-sm"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Contraseña -->
        <div>
            <label for="password" class="block text-pink-700 font-semibold mb-1">Contraseña</label>
            <div class="mt-1 relative">
                <input id="password" name="password" type="password" required
                   class="mt-1 block w-full rounded-xl bg-white text-pink-800 border border-pink-300 focus:border-pink-500 focus:ring focus:ring-pink-300">
                <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-500 hover:text-pink-700">
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
            </div>

            <!-- Fortaleza -->
            <div class="mt-2">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs text-pink-600">Fortaleza de la contraseña:</span>
                    <span id="strengthText" class="text-xs font-medium">Débil</span>
                </div>
                <div class="w-full bg-pink-200 rounded-full h-2">
                    <div id="strengthBar" class="h-2 rounded-full transition-all duration-300 password-strength-weak" style="width: 0%"></div>
                </div>
            </div>

            <!-- Requisitos -->
            <div class="mt-3 p-3 bg-pink-50 rounded-lg">
                <p class="text-sm font-medium text-pink-700 mb-2">Requisitos de contraseña:</p>
                <ul class="space-y-1 text-sm">
                    <li id="length-req" class="flex items-center requirement-unmet">
                        <i class="fas fa-times mr-2" id="length-icon"></i>
                        <span>Al menos 8 caracteres</span>
                    </li>
                    <li id="uppercase-req" class="flex items-center requirement-unmet">
                        <i class="fas fa-times mr-2" id="uppercase-icon"></i>
                        <span>Una letra mayúscula</span>
                    </li>
                    <li id="number-req" class="flex items-center requirement-unmet">
                        <i class="fas fa-times mr-2" id="number-icon"></i>
                        <span>Un número</span>
                    </li>
                    <li id="special-req" class="flex items-center requirement-unmet">
                        <i class="fas fa-times mr-2" id="special-icon"></i>
                        <span>Un carácter especial (!@#$%^&*)</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Confirmación -->
        <div>
            <label for="password_confirmation" class="block text-pink-700 font-semibold mb-1">Confirmar Contraseña</label>
            <div class="mt-1 relative">
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="mt-1 block w-full rounded-xl bg-white text-pink-800 border border-pink-300 focus:border-pink-500 focus:ring focus:ring-pink-300">
                <button type="button" id="toggleConfirmPassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-500 hover:text-pink-700">
                    <i class="fas fa-eye" id="eyeIconConfirm"></i>
                </button>
            </div>
            <div id="password-match" class="mt-1 text-sm hidden">
                <span id="match-message"></span>
            </div>
        </div>

        <!-- Botón -->
        <div class="flex justify-center mt-4">
            <button 
                type="submit" 
                id="reset-password-button"
                class="bg-green-400 hover:bg-green-500 text-white font-semibold px-6 py-2 rounded-full transition duration-200 opacity-50 cursor-not-allowed"
                disabled
            >
                Restablecer contraseña
            </button>
        </div>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeIconConfirm = document.getElementById('eyeIconConfirm');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        const passwordMatch = document.getElementById('password-match');
        const matchMessage = document.getElementById('match-message');
        const resetPasswordBtn = document.getElementById('reset-password-button');

        const requirements = {
            length: { element: document.getElementById('length-req'), icon: document.getElementById('length-icon') },
            uppercase: { element: document.getElementById('uppercase-req'), icon: document.getElementById('uppercase-icon') },
            number: { element: document.getElementById('number-req'), icon: document.getElementById('number-icon') },
            special: { element: document.getElementById('special-req'), icon: document.getElementById('special-icon') }
        };

        function validatePassword(password) {
            const validations = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                number: /\d/.test(password),
                special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
            };

            Object.keys(validations).forEach(key => {
                const valid = validations[key];
                const req = requirements[key];
                if (valid) {
                    req.element.classList.remove('requirement-unmet');
                    req.element.classList.add('requirement-met');
                    req.icon.classList.replace('fa-times', 'fa-check');
                } else {
                    req.element.classList.remove('requirement-met');
                    req.element.classList.add('requirement-unmet');
                    req.icon.classList.replace('fa-check', 'fa-times');
                }
            });

            const validCount = Object.values(validations).filter(v => v).length;
            updateStrengthBar(validCount, password.length);
            return Object.values(validations).every(v => v);
        }

        function updateStrengthBar(count, length) {
            let percent = 0, label = 'Muy débil', css = 'password-strength-weak';
            if (length === 0) percent = 0;
            else if (count === 1) { percent = 25; label = 'Débil'; }
            else if (count === 2) { percent = 50; label = 'Regular'; css = 'password-strength-medium'; }
            else if (count === 3) { percent = 75; label = 'Buena'; css = 'password-strength-medium'; }
            else if (count === 4) { percent = 100; label = 'Fuerte'; css = 'password-strength-strong'; }

            strengthBar.style.width = percent + '%';
            strengthBar.className = `h-2 rounded-full transition-all duration-300 ${css}`;
            strengthText.textContent = label;
            strengthText.className = 'text-xs font-medium ' + (percent >= 75 ? 'text-green-600' : percent >= 50 ? 'text-yellow-600' : 'text-red-600');
        }

        function validatePasswordMatch() {
            const pass = passwordInput.value;
            const confirm = confirmPasswordInput.value;
            if (confirm.length === 0) {
                passwordMatch.classList.add('hidden');
                return true;
            }
            passwordMatch.classList.remove('hidden');
            if (pass === confirm) {
                matchMessage.textContent = '✓ Las contraseñas coinciden';
                matchMessage.className = 'text-green-600';
                return true;
            } else {
                matchMessage.textContent = '✗ Las contraseñas no coinciden';
                matchMessage.className = 'text-red-600';
                return false;
            }
        }

        function updateButtonState() {
            const password = passwordInput.value;
            const confirm = confirmPasswordInput.value;

            const validPassword = validatePassword(password);
            const match = password === confirm && confirm.length > 0;

            const enable = validPassword && match;

            resetPasswordBtn.disabled = !enable;
            resetPasswordBtn.classList.toggle('opacity-50', !enable);
            resetPasswordBtn.classList.toggle('cursor-not-allowed', !enable);
        }


        passwordInput.addEventListener('input', () => {
            validatePassword(passwordInput.value);
            validatePasswordMatch();
            updateButtonState();
        });

        confirmPasswordInput.addEventListener('input', () => {
            validatePasswordMatch();
            updateButtonState();
        });

        togglePasswordBtn.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });

        toggleConfirmPasswordBtn.addEventListener('click', () => {
            const type = confirmPasswordInput.type === 'password' ? 'text' : 'password';
            confirmPasswordInput.type = type;
            eyeIconConfirm.classList.toggle('fa-eye');
            eyeIconConfirm.classList.toggle('fa-eye-slash');
        });
        // Inicializar validaciones
        validatePassword(passwordInput.value);
        validatePasswordMatch();
        updateButtonState();
    });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\xampp-actual\htdocs\pequenosaurios\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>