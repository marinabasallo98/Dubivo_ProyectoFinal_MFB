<?php $__env->startSection('title', 'Gestión de Actores - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Gestión de Actores</h1>
                <p class="text-gray-600 mt-2">Administra todos los actores registrados en el sistema</p>
            </div>
            <a href="<?php echo e(route('admin.actors.create')); ?>"
                class="bg-naranja-vibrante hover:bg-rosa-electrico text-white transition-colors duration-300  px-4 py-2 flex items-center h-[42px] font-medium">
                <i class="fas fa-plus mr-2"></i>
                Nuevo Actor
            </a>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="space-y-4 mb-6">
        <!-- Primera fila: Totales principales -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <!-- Total Actores -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-blue-600"><?php echo e($actors->total()); ?></div>
                <div class="text-sm text-gray-600">Total Actores</div>
            </div>

            <!-- Disponibles -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-green-600"><?php echo e($actors->where('is_available', true)->count()); ?></div>
                <div class="text-sm text-gray-600">Disponibles</div>
            </div>

            <!-- No disponibles -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-red-600"><?php echo e($actors->where('is_available', false)->count()); ?></div>
                <div class="text-sm text-gray-600">No Disponibles</div>
            </div>
        </div>

        <!-- Segunda fila: Distribución por géneros -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <!-- Voces Masculinas -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-blue-600">
                    <?php echo e($actors->filter(function($actor) { 
                        $genders = $actor->genders;
                        if (is_string($genders)) {
                            $genders = json_decode($genders, true) ?? [];
                        }
                        return is_array($genders) && in_array('Masculino', $genders); 
                    })->count()); ?>

                </div>
                <div class="text-sm text-gray-600">Voces Masculinas</div>
            </div>

            <!-- Voces Femeninas -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-pink-600">
                    <?php echo e($actors->filter(function($actor) { 
                        $genders = $actor->genders;
                        if (is_string($genders)) {
                            $genders = json_decode($genders, true) ?? [];
                        }
                        return is_array($genders) && in_array('Femenino', $genders); 
                    })->count()); ?>

                </div>
                <div class="text-sm text-gray-600">Voces Femeninas</div>
            </div>

            <!-- Voces Otro -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-purple-600">
                    <?php echo e($actors->filter(function($actor) { 
                        $genders = $actor->genders;
                        if (is_string($genders)) {
                            $genders = json_decode($genders, true) ?? [];
                        }
                        return is_array($genders) && in_array('Otro', $genders); 
                    })->count()); ?>

                </div>
                <div class="text-sm text-gray-600">Otros Géneros</div>
            </div>
        </div>
    </div>

    <!-- Filtros Mejorados -->
    <div class="bg-white shadow-md p-4 mb-6 border border-gray-200">
        <form method="GET" action="<?php echo e(route('admin.actors')); ?>" id="filterForm" class="flex flex-wrap gap-4 items-end">
            <!-- Búsqueda por nombre -->
            <div class="min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar Actor</label>
                <input type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Nombre del actor..."
                    class="w-full border border-gray-300 px-3 py-2 search-input">
            </div>

            <!-- Género -->
            <div class="min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Género</label>
                <select name="gender" class="w-full border border-gray-300 px-3 py-2 filter-select">
                    <option value="">Todos los géneros</option>
                    <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($gender); ?>" <?php echo e(request('gender') == $gender ? 'selected' : ''); ?>>
                        <?php echo e($gender); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Edad Vocal -->
            <div class="min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Edad Vocal</label>
                <select name="voice_age" class="w-full border border-gray-300 px-3 py-2 filter-select">
                    <option value="">Todas las edades</option>
                    <?php $__currentLoopData = $voiceAges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($age); ?>" <?php echo e(request('voice_age') == $age ? 'selected' : ''); ?>>
                        <?php echo e($age); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Disponibilidad -->
            <div class="min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Disponibilidad</label>
                <select name="availability" class="w-full border border-gray-300 px-3 py-2 filter-select">
                    <option value="">Todos</option>
                    <option value="available" <?php echo e(request('availability') == 'available' ? 'selected' : ''); ?>>Disponibles</option>
                    <option value="unavailable" <?php echo e(request('availability') == 'unavailable' ? 'selected' : ''); ?>>No disponibles</option>
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-naranja-vibrante hover:bg-rosa-electrico text-white transition-colors duration-300  px-4 py-2 flex items-center h-[42px] font-medium">

                    <i class="fas fa-filter mr-2"></i> Filtrar
                </button>
                <a href="<?php echo e(route('admin.actors')); ?>" class="bg-gray-500 text-white px-4 py-2 hover:bg-gray-600 transition duration-200 flex items-center h-[42px] font-medium">
                    <i class="fas fa-times mr-2"></i> Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Lista de Actores -->
    <div class="bg-white shadow-md overflow-hidden border border-gray-200">
        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actor
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Géneros
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Edades Vocales
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Escuelas
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Obras
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $actors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <!-- Información del Actor -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <?php if($actor->photo): ?>
                                <img src="<?php echo e(asset('storage/' . $actor->photo)); ?>"
                                    alt="<?php echo e($actor->user->name); ?>"
                                    class="h-12 w-12 object-cover mr-4">
                                <?php else: ?>
                                <div class="h-12 w-12 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <?php endif; ?>
                                <div>
                                    
                                    <a href="<?php echo e(route('actors.show', $actor)); ?>"
                                        class="text-sm font-medium text-gray-900 hover:text-blue-600 transition duration-150">
                                        <?php echo e($actor->user->name); ?>

                                    </a>
                                    <div class="text-sm text-gray-500"><?php echo e($actor->user->email); ?></div>
                                </div>
                            </div>
                        </td>

                        <!-- Géneros -->
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <?php echo e($actor->genders_string ?: 'No especificado'); ?>

                            </div>
                        </td>

                        <!-- Edades Vocales -->
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <?php echo e($actor->voice_ages_string ?: 'No especificado'); ?>

                            </div>
                        </td>

                        <!-- Escuelas -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">
                                <?php echo e($actor->schools_count ?? $actor->schools->count()); ?>

                            </div>
                            <div class="text-xs text-gray-500">
                                escuelas
                            </div>
                        </td>

                        <!-- Obras -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">
                                <?php echo e($actor->works_count ?? $actor->works->count()); ?>

                            </div>
                            <div class="text-xs text-gray-500">
                                obras
                            </div>
                        </td>

                        <!-- Estado -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold 
                                <?php echo e($actor->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo e($actor->is_available ? 'Disponible' : 'No disponible'); ?>

                            </span>
                        </td>

                        <!-- Acciones - SOLO EDITAR Y ELIMINAR -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                
                                <a href="<?php echo e(route('admin.actors.edit', $actor)); ?>"
                                    class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 hover:bg-yellow-200 px-3 py-1 transition duration-150 font-medium">
                                    Editar
                                </a>

                                
                                <form action="<?php echo e(route('admin.actors.destroy', $actor)); ?>" method="POST"
                                    onsubmit="return confirm('¿Eliminar este actor?');" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-3 py-1 transition duration-150 font-medium">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-users text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No hay actores registrados</p>
                                <p class="mt-2">Comienza añadiendo el primer actor</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <?php if($actors->hasPages()): ?>
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            <?php echo e($actors->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const filterSelects = document.querySelectorAll('.filter-select');
        const searchInput = document.querySelector('.search-input');

        let searchTimeout;

        // Filtro en tiempo real para selects
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                filterForm.submit();
            });
        });

        // Filtro en tiempo real para búsqueda (con debounce)
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterForm.submit();
            }, 500);
        });
    });
</script>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/admin/actors/index.blade.php ENDPATH**/ ?>