<?php $__env->startSection('title', 'Editar ' . $work->title . ' - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md p-6">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">

                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Editar Obra</h1>
                        <p class="text-gray-600 mt-1">Actualiza la información de <?php echo e($work->title); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form action="<?php echo e(route('admin.works.update', $work)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Título -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Título <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    name="title"
                    id="title"
                    required
                    value="<?php echo e(old('title', $work->title)); ?>"
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <?php $__errorArgs = ['title'];
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

            <!-- Tipo -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                    Tipo <span class="text-red-500">*</span>
                </label>
                <select name="type" id="type" required
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="">Selecciona un tipo</option>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" <?php echo e(old('type', $work->type) == $key ? 'selected' : ''); ?>>
                        <?php echo e($label); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['type'];
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

            <!-- Año -->
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                    Año de Lanzamiento
                </label>
                <input type="number"
                    name="year"
                    id="year"
                    value="<?php echo e(old('year', $work->year)); ?>"
                    min="1900"
                    max="<?php echo e(date('Y') + 5); ?>"
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <?php $__errorArgs = ['year'];
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

            <!-- Nuevo Poster -->
            <div class="col-span-2">
                <?php if($work->poster): ?>
                <span class="font-medium">Póster actual:</span>
                <img src="<?php echo e(asset('storage/' . $work->poster)); ?>"
                    alt="<?php echo e($work->title); ?>"
                    class="h-20 object-cover mt-2">
                <?php else: ?>
                <span class="font-medium">Póster:</span>
                <span class="ml-2 text-gray-500">No tiene póster</span>
                <?php endif; ?>
            </div>
            <div>
                <label for="poster" class="block text-sm font-medium text-gray-700 mb-2">
                    Cambiar Póster
                </label>
                <input type="file"
                    name="poster"
                    id="poster"
                    accept="image/*"
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener el póster actual</p>
                <?php $__errorArgs = ['poster'];
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
                    Descripción
                </label>
                <textarea name="description"
                    id="description"
                    rows="6"
                    placeholder="Describe la obra, su trama, personajes principales..."
                    class="w-full border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"><?php echo e(old('description', $work->description)); ?></textarea>
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
                    <?php if($work->actors_count > 0): ?>
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                        Esta obra tiene <?php echo e($work->actors_count); ?> actor(es) asociado(s)
                    </p>
                    <?php endif; ?>
                </div>
                <div class="flex space-x-4">
                    <a href="<?php echo e(route('admin.works')); ?>"
                        class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200 font-medium">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-rosa-electrico hover:bg-naranja-vibrante text-white px-4 py-2 flex items-center text-sm font-semibold transition-colors duration-300">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Obra
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/admin/works/edit.blade.php ENDPATH**/ ?>