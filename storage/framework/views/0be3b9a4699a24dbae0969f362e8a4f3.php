

<?php $__env->startSection('title', $school->name . ' - Dubivo'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <!-- Navegación -->
    <div class="mb-6">
        <a href="<?php echo e(route('schools.index')); ?>" class="text-blue-600 hover:text-blue-800 font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>Volver a todas las escuelas
        </a>
    </div>

    <!-- Header de la Escuela -->
    <div class="bg-white shadow-md overflow-hidden mb-6 border border-gray-200">
        <div class="bg-gradient-to-r from-rosa-electrico to-pink-700 p-8 text-white relative">
            <!-- Fondo oscuro para mejor contraste -->
            <div class="absolute inset-0 bg-black bg-opacity-20"></div>

            <div class="relative z-10 flex justify-between items-start">
                <div class="flex items-start space-x-6">
                    <!-- Logo de la escuela -->
                    <?php if($school->logo): ?>
                    <div class="flex-shrink-0">
                        <img src="<?php echo e(asset('storage/' . $school->logo)); ?>"
                            alt="<?php echo e($school->name); ?>"
                            class="w-24 h-24 border-4 border-white shadow-lg object-cover">
                    </div>
                    <?php else: ?>
                    <div class="flex-shrink-0 w-24 h-24 bg-white bg-opacity-20 border-4 border-white shadow-lg flex items-center justify-center">
                        <i class="fas fa-school text-white text-3xl"></i>
                    </div>
                    <?php endif; ?>

                    <div class="text-white">
                        <h1 class="text-4xl font-bold mb-2 text-white drop-shadow-lg"><?php echo e($school->name); ?></h1>
                        <?php if($school->city): ?>
                        <p class="text-xl mb-4 text-white drop-shadow">
                            <i class="fas fa-map-marker-alt mr-2"></i><?php echo e($school->city); ?>

                        </p>
                        <?php endif; ?>
                        <?php if($school->founded_year): ?>
                        <p class="text-lg text-white drop-shadow">
                            <i class="fas fa-calendar-alt mr-2"></i>Fundada en <?php echo e($school->founded_year); ?>

                        </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Botones de admin -->
                <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->role === 'admin'): ?>
                <div class="flex space-x-3">
                    <a href="<?php echo e(route('admin.schools.edit', $school)); ?>"
                        class="bg-white text-gray-800 px-4 py-2 hover:bg-gray-100 border border-gray-300 flex items-center font-semibold transition duration-200 shadow-lg">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </a>
                    <form action="<?php echo e(route('admin.schools.destroy', $school)); ?>" method="POST"
                        onsubmit="return confirm('¿Estás seguro de eliminar esta escuela?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                            class="bg-[#dc2626] text-white px-4 py-2 hover:bg-[#b91c1c] flex items-center font-semibold transition duration-200 shadow-lg border border-[#b91c1c]">
                            <i class="fas fa-trash mr-2"></i>Eliminar
                        </button>
                    </form>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if($school->description): ?>
    <div class="bg-white shadow-md p-6 mb-6 border border-gray-200">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Sobre la Escuela</h2>
        <p class="text-gray-700 leading-relaxed text-lg"><?php echo e($school->description); ?></p>
    </div>
    <?php endif; ?>

    <?php if($school->teachers->count() > 0): ?>
    <!-- Sección de Profesores -->
    <div class="bg-white shadow-md p-6 mb-6 border border-gray-200">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Profesores</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php $__currentLoopData = $school->teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('actors.show', $teacher)); ?>" class="block border border-gray-200 p-4 hover:bg-gray-50 transition duration-200 group">
                <div class="flex items-center mb-3">
                    <?php if($teacher->photo): ?>
                    <img src="<?php echo e(asset('storage/' . $teacher->photo)); ?>" alt="<?php echo e($teacher->name); ?>"
                        class="w-12 h-12 object-cover mr-3">
                    <?php else: ?>
                    <div class="w-12 h-12 bg-gray-200 flex items-center justify-center mr-3">
                        <i class="fas fa-user text-gray-500"></i>
                    </div>
                    <?php endif; ?>
                    <div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-blue-600"><?php echo e($teacher->name); ?></h3>
                    </div>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Actores de esta Escuela -->
    <div class="bg-white shadow-md p-6 border border-gray-200">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Actores Formados en <?php echo e($school->name); ?></h2>

        <?php if($school->actors->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php $__currentLoopData = $school->actors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('actors.show', $actor)); ?>" class="flex items-center space-x-3 p-3 border border-gray-200 hover:bg-gray-50 transition duration-200 group">
                <!-- Foto -->
                <?php if($actor->photo): ?>
                <img src="<?php echo e(asset('storage/' . $actor->photo)); ?>"
                    alt="<?php echo e($actor->user->name); ?>"
                    class="w-12 h-12 object-cover">
                <?php else: ?>
                <div class="w-12 h-12 bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-user text-gray-400"></i>
                </div>
                <?php endif; ?>

                <div class="flex-1">
                    <!-- Nombre -->
                    <h4 class="font-medium text-gray-800 group-hover:text-blue-600"><?php echo e($actor->user->name); ?></h4>

                    <!-- Géneros y edades vocales -->
                    <p class="text-gray-600 text-sm mb-2">
                        <?php echo e($actor->genders_string ?: 'Género no especificado'); ?> •
                        <?php echo e($actor->voice_ages_string ?: 'Edad no especificada'); ?>

                    </p>

                    <!-- Biografía breve -->
                    <?php if($actor->bio): ?>
                    <p class="text-gray-700 text-sm line-clamp-2">
                        <?php echo e(Str::limit($actor->bio, 80)); ?>

                    </p>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div class="text-center py-8">
            <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-500 mb-2">No hay actores registrados</h3>
            <p class="text-gray-400">Esta escuela aún no tiene actores asociados en nuestra base de datos.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    * {
        border-radius: 0 !important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/schools/show.blade.php ENDPATH**/ ?>