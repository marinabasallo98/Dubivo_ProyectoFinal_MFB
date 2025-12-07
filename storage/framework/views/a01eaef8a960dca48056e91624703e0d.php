<?php $__env->startSection('title', 'Editar mi Perfil de Actor - Dubivo'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Editar mi Perfil de Actor</h1>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="lg:w-3/4">
            <div class="bg-white shadow-md p-6 border border-gray-200">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Actualiza tu perfil</h2>
                    <p class="text-gray-600 mt-2">Mantén tu información al día para que los clientes te encuentren</p>
                </div>

                <form method="POST" action="<?php echo e(route('actor.profile.update', $actor)); ?>" enctype="multipart/form-data" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-gray-100">
                        <div>
                            <label for="name_display" class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo</label>
                            <input type="text" id="name_display" value="<?php echo e($actor->user->name); ?>"
                                class="w-full border border-gray-300 px-3 py-2 bg-gray-100 cursor-not-allowed" disabled>
                            <p class="text-xs text-gray-500 mt-1">Contacta a un administrador para cambiar tu nombre de usuario.</p>
                        </div>

                        <div>
                            <label for="email_display" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email_display" value="<?php echo e($actor->user->email); ?>"
                                class="w-full border border-gray-300 px-3 py-2 bg-gray-100 cursor-not-allowed" disabled>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Géneros que puedes interpretar <span class="text-rojo-intenso">*</span>
                        </label>
                        <?php
                        // Opciones de Género
                        $genders = ['Femenino', 'Masculino', 'Otro'];
                        $selectedGenders = old('genders', $actor->genders ?? []);
                        ?>
                        <div class="grid grid-cols-2 gap-x-4 filter-scroll-container">
                            <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center py-1">
                                <input type="checkbox" name="genders[]" value="<?php echo e($gender); ?>"
                                    <?php echo e(in_array($gender, $selectedGenders) ? 'checked' : ''); ?>

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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Edades vocales que puedes interpretar <span class="text-rojo-intenso">*</span>
                        </label>
                        <?php
                        // Opciones de Edad Vocal
                        $voiceAges = ['Niño', 'Adolescente', 'Adulto joven', 'Adulto', 'Anciano', 'Atipada'];
                        $selectedAges = old('voice_ages', $actor->voice_ages ?? []);
                        ?>
                        <div class="grid grid-cols-2 gap-x-4 filter-scroll-container">
                            <?php $__currentLoopData = $voiceAges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center py-1">
                                <input type="checkbox" name="voice_ages[]" value="<?php echo e($age); ?>"
                                    <?php echo e(in_array($age, $selectedAges) ? 'checked' : ''); ?>

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

                    <div>
                        <h3 class="font-medium text-gray-700 mb-3">Disponibilidad</h3>
                        <?php
                        $isAvailable = old('is_available', $actor->is_available);
                        ?>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="is_available" value="1"
                                    <?php echo e($isAvailable == 1 ? 'checked' : ''); ?>

                                    class="text-verde-menta focus:ring-verde-menta">
                                <span class="ml-2 text-sm text-gray-700">Disponible</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="is_available" value="0"
                                    <?php echo e($isAvailable == 0 ? 'checked' : ''); ?>

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

                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                            Biografía<span class="text-rojo-intenso">*</span>
                        </label>
                        <textarea name="bio" id="bio" rows="4"
                            class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200"
                            placeholder="Cuéntanos sobre tu experiencia, formación y especialidades..."><?php echo e(old('bio', $actor->bio)); ?></textarea>
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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Obras Destacadas (Experiencia)
                        </label>
                        <?php
                        // Prepara las obras del actor y su personaje asociado para la vista de edición
                        $actorWorks = $actor->works->keyBy('id')->map(fn($work) => $work->pivot->character_name)->toArray();

                        // Valores preseleccionados (IDs de las obras)
                        $selectedWorks = old('works', array_keys($actorWorks));

                        // Valores de los personajes (guardados o antiguos)
                        $oldCharacters = old('characters', $actorWorks);
                        ?>

                        <p class="text-xs text-gray-500 mb-3">Selecciona las obras en las que has participado y especifica el personaje que interpretaste.</p>

                        <div class="filter-scroll-container space-y-2">
                            <?php $__currentLoopData = $works; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $work): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $workId = $work->id;
                            $isChecked = in_array($workId, $selectedWorks);
                            $characterValue = $oldCharacters[$workId] ?? '';
                            ?>
                            <div class="p-2 border border-gray-300 bg-white shadow-sm">
                                <label class="flex items-center">
                                    
                                    <input type="checkbox" name="works[]" value="<?php echo e($workId); ?>"
                                        class="work-checkbox text-azul-profundo focus:ring-azul-profundo"
                                        id="work_<?php echo e($workId); ?>"
                                        <?php echo e($isChecked ? 'checked' : ''); ?>>
                                    <span class="ml-2 text-sm text-gray-800 font-semibold"><?php echo e($work->title); ?> (<?php echo e($work->year ?? 'Año Desconocido'); ?>)</span>
                                </label>

                                
                                <div class="ml-6 mt-2">
                                    <label for="character_<?php echo e($workId); ?>" class="block text-xs font-normal text-gray-600 mb-1">
                                        Personaje interpretado:
                                    </label>
                                    <input type="text" name="characters[<?php echo e($workId); ?>]" id="character_<?php echo e($workId); ?>"
                                        value="<?php echo e($characterValue); ?>"
                                        placeholder="Ej: Voz de 'Main Character'"
                                        class="w-full border border-gray-300 px-3 py-1 text-sm focus:border-azul-profundo focus:ring-azul-profundo transition duration-200">
                                    <?php $__errorArgs = ["characters.$workId"];
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
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto de Perfil
                            </label>

                            <?php if($actor->photo): ?>
                            <p class="text-xs text-gray-500 mb-1">Foto actual:
                                <a href="<?php echo e(asset('storage/' . $actor->photo)); ?>" target="_blank" class="text-naranja-vibrante">Ver</a> |
                                <button type="button" class="text-red-600 hover:underline bg-transparent border-none p-0 cursor-pointer" onclick="showDeleteConfirmation('delete-photo-form')">Eliminar</button>
                            </p>
                            <?php endif; ?>



                            <input type="file" name="photo" id="photo"
                                accept="image/*"
                                class="w-full border border-gray-300 px-3 py-2 focus:border-rosa-electrico focus:ring-rosa-electrico transition duration-200">
                            <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máx: 2MB. Sobrescribe la actual.</p>
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

                        <div>
                            <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                                Muestra de Voz
                            </label>
                            <?php if($actor->audio_path): ?>
                            <p class="text-xs text-gray-500 mb-1">Audio actual:
                                <a href="<?php echo e(asset('storage/' . $actor->audio_path)); ?>" target="_blank" class="text-naranja-vibrante">Escuchar</a> |
                                <button type="button" class="text-red-600 hover:underline bg-transparent border-none p-0 cursor-pointer" onclick="showDeleteConfirmation('delete-audio-form')">Eliminar</button>
                            </p>
                            <?php endif; ?>
                            <input type="file" name="audio_path" id="audio_path"
                                accept="audio/*"
                                class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200">
                            <p class="text-xs text-gray-500 mt-1">Formatos: MP3, WAV. Máx: 5MB. Sobrescribe la actual.</p>
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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Escuelas de Doblaje (Formación)</label>
                        <?php
                        // Asumiendo que $schools se pasa desde el controlador
                        $selectedSchools = old('schools', $actor->schools->pluck('id')->toArray());
                        ?>
                        <div class="filter-scroll-container">
                            <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center py-1">
                                <input type="checkbox" name="schools[]" value="<?php echo e($school->id); ?>"
                                    class="text-azul-profundo focus:ring-azul-profundo"
                                    <?php echo e(in_array($school->id, $selectedSchools) ? 'checked' : ''); ?>>
                                <span class="ml-2 text-sm text-gray-700"><?php echo e($school->name); ?> (<?php echo e($school->city ?? 'Sin ciudad'); ?>)</span>
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

                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h3 class="text-xl font-semibold text-red-700">Eliminar mi Cuenta</h3>
                        <p class="text-gray-600 mt-2 text-sm">Si deseas darte de baja, esta acción eliminará permanentemente tu cuenta y perfil de actor. Es irreversible.</p>
                        <button type="button"
                            onclick="if(confirm('¿Estás seguro de eliminar tu cuenta? Esta acción no se puede deshacer.')) { document.getElementById('delete-user-form').submit(); }"
                            class="mt-3 bg-red-600 text-white px-6 py-2 hover:bg-red-700 transition duration-200 font-medium flex items-center">
                            <i class="fas fa-trash mr-2"></i>
                            Eliminar Mi Cuenta
                        </button>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="<?php echo e(route('dashboard')); ?>"
                            class="bg-gray-500 text-white px-6 py-2 hover:bg-gray-600 flex items-center font-semibold transition duration-200">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                        <button type="submit"
                            class="bg-verde-menta text-white px-6 py-2 hover:bg-verde-menta hover:bg-opacity-90 flex items-center font-semibold transition duration-200">
                            <i class="fas fa-save mr-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:w-1/4">
            <div class="bg-white p-6 shadow-md sticky top-4 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Información importante</h2>

                <div class="space-y-4 text-sm text-gray-600">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Recuerda completar todos los campos obligatorios (<span class="text-rojo-intenso">*</span>)</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Puedes seleccionar **múltiples géneros** y **edades vocales**.</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Asegúrate de incluir el **personaje** por cada obra seleccionada.</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Una buena **biografía** y **muestra de voz** maximizan tu contratación.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<form id="delete-photo-form" method="POST" action="<?php echo e(route('actor.profile.delete_photo')); ?>" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>

<form id="delete-audio-form" method="POST" action="<?php echo e(route('actor.profile.delete_audio')); ?>" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>

<form id="delete-user-form" method="POST" action="<?php echo e(route('actor.profile.destroy')); ?>" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Estilos necesarios para los contenedores de scroll y los colores personalizados */
    /* El estilo global de no-border-radius se mantiene para imitar la otra vista */
    * {
        border-radius: 0 !important;
    }

    .filter-scroll-container {
        max-height: 20rem;
        /* Aumentado para que quepan más obras con su campo de personaje */
        overflow-y: auto;
        /* Ajustes de padding y margin para el estilo de lista */
        padding: 8px 12px;
        margin: 0 -12px;
        border: 1px solid #e5e7eb;
        background-color: #f9fafb;
    }

    /* Estilos de scrollbar para navegadores basados en Webkit */
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

    /* Clases de color personalizadas importadas del código de creación */
    .bg-verde-menta {
        background-color: #10b981 !important;
    }

    .text-verde-menta {
        color: #10b981 !important;
    }

    .text-rojo-intenso {
        color: #ef4444 !important;
    }

    .text-rosa-electrico {
        color: #ec4899 !important;
    }

    .text-naranja-vibrante {
        color: #f97316 !important;
    }

    .text-azul-profundo {
        color: #1d4ed8 !important;
    }

    /* Estilos de foco para inputs */
    .focus\:ring-verde-menta:focus {
        --tw-ring-color: #10b981;
    }

    .focus\:ring-rojo-intenso:focus {
        --tw-ring-color: #ef4444;
    }

    .focus\:ring-rosa-electrico:focus {
        --tw-ring-color: #ec4899;
    }

    .focus\:ring-naranja-vibrante:focus {
        --tw-ring-color: #f97316;
    }

    .focus\:border-azul-profundo:focus {
        border-color: #1d4ed8;
    }

    .focus\:ring-azul-profundo:focus {
        --tw-ring-color: #1d4ed8;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Función para mostrar confirmación antes de eliminar
    function showDeleteConfirmation(formId) {
        if (confirm('¿Estás absolutamente seguro de que deseas realizar esta acción? Esta acción es irreversible.')) {
            document.getElementById(formId).submit();
        }
    }

    // También puedes usar event listeners para mejor manejo
    document.addEventListener('DOMContentLoaded', function() {
        // Opcional: Agregar event listeners para los botones de eliminar
        const deleteButtons = document.querySelectorAll('[data-delete-form]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const formId = this.getAttribute('data-delete-form');
                showDeleteConfirmation(formId);
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/actors/edit.blade.php ENDPATH**/ ?>