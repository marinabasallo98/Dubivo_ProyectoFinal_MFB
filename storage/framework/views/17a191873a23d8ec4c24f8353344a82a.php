

<?php $__env->startSection('title', 'Crear Nuevo Actor - Admin'); ?>

<?php $__env->startSection('content'); ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Crear Nuevo Actor</h1>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Formulario Principal -->
        <div class="lg:w-3/4">
            <div class="bg-white shadow-md p-6 border border-gray-200">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Crear nuevo usuario y perfil de actor</h2>
                    <p class="text-gray-600 mt-2">Completa toda la información necesaria para crear el perfil</p>
                </div>

                <!-- Mensajes de Estado (Éxito/Error) -->
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

                <form action="<?php echo e(route('admin.actors.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
                    <?php echo csrf_field(); ?>

                    <!-- Sección 1: Información del Usuario (Cuenta) -->
                    <div class="bg-white p-6 border border-gray-200">
                        <h3 class="text-xl font-semibold mb-6 border-b pb-3 text-gray-700">1. Información de Acceso (Usuario)</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre completo <span class="text-rojo-intenso">*</span>
                                </label>
                                <input type="text" name="name" id="name" required
                                    value="<?php echo e(old('name')); ?>"
                                    class="w-full border border-gray-300 px-4 py-2.5 focus:outline-none focus:border-rosa-electrico focus:ring-rosa-electrico transition duration-200 <?php $__errorArgs = ['name'];
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

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-rojo-intenso">*</span>
                                </label>
                                <input type="email" name="email" id="email" required
                                    value="<?php echo e(old('email')); ?>"
                                    class="w-full border border-gray-300 px-4 py-2.5 focus:outline-none focus:border-morado-vibrante focus:ring-morado-vibrante transition duration-200 <?php $__errorArgs = ['email'];
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

                            <!-- Contraseña -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Contraseña <span class="text-rojo-intenso">*</span>
                                </label>
                                <input type="password" name="password" id="password" required
                                    class="w-full border border-gray-300 px-4 py-2.5 focus:outline-none focus:border-verde-menta focus:ring-verde-menta transition duration-200 <?php $__errorArgs = ['password'];
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

                            <!-- Confirmar Contraseña -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirmar Contraseña <span class="text-rojo-intenso">*</span>
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="w-full border border-gray-300 px-4 py-2.5 focus:outline-none focus:border-verde-menta focus:ring-verde-menta transition duration-200">
                            </div>
                        </div>
                    </div>

                    <!-- Sección 2: Información del Actor (Perfil) -->
                    <div class="bg-white p-6 border border-gray-200">
                        <h3 class="text-xl font-semibold mb-6 border-b pb-3 text-gray-700">2. Detalles del Perfil (Actor)</h3>

                        <!-- Biografía -->
                        <div class="mb-6">
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                Biografía <span class="text-rojo-intenso">*</span>
                            </label>
                            <textarea name="bio" id="bio" rows="4" required
                                class="w-full border border-gray-300 px-4 py-2.5 focus:outline-none focus:border-morado-vibrante focus:ring-morado-vibrante transition duration-200 <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rojo-intenso <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Describe la experiencia, formación y especialidades del actor..."><?php echo e(old('bio')); ?></textarea>
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

                        <!-- Géneros y Edades Vocales -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Géneros -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Géneros que puede interpretar <span class="text-rojo-intenso">*</span>
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
                                    Edades vocales que puede interpretar <span class="text-rojo-intenso">*</span>
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
                        </div>

                        <!-- Archivos (Foto y Audio) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Foto -->
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                    Foto de Perfil
                                </label>
                                <input type="file" name="photo" id="photo"
                                    accept="image/*"
                                    class="w-full text-sm text-gray-500 px-3 py-2 border border-gray-300 focus:border-rosa-electrico focus:ring-rosa-electrico transition duration-200">
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

                            <!-- Audio -->
                            <div>
                                <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                                    Muestra de Voz
                                </label>
                                <input type="file" name="audio_path" id="audio_path"
                                    accept="audio/*"
                                    class="w-full text-sm text-gray-500 px-3 py-2 border border-gray-300 focus:border-morado-vibrante focus:ring-morado-vibrante transition duration-200">
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

                        <!-- Disponibilidad -->
                        <div class="mb-6">
                            <h3 class="font-medium text-gray-700 mb-3">Disponibilidad</h3>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="is_available" value="1"
                                        <?php echo e(old('is_available', 1) == 1 ? 'checked' : ''); ?>

                                        class="text-verde-menta focus:ring-verde-menta">
                                    <span class="ml-2 text-sm text-gray-700">Disponible para nuevos proyectos</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="is_available" value="0"
                                        <?php echo e(old('is_available') == '0' ? 'checked' : ''); ?>

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
                    </div>

                    <!-- Sección 3: Formación y Experiencia -->
                    <div class="bg-white p-6 border border-gray-200">
                        <h3 class="text-xl font-semibold mb-6 border-b pb-3 text-gray-700">3. Formación y Trabajos</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Escuelas -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Formación Académica
                                </label>
                                <div class="filter-scroll-container">
                                    <?php $__empty_1 = true; $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <label class="flex items-center py-1">
                                        <input type="checkbox" name="schools[]" value="<?php echo e($school->id); ?>"
                                            class="text-morado-vibrante focus:ring-morado-vibrante"
                                            <?php echo e(in_array($school->id, old('schools', [])) ? 'checked' : ''); ?>>
                                        <span class="ml-2 text-sm text-gray-700">
                                            <?php echo e($school->name); ?>

                                            <?php if($school->city): ?>
                                            <span class="text-gray-500 text-xs">(<?php echo e($school->city); ?>)</span>
                                            <?php endif; ?>
                                        </span>
                                    </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-gray-500 text-sm col-span-2">No hay escuelas registradas</p>
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

                            <!-- Escuelas -->
                            <div class="bg-yellow-50 border border-yellow-200 rounded-md shadow-sm overflow-hidden">
                                <div class="p-4 border-b border-yellow-100">
                                    <h4 class="text-md font-semibold text-yellow-800">
                                        Escuelas donde enseña
                                    </h4>
                                </div>

                                <div class="max-h-40 overflow-y-auto p-4 bg-yellow-50/50">
                                    <?php
                                    $selectedSchoolIds = old('teaching_schools', []);
                                    ?>

                                    <div class="space-y-2">
                                        <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="flex items-center group cursor-pointer">
                                            <div class="relative flex items-start">
                                                <input type="checkbox" name="teaching_schools[]" value="<?php echo e($school->id); ?>"
                                                    <?php echo e(in_array($school->id, $selectedSchoolIds) ? 'checked' : ''); ?>

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

                        <!-- Obras -->
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
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="<?php echo e(route('admin.actors')); ?>"
                            class="bg-gray-500 text-white px-6 py-2 hover:bg-gray-600 flex items-center font-semibold transition duration-200">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </a>
                        <button type="submit"
                            class="bg-verde-menta text-white px-6 py-2 hover:bg-verde-menta hover:bg-opacity-90 flex items-center font-semibold transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Crear Actor y Usuario
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
                        <span>Todos los campos marcados con <strong class="text-rojo-intenso">*</strong> son obligatorios</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Se creará tanto el <strong>usuario</strong> como el <strong>perfil de actor</strong></span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>El actor aparecerá en el banco de voces para clientes</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>Puedes asignar formación académica y trabajos destacados</span>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-verde-menta mt-1"></i>
                        <span>La muestra de voz es opcional pero recomendada</span>
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

    .filter-scroll-container input[type="checkbox"]:focus,
    .filter-scroll-container input[type="radio"]:focus {
        outline: 2px solid #8b5cf6;
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

    .text-verde-menta:focus {
        --tw-ring-color: #10b981 !important;
    }

    .bg-rojo-intenso {
        background-color: #ef4444 !important;
    }

    .text-rojo-intenso {
        color: #ef4444 !important;
    }

    .border-rojo-intenso {
        border-color: #ef4444 !important;
    }

    .text-rosa-electrico:focus {
        --tw-ring-color: #ec4899 !important;
    }

    .text-naranja-vibrante:focus {
        --tw-ring-color: #f97316 !important;
    }

    .text-morado-vibrante:focus {
        --tw-ring-color: #8b5cf6 !important;
    }

    .focus\:border-rosa-electrico:focus {
        border-color: #ec4899 !important;
    }

    .focus\:border-morado-vibrante:focus {
        border-color: #8b5cf6 !important;
    }

    .focus\:border-verde-menta:focus {
        border-color: #10b981 !important;
    }

    .focus\:ring-morado-vibrante:focus {
        --tw-ring-color: #8b5cf6 !important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Programas\laragon\www\ProyectoFinalMFB\resources\views/admin/actors/create.blade.php ENDPATH**/ ?>