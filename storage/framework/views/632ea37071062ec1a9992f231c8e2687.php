

<?php $__env->startSection('title', 'Registrarse como Actor - Dubivo'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 px-4">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Icono y título -->
        <div class="bg-rosa-electrico bg-opacity-20 w-16 h-16 flex items-center justify-center mx-auto mb-4 border border-rosa-electrico">
            <i class="fas fa-microphone text-rosa-electrico text-2xl"></i>
        </div>
        <h2 class="text-center text-3xl font-bold text-gray-800">
            Registrarse como Actor
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Crea tu perfil profesional de actor de doblaje
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 shadow-md border border-gray-200">
            <form action="<?php echo e(route('register.actor.submit')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>

                <!-- Nombre completo -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre completo</label>
                    <input type="text" name="name" id="name" required value="<?php echo e(old('name')); ?>"
                        class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico">
                    <?php $__errorArgs = ['name'];
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

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" required value="<?php echo e(old('email')); ?>"
                        class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico">
                    <?php $__errorArgs = ['email'];
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

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                    <input type="password" name="password" id="password" required
                        class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico">
                    <?php $__errorArgs = ['password'];
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

                <!-- Confirmar contraseña -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico">
                </div>

                <!-- Botón de registro -->
                <div>
                    <button type="submit"
                        class="w-full bg-rosa-electrico hover:bg-rosa-electrico hover:bg-opacity-90 text-white py-3 px-4 font-semibold transition duration-200">
                        Crear perfil de actor
                    </button>
                </div>

                <!-- Enlace a login -->
                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        ¿Ya tienes cuenta?
                        <a href="<?php echo e(route('login')); ?>" class="text-azul-profundo hover:text-azul-profundo hover:bg-opacity-90 font-medium">
                            Inicia sesión
                        </a>
                    </p>
                </div>

                <!-- Enlace a registro cliente -->
                <div class="border-t border-gray-200 pt-4 text-center">
                    <p class="text-sm text-gray-600 mb-2">¿Eres cliente en lugar de actor?</p>
                    <a href="<?php echo e(route('register.client')); ?>" class="text-ambar hover:text-ambar hover:bg-opacity-90 font-medium text-sm">
                        Registrarse como Cliente
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/auth/register-actor.blade.php ENDPATH**/ ?>