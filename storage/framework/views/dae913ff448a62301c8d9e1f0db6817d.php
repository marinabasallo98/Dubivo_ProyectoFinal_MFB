<?php $__env->startSection('title', 'Actores de Voz - Dubivo'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Actores de Voz</h1>

        <?php if(auth()->guard()->check()): ?>
        <?php if(auth()->user()->role === 'admin'): ?>
        <a href="<?php echo e(route('admin.actors.create')); ?>"
            class="bg-verde-menta text-white px-6 py-3 hover:bg-verde-menta hover:bg-opacity-90 transition duration-200 flex items-center font-semibold">
            <i class="fas fa-plus mr-2"></i>
            Nuevo Actor
        </a>
        <?php endif; ?>
        <?php endif; ?>
    </div>

    <p class="text-gray-600 mb-8 max-w-3xl text-lg">
        Descubre a las mejores voces del doblaje de España y al talento emergente en nuestra plataforma.
    </p>

    <div class="lg:hidden mb-4">
        <button id="filterToggle" class="bg-azul-profundo text-white px-4 py-2 hover:bg-azul-profundo hover:bg-opacity-90 transition duration-200 flex items-center font-semibold w-full justify-center">
            <i class="fas fa-filter mr-2"></i>
            Mostrar Filtros
        </button>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Filtros -->
        <div id="filterColumn" class="lg:w-1/4 hidden lg:block">
            <div class="bg-white p-6 shadow-md sticky top-4 border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Filtros</h2>
                    <button id="closeFilters" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <form method="GET" action="<?php echo e(route('actors.index')); ?>" id="filter-form">

                    <!-- Buscador -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Actor</label>
                        <input type="text" name="search" placeholder="Ej: Constantino..."
                            class="w-full border border-gray-300 px-4 py-2 focus:border-azul-profundo focus:ring-azul-profundo"
                            value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-semibold text-lg mb-2">Disponibilidad</h3>

                        
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="availability" value="1"
                                <?php echo e(request('availability') === '1' ? 'checked' : ''); ?>

                                class="form-radio h-4 w-4 text-verde-menta accent-verde-menta">
                            <span>Disponible</span>
                        </label>

                        
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="availability" value="0"
                                <?php echo e(request('availability') === '0' ? 'checked' : ''); ?>

                                
                                class="form-radio h-4 w-4 text-red-600 accent-red-600">
                            <span>No Disponible</span>
                        </label>

                        
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="availability" value=""
                                <?php echo e(request('availability') === null || request('availability') === '' ? 'checked' : ''); ?>

                                class="form-radio h-4 w-4 text-gray-500 accent-gray-500">
                            <span>Cualquiera</span>
                        </label>
                    </div>

                    
                    <div class="space-y-2 mt-4">
                        <h3 class="font-semibold text-lg mb-2">Géneros</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="genders[]" value="<?php echo e($gender); ?>"
                                    <?php echo e(in_array($gender, request('genders', [])) ? 'checked' : ''); ?>

                                    class="form-checkbox h-4 w-4 text-naranja-vibrante accent-naranja-vibrante rounded">
                                <span><?php echo e($gender); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="space-y-2 mt-4">
                        <h3 class="font-semibold text-lg mb-2">Edad Vocal</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php $__currentLoopData = $voiceAges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="voice_ages[]" value="<?php echo e($age); ?>"
                                    <?php echo e(in_array($age, request('voice_ages', [])) ? 'checked' : ''); ?>

                                    class="form-checkbox h-4 w-4 text-rosa-electrico accent-rosa-electrico rounded">
                                <span><?php echo e($age); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="space-y-2 mt-4">
                        <h3 class="font-semibold text-lg mb-2">Escuelas</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="schools[]" value="<?php echo e($school->id); ?>"
                                    <?php echo e(in_array($school->id, request('schools', [])) ? 'checked' : ''); ?>

                                    class="form-checkbox h-4 w-4 text-ambar accent-ambar rounded">
                                <span><?php echo e($school->name); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="flex flex-col space-y-3 mt-8">
                        
                        <button type="submit"
                            class="bg-verde-menta text-negro px-4 py-2 font-bold rounded-lg 
               shadow-lg hover:bg-verde-menta/80 transition duration-300">
                            <i class="fas fa-search mr-2"></i>
                            Aplicar Filtros
                        </button>

                        
                        
                        <a href="<?php echo e(route('actors.index')); ?>"
                            class="text-center bg-negro text-white px-4 py-2 font-semibold rounded-lg 
               shadow-lg hover:bg-gray-700 transition duration-300">
                            <i class="fas fa-undo-alt mr-2"></i>
                            Limpiar Filtros
                        </a>
                    </div>

                </form>
            </div>
        </div>

        <!-- Resultados -->
        <div class="lg:w-3/4">
            <div class="mb-4">
                <p class="text-sm text-gray-600"><?php echo e($actors->total()); ?> actores encontrados</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $actors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="actor-card bg-white shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-naranja-vibrante flex flex-col h-full relative">

                    <!-- Foto -->
                        <div class="absolute top-2 right-2 z-30">
                            <div class="w-4 h-4 <?php echo e($actor->is_available ? 'bg-verde-menta' : 'bg-rojo-intenso'); ?> border border-white shadow-sm"></div>
                        </div>
                        <?php if($actor->photo): ?>
                        <img src="<?php echo e(asset('storage/' . $actor->photo)); ?>" alt="<?php echo e($actor->name); ?>" class="w-full h-64 object-cover">
                        <?php else: ?>
                        <div class="w-full h-64 bg-gray-100 flex items-center justify-center group-hover:bg-gray-200">
                            <i class="fas fa-user text-gray-400 text-4xl"></i>
                        </div>
                        <?php endif; ?>

                    <!-- Info -->
                    <a href="<?php echo e(route('actors.show', $actor)); ?>" class="block p-4 flex flex-col flex-1">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2"><?php echo e($actor->name); ?></h3>
                        <p class="text-gray-600 text-sm mb-1"><strong>Géneros:</strong> <?php echo e(implode(', ', $actor->genders_array) ?: 'No especificado'); ?></p>
                        <p class="text-gray-600 text-sm mb-1"><strong>Edades vocales:</strong> <?php echo e(implode(', ', $actor->voice_ages_array) ?: 'No especificado'); ?></p>
                        <?php if($actor->bio): ?>
                        <p class="text-gray-700 text-sm line-clamp-2"><?php echo e(Str::limit($actor->bio, 100)); ?></p>
                        <?php endif; ?>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-12 col-span-full">
                    <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-500 mb-2">No se encontraron actores</h3>
                    <p class="text-gray-400">Intenta con otros términos de búsqueda o ajusta los filtros.</p>
                </div>
                <?php endif; ?>
            </div>

            <div class="mt-6">
                <?php echo e($actors->links()); ?>

            </div>
        </div>
    </div>
</div>

<audio id="globalAudio" class="hidden"></audio>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle filtros móvil
        const filterToggle = document.getElementById('filterToggle');
        const filterColumn = document.getElementById('filterColumn');
        const closeFilters = document.getElementById('closeFilters');
        if (filterToggle && filterColumn) {
            filterToggle.addEventListener('click', () => filterColumn.classList.toggle('hidden'));
            if (closeFilters) closeFilters.addEventListener('click', () => filterColumn.classList.add('hidden'));
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/actors/index.blade.php ENDPATH**/ ?>