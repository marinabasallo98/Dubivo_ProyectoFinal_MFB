

<?php $__env->startSection('title', 'Editar ' . $school->name . ' - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md p-6">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Editar Escuela</h1>
                        <p class="text-gray-600 mt-1">Actualiza la información de <?php echo e($school->name); ?></p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Formulario -->
        <form action="<?php echo e(route('admin.schools.update', $school)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre de la Escuela <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    name="name"
                    id="name"
                    required
                    value="<?php echo e(old('name', $school->name)); ?>"
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
                    value="<?php echo e(old('city', $school->city)); ?>"
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
                    value="<?php echo e(old('founded_year', $school->founded_year)); ?>"
                    min="1900"
                    max="<?php echo e(date('Y')); ?>"
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
                    value="<?php echo e(old('website', $school->website)); ?>"
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
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"><?php echo e(old('description', $school->description)); ?></textarea>
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
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <div>
                    <?php if($school->actors_count > 0): ?>
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                        Esta escuela tiene <?php echo e($school->actors_count); ?> actor(es) asociado(s)
                    </p>
                    <?php endif; ?>
                </div>
                <div class="flex space-x-4">
                    <a href="<?php echo e(route('admin.schools')); ?>"
                        class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200 font-medium">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-rosa-electrico hover:bg-naranja-vibrante text-white px-4 py-2 flex items-center text-m font-semibold transition-colors duration-300"> <i class="fas fa-save mr-2"></i>
                        Actualizar Escuela
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/admin/schools/edit.blade.php ENDPATH**/ ?>