<?php $__env->startSection('title', 'Crear Perfil de Actor - Dubivo'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Crear Perfil de Actor</h1>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Formulario Principal -->
        <div class="lg:w-3/4">
            <div class="bg-white shadow-md p-6 border border-gray-200">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Completa tu perfil</h2>
                    <p class="text-gray-600 mt-2">Aparecerás en nuestro banco de voces para que los clientes te encuentren</p>
                </div>

                <form action="<?php echo e(route('actors.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <?php echo csrf_field(); ?>

                    <!-- Géneros -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Géneros que puedes interpretar <span class="text-rojo-intenso">*</span>
                        </label>
                        <div class="filter-scroll-container">
                            <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center py-1">
                                <input type="checkbox" name="genders[]" value="<?php echo e($gender); ?>"
                                    <?php echo e(in_array($gender, old('genders', [])) ? 'checked' : ''); ?>

                                    class="text-rosa-electrico focus:ring-rosa-electrico">
                                <span class="ml-2 text-sm text-gray-700"><?php echo e($gender); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php $__errorArgs = ['genders'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Edades Vocales -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Edades vocales que puedes interpretar <span class="text-rojo-intenso">*</span>
                        </label>
                        <div class="filter-scroll-container">
                            <?php $__currentLoopData = $voiceAges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center py-1">
                                <input type="checkbox" name="voice_ages[]" value="<?php echo e($age); ?>"
                                    <?php echo e(in_array($age, old('voice_ages', [])) ? 'checked' : ''); ?>

                                    class="text-naranja-vibrante focus:ring-naranja-vibrante">
                                <span class="ml-2 text-sm text-gray-700"><?php echo e($age); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php $__errorArgs = ['voice_ages'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Disponibilidad -->
                    <div>
                        <h3 class="font-medium text-gray-700 mb-3">Disponibilidad</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="is_available" value="1"
                                    <?php echo e(old('is_available', true) ? 'checked' : ''); ?>

                                    class="text-verde-menta focus:ring-verde-menta">
                                <span class="ml-2 text-sm text-gray-700">Disponible</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="is_available" value="0"
                                    <?php echo e(!old('is_available', true) ? 'checked' : ''); ?>

                                    class="text-rojo-intenso focus:ring-rojo-intenso">
                                <span class="ml-2 text-sm text-gray-700">No disponible</span>
                            </label>
                        </div>
                        <?php $__errorArgs = ['is_available'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Biografía -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                            Biografía <span class="text-rojo-intenso">*</span>
                        </label>
                        <textarea name="bio" id="bio" rows="4"
                            class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200"
                            placeholder="Cuéntanos sobre tu experiencia, formación y especialidades..."><?php echo e(old('bio')); ?></textarea>
                        <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Archivos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Foto de Perfil -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto de Perfil
                            </label>
                            <input type="file" name="photo" id="photo"
                                accept="image/*"
                                class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico transition duration-200">
                            <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máx: 2MB</p>
                            <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Muestra de Audio -->
                        <div>
                            <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                                Muestra de Voz
                            </label>
                            <input type="file" name="audio_path" id="audio_path"
                                accept="audio/*"
                                class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200">
                            <p class="text-xs text-gray-500 mt-1">Formatos: MP3, WAV. Máx: 5MB</p>
                            <?php $__errorArgs = ['audio_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Escuelas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Escuelas</label>
                        <div class="filter-scroll-container">
                            <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center py-1">
                                <input type="checkbox" name="schools[]" value="<?php echo e($school->id); ?>"
                                    class="text-azul-profundo focus:ring-azul-profundo"
                                    <?php echo e(in_array($school->id, old('schools', [])) ? 'checked' : ''); ?>>
                                <span class="ml-2 text-sm text-gray-700"><?php echo e($school->name); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php $__errorArgs = ['schools'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="mt-8">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Obras Destacadas (Experiencia)
                        </label>
                        <p class="text-xs text-gray-500 mb-3">Selecciona las obras y especifica el personaje.</p>

                        <?php
                        $selectedWorkIds = old('works', []);
                        $oldCharacters = old('character_names', []);
                        ?>

                        <div class="border border-gray-300 bg-gray-50 p-4 rounded max-h-80 overflow-y-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php $__empty_1 = true; $__currentLoopData = $works; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $work): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                $workId = $work->id;
                                $isChecked = in_array($workId, $selectedWorkIds);
                                $characterValue = $oldCharacters[$workId] ?? '';
                                ?>

                                <div class="bg-white border border-gray-200 p-3 rounded hover:shadow-md transition-shadow duration-200">
                                    <label class="flex items-start cursor-pointer">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="works[]" value="<?php echo e($workId); ?>"
                                                class="w-4 h-4 text-azul-profundo border-gray-300 rounded focus:ring-azul-profundo"
                                                <?php echo e($isChecked ? 'checked' : ''); ?>>
                                        </div>
                                        <div class="ml-2 text-sm w-full">
                                            <span class="font-medium text-gray-800"><?php echo e($work->title); ?></span>
                                            <span class="text-xs text-gray-500 block">(<?php echo e($work->year ?? 'Año N/A'); ?>)</span>
                                        </div>
                                    </label>

                                    <div class="mt-2 ml-6">
                                        <input type="text" name="character_names[<?php echo e($workId); ?>]"
                                            value="<?php echo e($characterValue); ?>"
                                            placeholder="Personaje..."
                                            class="w-full text-xs border-b border-gray-300 py-1 focus:outline-none focus:border-azul-profundo bg-transparent transition-colors placeholder-gray-400">
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-span-2 text-center text-gray-500 py-4">
                                    No hay obras registradas en el sistema.
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php $__errorArgs = ['works'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-rojo-intenso text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="<?php echo e(route('dashboard')); ?>"
                            class="bg-gray-500 text-white px-6 py-2 hover:bg-gray-600 flex items-center font-semibold transition duration-200">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                        <button type="submit"
                            class="bg-verde-menta text-white px-6 py-2 hover:bg-verde-menta hover:bg-opacity-90 flex items-center font-semibold transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Crear Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna de Información Lateral -->
        <div class="lg:w-1/4">
            <div class="bg-white p-6 shadow-md sticky top-4 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Información importante</h2>

                <div class="space-y-4 text-sm text-gray-600">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Puedes seleccionar <strong>múltiples géneros y edades vocales</strong></span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Tu perfil será visible para clientes y productores</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Puedes actualizar tu información en cualquier momento</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>La muestra de voz ayuda a los clientes a conocer tu talento</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .object-cover {
        object-fit: cover;
        object-position: center top;
    }

    * {
        border-radius: 0 !important;
    }

    .filter-scroll-container {
        max-height: 10rem;
        overflow-y: auto;
        padding: 8px 12px;
        margin: 0 -12px;
        border: 1px solid #e5e7eb;
        background-color: #f9fafb;
    }

    .filter-scroll-container label {
        padding: 6px 4px;
        margin: 2px 0;
        border-radius: 0 !important;
    }

    .filter-scroll-container input[type="checkbox"]:focus {
        outline: 2px solid #3b82f6;
        outline-offset: 2px;
    }

    .filter-scroll-container::-webkit-scrollbar {
        width: 6px;
    }

    .filter-scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .filter-scroll-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 0;
    }

    .filter-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    .bg-verde-menta {
        background-color: #10b981 !important;
    }

    .bg-rojo-intenso {
        background-color: #ef4444 !important;
    }
</style>
<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const worksCheckboxes = document.querySelectorAll('.work-checkbox');

        worksCheckboxes.forEach(checkbox => {
            const workId = checkbox.dataset.workId;
            // Seleccionamos el input del nombre del personaje asociado
            const characterInput = document.querySelector(`input[name="character_names[${workId}]"]`);

            // Función para habilitar/deshabilitar el input del personaje
            const toggleCharacterInput = (isChecked) => {
                if (characterInput) {
                    if (isChecked) {
                        // Si la casilla está marcada, habilitamos el input
                        characterInput.disabled = false;
                        characterInput.classList.remove('bg-gray-100', 'text-gray-500'); // Revertimos estilos de deshabilitado
                    } else {
                        // Si la casilla está desmarcada, deshabilitar y limpiar el valor
                        characterInput.disabled = true;
                        characterInput.value = ''; // Limpiamos el valor para que no se envíe al servidor
                        characterInput.classList.add('bg-gray-100', 'text-gray-500'); // Aplicar estilos de deshabilitado
                    }
                }
            };

            // 1. Inicializar el estado al cargar la página (para valores old() o recarga)
            toggleCharacterInput(checkbox.checked);

            // 2. Escuchar el evento de cambio
            checkbox.addEventListener('change', (event) => {
                toggleCharacterInput(event.target.checked);
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/actors/create.blade.php ENDPATH**/ ?>