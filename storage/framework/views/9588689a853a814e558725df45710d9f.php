

<?php $__env->startSection('title', 'Gestión de Obras - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Gestión de Obras</h1>
                <p class="text-gray-600 mt-2">Administra todas las películas, series y producciones</p>
            </div>
            <a href="<?php echo e(route('admin.works.create')); ?>"
                class="bg-rosa-electrico hover:bg-naranja-vibrante text-white transition-colors duration-300  px-4 py-2 flex items-center h-[42px] font-medium">

                <i class="fas fa-plus mr-2"></i>
                Nueva Obra
            </a>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="space-y-4 mb-6">
        <!-- Primera fila: Totales y principales -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Total Obras -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-blue-600"><?php echo e($works->total()); ?></div>
                <div class="text-sm text-gray-600">Total Obras</div>
            </div>

            <!-- Total Actores -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-teal-600"><?php echo e($works->sum('actors_count')); ?></div>
                <div class="text-sm text-gray-600">Total Actores</div>
            </div>

            <!-- Películas -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-green-600"><?php echo e($works->where('type', 'movie')->count()); ?></div>
                <div class="text-sm text-gray-600">Películas</div>
            </div>

            <!-- Series -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-purple-600"><?php echo e($works->where('type', 'series')->count()); ?></div>
                <div class="text-sm text-gray-600">Series</div>
            </div>
        </div>

        <!-- Segunda fila: Resto de tipos -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <!-- Publicidad -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-yellow-600"><?php echo e($works->where('type', 'commercial')->count()); ?></div>
                <div class="text-sm text-gray-600">Publicidad</div>
            </div>

            <!-- Animación -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-pink-600"><?php echo e($works->where('type', 'animation')->count()); ?></div>
                <div class="text-sm text-gray-600">Animación</div>
            </div>

            <!-- Videojuegos -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-red-600"><?php echo e($works->where('type', 'videogame')->count()); ?></div>
                <div class="text-sm text-gray-600">Videojuegos</div>
            </div>

            <!-- Documentales -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-indigo-600"><?php echo e($works->where('type', 'documentary')->count()); ?></div>
                <div class="text-sm text-gray-600">Documentales</div>
            </div>

            <!-- Otros -->
            <div class="bg-white shadow p-4 text-center border border-gray-200">
                <div class="text-2xl font-bold text-gray-600"><?php echo e($works->where('type', 'other')->count()); ?></div>
                <div class="text-sm text-gray-600">Otros</div>
            </div>
        </div>
    </div>

    <!-- Filtros Mejorados -->
    <div class="bg-white shadow-md p-4 mb-6 border border-gray-200">
        <form method="GET" action="<?php echo e(route('admin.works')); ?>" id="filterForm" class="flex flex-wrap gap-4 items-end">
            <!-- Búsqueda por título -->
            <div class="min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar Obra</label>
                <input type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Título de la obra..."
                    class="w-full border border-gray-300 px-3 py-2 search-input">
            </div>

            <!-- Tipo -->
            <div class="min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                <select name="type" class="w-full border border-gray-300 px-3 py-2 filter-select">
                    <option value="">Todos los tipos</option>
                    <option value="movie" <?php echo e(request('type') == 'movie' ? 'selected' : ''); ?>>Película</option>
                    <option value="series" <?php echo e(request('type') == 'series' ? 'selected' : ''); ?>>Serie</option>
                    <option value="commercial" <?php echo e(request('type') == 'commercial' ? 'selected' : ''); ?>>Comercial</option>
                    <option value="animation" <?php echo e(request('type') == 'animation' ? 'selected' : ''); ?>>Animación</option>
                    <option value="videogame" <?php echo e(request('type') == 'videogame' ? 'selected' : ''); ?>>Videojuego</option>
                    <option value="documentary" <?php echo e(request('type') == 'documentary' ? 'selected' : ''); ?>>Documental</option>
                    <option value="other" <?php echo e(request('type') == 'other' ? 'selected' : ''); ?>>Otro</option>
                </select>
            </div>

            <!-- Año -->
            <div class="min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                <input type="number"
                    name="year"
                    value="<?php echo e(request('year')); ?>"
                    placeholder="Ej: 2023"
                    class="w-full border border-gray-300 px-3 py-2 filter-select"
                    min="1900"
                    max="<?php echo e(date('Y') + 5); ?>">
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-rosa-electrico hover:bg-naranja-vibrante text-white transition-colors duration-300  px-4 py-2 flex items-center h-[42px] font-medium">
                    <i class="fas fa-filter mr-2"></i> Filtrar
                </button>
                <a href="<?php echo e(route('admin.works')); ?>" class="bg-gray-500 text-white px-4 py-2 hover:bg-gray-600 transition duration-200 flex items-center h-[42px] font-medium">
                    <i class="fas fa-times mr-2"></i> Limpiar
                </a>
            </div>
        </form>
    </div>

    <!-- Lista de Obras -->
    <div class="bg-white shadow-md overflow-hidden border border-gray-200">
        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Obra
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Año
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actores
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
                    <?php $__empty_1 = true; $__currentLoopData = $works; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $work): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <!-- Información de la Obra -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <?php if($work->poster): ?>
                                <img src="<?php echo e(asset('storage/' . $work->poster)); ?>"
                                    alt="<?php echo e($work->title); ?>"
                                    class="h-12 w-12 object-cover mr-4">
                                <?php else: ?>
                                <div class="h-12 w-12 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center mr-4">
                                    <i class="fas fa-<?php echo e($work->type == 'movie' ? 'film' : ($work->type == 'series' ? 'tv' : 'bullhorn')); ?> text-white"></i>
                                </div>
                                <?php endif; ?>
                                <div>
                                    <!-- TÍTULO COMO LINK PARA VER -->
                                    <a href="<?php echo e(route('works.show', $work)); ?>"
                                        class="text-sm font-medium text-gray-900 hover:text-blue-600 transition duration-150">
                                        <?php echo e($work->title); ?>

                                    </a>
                                    <?php if($work->description): ?>
                                    <div class="text-sm text-gray-500 line-clamp-1 max-w-xs">
                                        <?php echo e(Str::limit($work->description, 50)); ?>

                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>

                        <!-- Tipo -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold 
                                    <?php echo e($work->type == 'movie' ? 'bg-blue-100 text-blue-800' : ''); ?>

                                    <?php echo e($work->type == 'series' ? 'bg-green-100 text-green-800' : ''); ?>

                                    <?php echo e($work->type == 'commercial' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                    <?php echo e($work->type == 'animation' ? 'bg-purple-100 text-purple-800' : ''); ?>

                                    <?php echo e($work->type == 'videogame' ? 'bg-red-100 text-red-800' : ''); ?> capitalize">
                                <?php echo e($types[$work->type] ?? $work->type); ?>

                            </span>
                        </td>

                        <!-- Año -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <?php echo e($work->year ?? '-'); ?>

                            </div>
                        </td>

                        <!-- Actores -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">
                                <?php echo e($work->actors_count); ?>

                            </div>
                            <div class="text-xs text-gray-500">
                                actores participantes
                            </div>
                        </td>

                        <!-- Estado -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold 
                                    <?php echo e($work->actors_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                                <?php echo e($work->actors_count > 0 ? 'Con actores' : 'Sin actores'); ?>

                            </span>
                        </td>

                        <!-- Acciones - SOLO EDITAR Y ELIMINAR -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <!-- Botón Editar -->
                                <a href="<?php echo e(route('admin.works.edit', $work)); ?>"
                                    class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 hover:bg-yellow-200 px-3 py-1 transition duration-150 font-medium">
                                    Editar
                                </a>

                                <!-- Botón Eliminar -->
                                <form action="<?php echo e(route('admin.works.destroy', $work)); ?>" method="POST"
                                    onsubmit="return confirm('¿Eliminar esta obra?');" class="inline">
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
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-film text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No hay obras registradas</p>
                                <p class="mt-2">Comienza añadiendo la primera obra</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <?php if($works->hasPages()): ?>
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            <?php echo e($works->links()); ?>

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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/admin/works/index.blade.php ENDPATH**/ ?>