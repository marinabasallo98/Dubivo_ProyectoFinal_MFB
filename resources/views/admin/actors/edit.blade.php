@extends('layouts.app')

@section('title', 'Editar Actor: ' . $actor->user->name . ' - Admin')

@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Editar Actor: {{ $actor->user->name }}</h1>
        {{-- Botón para ver el perfil público --}}
        <a href="{{ route('actors.show', $actor) }}" class="bg-gray-200 text-gray-700 px-4 py-2 hover:bg-gray-300 flex items-center font-semibold transition duration-200">
            <i class="fas fa-eye mr-2"></i>Ver Perfil
        </a>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="lg:w-3/4">
            <div class="bg-white shadow-md p-6 border border-gray-200">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Editar perfil de usuario y actor</h2>
                    <p class="text-gray-600 mt-2">Modifica la información necesaria para actualizar el perfil</p>
                </div>

                @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif

                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-4" role="alert">
                    <strong class="font-bold">¡Error de Validación!</strong>
                    <span class="block sm:inline">Por favor, revisa los campos marcados.</span>
                </div>
                @endif

                {{-- FORMULARIO DE EDICIÓN --}}
                <form action="{{ route('admin.actors.update', $actor) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- 1. INFORMACIÓN DE ACCESO (USUARIO) --}}
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
                                    value="{{ old('name', $actor->user->name) }}"
                                    class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-rosa-electrico focus:ring-rosa-electrico transition duration-200 @error('name') border-rojo-intenso @enderror">
                                @error('name')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-rojo-intenso">*</span>
                                </label>
                                <input type="email" name="email" id="email" required
                                    value="{{ old('email', $actor->user->email) }}"
                                    class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-azul-profundo focus:ring-azul-profundo transition duration-200 @error('email') border-rojo-intenso @enderror">
                                @error('email')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Contraseña (Dejar en blanco para no cambiar)
                                </label>
                                <input type="password" name="password" id="password"
                                    class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:border-verde-menta focus:ring-verde-menta transition duration-200 @error('password') border-rojo-intenso @enderror">
                                @error('password')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
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

                    {{-- 2. DETALLES DEL PERFIL (ACTOR) --}}
                    <div class="pb-6 border-b border-gray-100">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-2xl font-semibold text-gray-800">2. Detalles del Perfil (Actor)</h3>
                            <p class="text-gray-600 mt-2">Especificaciones de doblaje y disponibilidad</p>
                        </div>

                        <div> {{-- Biografía --}}
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                Biografía <span class="text-rojo-intenso">*</span>
                            </label>
                            <textarea name="bio" id="bio" rows="4" required
                                class="w-full border border-gray-300 px-3 py-2 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200 @error('bio') border-rojo-intenso @enderror"
                                placeholder="Describe la experiencia, formación y especialidades del actor...">{{ old('bio', $actor->bio) }}</textarea>
                            @error('bio')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6"> {{-- Géneros y Edades --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Géneros que puede interpretar <span class="text-rojo-intenso">*</span>
                                </label>
                                @php
                                $genders = ['Femenino', 'Masculino', 'Otro'];
                                $currentGenders = old('genders', $actor->genders ?? []);
                                @endphp
                                <div class="grid grid-cols-2 gap-x-4 filter-scroll-container">
                                    @foreach($genders as $gender)
                                    <label class="flex items-center py-1">
                                        <input type="checkbox" name="genders[]" value="{{ $gender }}"
                                            {{ in_array($gender, $currentGenders) ? 'checked' : '' }}
                                            class="text-rosa-electrico focus:ring-rosa-electrico">
                                        <span class="ml-2 text-sm text-gray-700">{{ $gender }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @error('genders')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Edades vocales que puede interpretar <span class="text-rojo-intenso">*</span>
                                </label>
                                @php
                                $voiceAges = ['Niño', 'Adolescente', 'Adulto joven', 'Adulto', 'Anciano', 'Atipada'];
                                $currentVoiceAges = old('voice_ages', $actor->voice_ages ?? []);
                                @endphp
                                <div class="grid grid-cols-2 gap-x-4 filter-scroll-container">
                                    @foreach($voiceAges as $age)
                                    <label class="flex items-center py-1">
                                        <input type="checkbox" name="voice_ages[]" value="{{ $age }}"
                                            {{ in_array($age, $currentVoiceAges) ? 'checked' : '' }}
                                            class="text-naranja-vibrante focus:ring-naranja-vibrante">
                                        <span class="ml-2 text-sm text-gray-700">{{ $age }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @error('voice_ages')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6"> {{-- Disponibilidad --}}
                            <h3 class="font-medium text-gray-700 mb-3">Disponibilidad</h3>
                            @php $isAvailable = old('is_available', $actor->is_available); @endphp
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="is_available" value="1"
                                        {{ $isAvailable == 1 ? 'checked' : '' }}
                                        class="text-verde-menta focus:ring-verde-menta">
                                    <span class="ml-2 text-sm text-gray-700">Disponible para nuevos proyectos</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="is_available" value="0"
                                        {{ $isAvailable == 0 ? 'checked' : '' }}
                                        class="text-rojo-intenso focus:ring-rojo-intenso">
                                    <span class="ml-2 text-sm text-gray-700">No disponible</span>
                                </label>
                            </div>
                            @error('is_available')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6"> {{-- Foto y Audio --}}
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                    Foto de Perfil
                                </label>
                                <input type="file" name="photo" id="photo"
                                    accept="image/*"
                                    class="w-full border border-gray-300 px-3 py-2 text-sm text-gray-500 focus:border-rosa-electrico focus:ring-rosa-electrico transition duration-200">
                                <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máx: 2MB. Sobrescribe la actual.</p>
                                @if ($actor->photo)
                                <div class="mt-2 text-sm text-gray-600">
                                    <i class="fas fa-image mr-1 text-rosa-electrico"></i> Foto actual subida: <a href="{{ Storage::url($actor->photo) }}" target="_blank" class="text-naranja-vibrante underline">Ver Foto</a>
                                </div>
                                @endif
                                @error('photo')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                                    Muestra de Voz
                                </label>
                                <input type="file" name="audio_path" id="audio_path"
                                    accept="audio/*"
                                    class="w-full border border-gray-300 px-3 py-2 text-sm text-gray-500 focus:border-azul-profundo focus:ring-azul-profundo transition duration-200">
                                <p class="text-xs text-gray-500 mt-1">Formatos: MP3, WAV. Máx: 5MB. Sobrescribe la actual.</p>
                                @if ($actor->audio_path)
                                <div class="mt-2 text-sm text-gray-600">
                                    <i class="fas fa-volume-up mr-1 text-azul-profundo"></i> Audio actual subido:
                                    <audio controls class="mt-1 w-full">
                                        <source src="{{ Storage::url($actor->audio_path) }}" type="audio/mpeg">
                                    </audio>
                                </div>
                                @endif
                                @error('audio_path')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- 3. FORMACIÓN Y TRABAJOS --}}
                    <div class="pb-6">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-2xl font-semibold text-gray-800">3. Formación y Trabajos</h3>
                            <p class="text-gray-600 mt-2">Relaciones con escuelas de doblaje y obras</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div> {{-- Formación Académica --}}
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Formación Académica (Escuelas donde estudió) <span class="text-rojo-intenso">*</span>
                                </label>
                                @php $actorSchoolIds = old('schools', $actor->schools->pluck('id')->toArray()); @endphp
                                <div class="filter-scroll-container" style="max-height: 10rem;">
                                    @forelse($schools as $school)
                                    <label class="flex items-center py-1">
                                        <input type="checkbox" name="schools[]" value="{{ $school->id }}"
                                            class="text-azul-profundo focus:ring-azul-profundo"
                                            {{ in_array($school->id, $actorSchoolIds) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">
                                            {{ $school->name }}
                                            @if($school->city)
                                            <span class="text-gray-500 text-xs">({{ $school->city }})</span>
                                            @endif
                                        </span>
                                    </label>
                                    @empty
                                    <p class="text-gray-500 text-sm">No hay escuelas registradas</p>
                                    @endforelse
                                </div>
                                @error('schools')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div> {{-- Escuelas donde enseña --}}
                                <div class="bg-yellow-50 p-4 border border-yellow-200">
                                    <h4 class="text-md font-semibold mb-3 text-yellow-800">Escuelas donde enseña (Opcional)</h4>
                                    @php $actorTeachingSchoolIds = old('teaching_schools', $actor->teachingSchools->pluck('id')->toArray()); @endphp
                                    <div class="filter-scroll-container" style="max-height: 10rem;">
                                        @foreach($schools as $school)
                                        <label class="flex items-center py-1">
                                            <input type="checkbox" name="teaching_schools[]" value="{{ $school->id }}"
                                                {{ in_array($school->id, $actorTeachingSchoolIds) ? 'checked' : '' }}
                                                class="text-naranja-vibrante focus:ring-naranja-vibrante">
                                            <span class="ml-2 text-sm text-gray-700">{{ $school->name }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                @error('teaching_schools')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8"> {{-- Obras Destacadas --}}
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Obras Destacadas (Experiencia)
                            </label>
                            <p class="text-xs text-gray-500 mb-3">Selecciona las obras en las que ha participado y especifica el personaje que interpretó.</p>

                            @php
                            $actorWorkIds = old('works', $actor->works->pluck('id')->toArray());
                            $actorWorkPivots = $actor->works->keyBy('id')->map(fn($work) => $work->pivot->character_name)->toArray();
                            $oldCharacters = old('character_names', $actorWorkPivots);
                            @endphp

                            <div class="filter-scroll-container" style="max-height: 20rem;">
                                @forelse($works as $work)
                                @php
                                $workId = $work->id;
                                $isChecked = in_array($workId, $actorWorkIds);
                                $characterValue = $oldCharacters[$workId] ?? '';
                                @endphp
                                <div class="p-2 border border-gray-300 bg-white shadow-sm mb-2">
                                    <label class="flex items-center">
                                        {{-- Checkbox de la Obra --}}
                                        <input type="checkbox" name="works[]" value="{{ $workId }}"
                                            class="work-checkbox text-azul-profundo focus:ring-azul-profundo"
                                            id="work_{{ $workId }}"
                                            {{ $isChecked ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-800 font-semibold">{{ $work->title }} ({{ $work->year ?? 'Año Desconocido' }})</span>
                                    </label>

                                    {{-- Input para el Personaje --}}
                                    <div class="ml-6 mt-2">
                                        <label for="character_{{ $workId }}" class="block text-xs font-normal text-gray-600 mb-1">
                                            Personaje interpretado:
                                        </label>
                                        <input type="text" name="character_names[{{ $workId }}]" id="character_{{ $workId }}"
                                            value="{{ $characterValue }}"
                                            placeholder="Ej: Voz de 'Main Character'"
                                            class="w-full border border-gray-300 px-3 py-1 text-sm focus:border-azul-profundo focus:ring-azul-profundo transition duration-200">
                                        @error("character_names.$workId")
                                        <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                @empty
                                <p class="text-gray-500 text-sm">No hay obras registradas</p>
                                @endforelse
                            </div>
                            @error('works')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.actors') }}"
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
@endsection

@section('styles')
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
@endsection