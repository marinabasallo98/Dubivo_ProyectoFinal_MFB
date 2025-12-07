

<?php $__env->startSection('title', 'Crear Nueva Escuela - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md p-6">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-6">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 mr-4">
                    <i class="fas fa-school text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Crear Nueva Escuela</h1>
                    <p class="text-gray-600 mt-1">Añade una nueva escuela de doblaje al sistema</p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="<?php echo e(route('admin.schools.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>

            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre de la Escuela <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    name="name"
                    id="name"
                    required
                    value="<?php echo e(old('name')); ?>"
                    placeholder="Ej: Escuela Superior de Doblaje de Madrid"
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Ciudad -->
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                    Ciudad <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    name="city"
                    id="city"
                    required
                    value="<?php echo e(old('city')); ?>"
                    placeholder="Ej: Madrid, Barcelona, Sevilla..."
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Año de Fundación -->
            <div>
                <label for="founded_year" class="block text-sm font-medium text-gray-700 mb-2">
                    Año de Fundación
                </label>
                <input type="number"
                    name="founded_year"
                    id="founded_year"
                    value="<?php echo e(old('founded_year')); ?>"
                    min="1900"
                    max="<?php echo e(date('Y')); ?>"
                    placeholder="Ej: 1995"
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <?php $__errorArgs = ['founded_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Logo -->
            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                    Logo de la escuela
                </label>
                <input type="file" name="logo" id="logo"
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Sitio Web -->
            <div>
                <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                    Sitio Web
                </label>
                <input type="url"
                    name="website"
                    id="website"
                    value="<?php echo e(old('website')); ?>"
                    placeholder="Ej: https://www.escuela-doblaje.com"
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Descripción -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Descripción <span class="text-red-500">*</span>
                </label>
                <textarea name="description"
                    id="description"
                    rows="6"
                    required
                    placeholder="Describe la escuela, su metodología, profesores destacados, instalaciones..."
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('admin.schools')); ?>"
                    class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200 font-medium">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Crear Escuela
                </button>
            </div>
        </form>
    </div>

    <!-- Información de Ayuda -->
    <div class="mt-6 bg-green-50 border border-green-200 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-green-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-green-800">Consejos para crear una escuela</h3>
                <div class="mt-2 text-sm text-green-700">
                    <p>• Incluye información relevante sobre la metodología de enseñanza</p>
                    <p>• Menciona profesores o profesionales destacados si los hay</p>
                    <p>• Describe las instalaciones y equipos disponibles</p>
                    <p>• Incluye el enlace al sitio web oficial si existe</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/admin/schools/create.blade.php ENDPATH**/ ?>