

<?php $__env->startSection('title', 'Editar Actor: ' . $actor->user->name . ' - Admin'); ?>

<?php $__env->startSection('content'); ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Editar Actor: <?php echo e($actor->user->name); ?></h1>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="lg:w-3/4">
            <div class="bg-white shadow-md p-6 border border-gray-200">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Editar perfil de usuario y actor</h2>
                    <p class="text-gray-600 mt-2">Modifica la información necesaria para actualizar el perfil</p>
                </div>

                <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-4" role="alert">
                    <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-4" role="alert">
                    <strong class="font-bold">¡Error de Validación!</strong>
                    <span class="block sm:inline">Por favor, revisa los campos marcados.</span>
                </div>
                <?php endif; ?>

                
                <form action="<?php echo e(route('admin.actors.update', $actor)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    
                    <div class="pb-6 border-b border-gray-100">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-2xl font-semibold text-gray-800">1. Información de Acceso (Usuario)</h3>
                            <p class="text-gray-600 mt-2">Modifica los datos de inicio de sesión y perfil público.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre completo <span class="text-rojo-intenso">*</span>
                                </label>
                                <input type="text" name="name" id="name" required
                                    value="<?php echo e(old('name', $actor->user->name)); ?>"
                                    class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-rosa-electrico focus:ring-rosa-electrico transition duration-200 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rojo-intenso <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <?php $__errorArgs = ['name'];
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
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-rojo-intenso">*</span>
                                </label>
                                <input type="email" name="email" id="email" required
                                    value="<?php echo e(old('email', $actor->user->email)); ?>"
                                    class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-azul-profundo focus:ring-azul-profundo transition duration-200 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rojo-intenso <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <?php $__errorArgs = ['email'];
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
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Contraseña (Dejar en blanco para no cambiar)
                                </label>
                                <input type="password" name="password" id="password"
                                    class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-verde-menta focus:ring-verde-menta transition duration-200 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rojo-intenso <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <?php $__errorArgs = ['password'];
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
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirmar Contraseña
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-verde-menta focus:ring-verde-menta transition duration-200">
                            </div>
                        </div>
                    </div>

                    
                    <div class="pb-6 border-b border-gray-100">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-2xl font-semibold text-gray-800">2. Detalles del Perfil (Actor)</h3>
                            <p class="text-gray-600 mt-2">Especificaciones de doblaje y disponibilidad</p>
                        </div>

                        <div> 
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                Biografía <span class="text-rojo-intenso">*</span>
                            </label>
                            <textarea name="bio" id="bio" rows="4" required
                                class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200 <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rojo-intenso <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Describe la experiencia, formación y especialidades del actor..."><?php echo e(old('bio', $actor->bio)); ?></textarea>
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6"> 
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Géneros que puede interpretar <span class="text-rojo-intenso">*</span>
                                </label>
                                <?php
                                $genders = ['Femenino', 'Masculino', 'Otro'];
                                $currentGenders = old('genders', $actor->genders ?? []);
                                ?>
                                <div class="grid grid-cols-2 gap-x-4 filter-scroll-container">
                                    <?php $__currentLoopData = $genders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="flex items-center py-1">
                                        <input type="checkbox" name="genders[]" value="<?php echo e($gender); ?>"
                                            <?php echo e(in_array($gender, $currentGenders) ? 'checked' : ''); ?>

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
                                    Edades vocales que puede interpretar <span class="text-rojo-intenso">*</span>
                                </label>
                                <?php
                                $voiceAges = ['Niño', 'Adolescente', 'Adulto joven', 'Adulto', 'Anciano', 'Atipada'];
                                $currentVoiceAges = old('voice_ages', $actor->voice_ages ?? []);
                                ?>
                                <div class="grid grid-cols-2 gap-x-4 filter-scroll-container">
                                    <?php $__currentLoopData = $voiceAges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="flex items-center py-1">
                                        <input type="checkbox" name="voice_ages[]" value="<?php echo e($age); ?>"
                                            <?php echo e(in_array($age, $currentVoiceAges) ? 'checked' : ''); ?>

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
                        </div>

                        <div class="mt-6"> 
                            <h3 class="font-medium text-gray-700 mb-3">Disponibilidad</h3>
                            <?php $isAvailable = old('is_available', $actor->is_available); ?>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="is_available" value="1"
                                        <?php echo e($isAvailable == 1 ? 'checked' : ''); ?>

                                        class="text-verde-menta focus:ring-verde-menta">
                                    <span class="ml-2 text-sm text-gray-700">Disponible para nuevos proyectos</span>
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6"> 
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                    Foto de Perfil
                                </label>
                                <input type="file" name="photo" id="photo"
                                    accept="image/*"
                                    class="w-full border border-gray-300 px-3 py-2 text-sm text-gray-500 focus:border-rosa-electrico focus:ring-rosa-electrico transition duration-200">
                                <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máx: 2MB. Sobrescribe la actual.</p>
                                <?php if($actor->photo): ?>
                                <div class="mt-2 text-sm text-gray-600">
                                    <i class="fas fa-image mr-1 text-rosa-electrico"></i> Foto actual subida: <a href="<?php echo e(Storage::url($actor->photo)); ?>" target="_blank" class="text-naranja-vibrante underline">Ver Foto</a>
                                </div>
                                <?php endif; ?>
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
                                <input type="file" name="audio_path" id="audio_path"
                                    accept="audio/*"
                                    class="w-full border border-gray-300 px-3 py-2 text-sm text-gray-500 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200">
                                <p class="text-xs text-gray-500 mt-1">Formatos: MP3, WAV. Máx: 5MB. Sobrescribe la actual.</p>
                                <?php if($actor->audio_path): ?>
                                <div class="mt-2 text-sm text-gray-600">
                                    <i class="fas fa-volume-up mr-1 text-azul-profundo"></i> Audio actual subido:
                                    <audio controls class="mt-1 w-full">
                                        <source src="<?php echo e(Storage::url($actor->audio_path)); ?>" type="audio/mpeg">
                                    </audio>
                                </div>
                                <?php endif; ?>
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
                    </div>

                    
                    <div class="pb-6">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-2xl font-semibold text-gray-800">3. Formación y Trabajos</h3>
                            <p class="text-gray-600 mt-2">Relaciones con escuelas de doblaje y obras</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div> 
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Formación Académica
                                </label>
                                <?php $actorSchoolIds = old('schools', $actor->schools->pluck('id')->toArray()); ?>
                                <div class="filter-scroll-container" style="max-height: 10rem;">
                                    <?php $__empty_1 = true; $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <label class="flex items-center py-1">
                                        <input type="checkbox" name="schools[]" value="<?php echo e($school->id); ?>"
                                            class="text-azul-profundo focus:ring-azul-profundo"
                                            <?php echo e(in_array($school->id, $actorSchoolIds) ? 'checked' : ''); ?>>
                                        <span class="ml-2 text-sm text-gray-700">
                                            <?php echo e($school->name); ?>

                                            <?php if($school->city): ?>
                                            <span class="text-gray-500 text-xs">(<?php echo e($school->city); ?>)</span>
                                            <?php endif; ?>
                                        </span>
                                    </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-gray-500 text-sm">No hay escuelas registradas</p>
                                    <?php endif; ?>
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

                            
                            <div class="bg-yellow-50 border border-yellow-200 rounded-md shadow-sm overflow-hidden">
                                
                                <div class="p-4 border-b border-yellow-100">
                                    <h4 class="text-md font-semibold text-yellow-800">
                                        <i class="fas fa-chalkboard-teacher mr-2"></i>Escuelas donde enseña
                                    </h4>
                                </div>

                                
                                <div class="max-h-40 overflow-y-auto p-4 bg-yellow-50/50">
                                    <?php
                                    $actorTeachingSchoolIds = old('teaching_schools', $actor->teachingSchools->pluck('id')->toArray());
                                    ?>

                                    <div class="space-y-2">
                                        <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="flex items-center group cursor-pointer">
                                            <div class="relative flex items-start">
                                                <input type="checkbox" name="teaching_schools[]" value="<?php echo e($school->id); ?>"
                                                    <?php echo e(in_array($school->id, $actorTeachingSchoolIds) ? 'checked' : ''); ?>

                                                    class="h-4 w-4 text-naranja-vibrante border-yellow-300 rounded focus:ring-naranja-vibrante bg-white">
                                            </div>
                                            <span class="ml-2 text-sm text-gray-700 group-hover:text-yellow-900 transition-colors">
                                                <?php echo e($school->name); ?>

                                            </span>
                                        </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                            <?php $__errorArgs = ['teaching_schools'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-rojo-intenso text-sm mt-1 px-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mt-8">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Obras Destacadas
                            </label>
                            <p class="text-xs text-gray-500 mb-3">Selecciona las obras y especifica el personaje.</p>

                            <?php
                            $actorWorkIds = old('works', $actor->works->pluck('id')->toArray());
                            $actorWorkPivots = $actor->works->keyBy('id')->map(fn($work) => $work->pivot->character_name)->toArray();
                            $oldCharacters = old('character_names', $actorWorkPivots);
                            ?>

                            
                            <div class="border border-gray-300 bg-gray-50 p-4 rounded max-h-80 overflow-y-auto">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <?php $__empty_1 = true; $__currentLoopData = $works; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $work): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                    $workId = $work->id;
                                    $isChecked = in_array($workId, $actorWorkIds);
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
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="<?php echo e(route('admin.actors')); ?>"
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
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Información de Edición</h2>

                <div class="space-y-4 text-sm text-gray-600">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Todos los campos marcados con <strong class="text-rojo-intenso">*</strong> son obligatorios (excepto contraseña)</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>La <strong>Contraseña</strong> es opcional. Dejar en blanco si no se quiere modificar.</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Los archivos de <strong>Foto</strong> y <strong>Audio</strong> se reemplazarán al subir uno nuevo.</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Las relaciones de <strong>Formación</strong> y <strong>Trabajos</strong> se actualizan al guardar.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Estilos necesarios para los contenedores de scroll y los colores personalizados */
    * {
        border-radius: 0 !important;
    }

    .filter-scroll-container {
        max-height: 20rem;
        /* Predeterminado para secciones largas como Trabajos */
        overflow-y: auto;
        /* Ajustes de padding y margin para el estilo de lista */
        padding: 8px 12px;
        margin: 0 -12px;
        border: 1px solid #e5e7eb;
        background-color: #f9fafb;
    }

    /* Redefinición para las secciones de escuelas que deben ser más cortas (como el 10rem original del admin) */
    .filter-scroll-container[style*="max-height: 10rem"] {
        max-height: 10rem;
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

    /* Clases de color personalizadas (del archivo edit.blade.php) */
    .bg-verde-menta {
        background-color: #10b981 !important;
    }

    .text-verde-menta {
        color: #10b981 !important;
    }

    .text-rojo-intenso {
        color: #ef4444 !important;
    }

    .border-rojo-intenso {
        border-color: #ef4444 !important;
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

    .focus\:border-rosa-electrico:focus {
        border-color: #ec4899;
    }

    .focus\:border-verde-menta:focus {
        border-color: #10b981;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/admin/actors/edit.blade.php ENDPATH**/ ?>