@extends('layouts.app')

@section('title', isset($isAdmin) ? 'Editar ' . $actor->user->name . ' - Admin' : 'Editar Perfil de Actor - Dubivo')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Header diferenciado según rol -->
    @if(isset($isAdmin) && $isAdmin)
    <!-- Header Admin -->
    <div class="bg-white shadow-md p-6 mb-6 rounded-lg">
        <div class="border-b border-gray-200 pb-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    @if($actor->photo)
                    <img src="{{ asset('storage/' . $actor->photo) }}"
                        alt="{{ $actor->user->name }}"
                        class="w-16 h-16 object-cover mr-4 rounded-lg">
                    @else
                    <div class="w-16 h-16 bg-gradient-to-br from-naranja-vibrante to-ambar flex items-center justify-center mr-4 rounded-lg">
                        <i class="fas fa-user text-white text-xl"></i>
                    </div>
                    @endif
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Editar Actor</h1>
                        <p class="text-gray-600 mt-1">{{ $actor->user->name }} ({{ $actor->user->email }})</p>
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    ID: {{ $actor->id }} • Creado: {{ $actor->created_at->format('d/m/Y') }}
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Header Actor -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Editar Perfil de Actor</h1>
    </div>

    {{-- Mensaje de bienvenida --}}
    @if(session('success') && str_contains(session('success'), 'Completa tu información adicional'))
    <div class="bg-gradient-to-r from-naranja-vibrante/10 to-ambar/10 p-4 mb-6 border border-ambar/20 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-star text-naranja-vibrante text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-naranja-vibrante">¡Bienvenido a Dubivo!</h3>
                <div class="mt-2 text-sm text-naranja-vibrante">
                    <p>Completa tu perfil profesional para que los clientes puedan encontrarte.</p>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Formulario Principal -->
        <div class="{{ isset($isAdmin) && $isAdmin ? 'w-full' : 'lg:w-3/4' }}">
            <div class="bg-white shadow-md p-6 border border-gray-200 rounded-lg">
                @if(!isset($isAdmin))
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Actualiza tu información</h2>
                    <p class="text-gray-600 mt-2">Mantén tu perfil actualizado para más oportunidades</p>
                </div>
                @endif

                <form action="{{ isset($isAdmin) && $isAdmin ? route('admin.actors.update', $actor) : route('actors.update', $actor) }}"
                    method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @if(isset($isAdmin) && $isAdmin)
                    <input type="hidden" name="user_id" value="{{ $actor->user_id }}">
                    @endif

                    <!-- Distribución en 2 columnas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Columna Izquierda -->
                        <div class="space-y-6">
                            <!-- Géneros -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Géneros que puede{{ !isset($isAdmin) ? 's' : '' }} interpretar
                                    <span class="text-rojo-intenso">*</span>
                                </label>
                                <div class="filter-scroll-container border border-gray-200 bg-gray-50 rounded-lg">
                                    @php
                                    $currentGenders = is_array($actor->genders) ? $actor->genders : json_decode($actor->genders, true) ?? [];
                                    $currentGenders = old('genders', $currentGenders);
                                    @endphp
                                    @foreach($genders as $gender)
                                    <label class="flex items-center p-3 border-b border-gray-100 last:border-b-0 hover:bg-amber-50 cursor-pointer transition duration-150">
                                        <input type="checkbox" name="genders[]" value="{{ $gender }}"
                                            {{ in_array($gender, $currentGenders) ? 'checked' : '' }}
                                            class="border-gray-300 text-naranja-vibrante focus:ring-naranja-vibrante focus:ring-2">
                                        <span class="ml-3 text-sm font-medium text-gray-700">{{ $gender }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @error('genders')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Edades Vocales -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Edades vocales que puede{{ !isset($isAdmin) ? 's' : '' }} interpretar
                                    <span class="text-rojo-intenso">*</span>
                                </label>
                                <div class="filter-scroll-container border border-gray-200 bg-gray-50 rounded-lg">
                                    @php
                                    $currentVoiceAges = is_array($actor->voice_ages) ? $actor->voice_ages : json_decode($actor->voice_ages, true) ?? [];
                                    $currentVoiceAges = old('voice_ages', $currentVoiceAges);
                                    @endphp
                                    @foreach($voiceAges as $age)
                                    <label class="flex items-center p-3 border-b border-gray-100 last:border-b-0 hover:bg-naranja-vibrante/5 cursor-pointer transition duration-150">
                                        <input type="checkbox" name="voice_ages[]" value="{{ $age }}"
                                            {{ in_array($age, $currentVoiceAges) ? 'checked' : '' }}
                                            class="border-gray-300 text-naranja-vibrante focus:ring-naranja-vibrante focus:ring-2">
                                        <span class="ml-3 text-sm font-medium text-gray-700">{{ $age }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @error('voice_ages')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div class="space-y-6">
                            <!-- Biografía -->
                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                    Biografía
                                </label>
                                <textarea name="bio" id="bio" rows="6"
                                    class="w-full border border-gray-300 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-rosa-electrico focus:border-rosa-electrico transition duration-200"
                                    placeholder="{{ !isset($isAdmin) ? 'Cuéntanos sobre tu experiencia, formación y especialidades...' : 'Biografía profesional del actor...' }}">{{ old('bio', $actor->bio) }}</textarea>
                                @error('bio')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Disponibilidad -->
                            <div class="p-4 border border-gray-200 bg-gray-50 rounded-lg">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Estado de disponibilidad
                                </label>

                                <div class="space-y-3">
                                    @php
                                    // Calcular estado actual
                                    $currentAvailability = old('is_available', $actor->is_available);
                                    // Convertir a booleano
                                    if (is_string($currentAvailability)) {
                                    $currentAvailability = $currentAvailability === '1' || $currentAvailability === 'true';
                                    }
                                    $currentAvailability = (bool) $currentAvailability;
                                    @endphp

                                    <!-- Opción Disponible -->
                                    <label class="flex items-center p-3 border {{ $currentAvailability ? 'border-verde-menta border-2 bg-green-50' : 'border-gray-300' }} rounded-lg hover:bg-green-50 cursor-pointer transition duration-200">
                                        <input type="radio"
                                            name="is_available"
                                            value="1"
                                            class="h-5 w-5 text-verde-menta focus:ring-verde-menta border-gray-300"
                                            {{ $currentAvailability ? 'checked' : '' }}>
                                        <div class="ml-3 flex items-center">
                                            <div class="h-3 w-3 rounded-full bg-verde-menta mr-2"></div>
                                            <span class="text-sm font-medium text-gray-700">Disponible</span>
                                        </div>
                                        <span class="ml-auto text-xs text-gray-500">Aparecerás en búsquedas</span>
                                    </label>

                                    <!-- Opción No Disponible -->
                                    <label class="flex items-center p-3 border {{ !$currentAvailability ? 'border-rojo-intenso border-2 bg-red-50' : 'border-gray-300' }} rounded-lg hover:bg-red-50 cursor-pointer transition duration-200">
                                        <input type="radio"
                                            name="is_available"
                                            value="0"
                                            class="h-5 w-5 text-rojo-intenso focus:ring-rojo-intenso border-gray-300"
                                            {{ !$currentAvailability ? 'checked' : '' }}>
                                        <div class="ml-3 flex items-center">
                                            <div class="h-3 w-3 rounded-full bg-rojo-intenso mr-2"></div>
                                            <span class="text-sm font-medium text-gray-700">No disponible</span>
                                        </div>
                                        <span class="ml-auto text-xs text-gray-500">No aparecerás en búsquedas</span>
                                    </label>
                                </div>

                                @error('is_available')
                                <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Archivos (Foto y Audio) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Foto -->
                        <div class="p-4 border border-gray-200 bg-gray-50 rounded-lg">
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto de perfil
                            </label>
                            @if($actor->photo)
                            <div class="flex items-center space-x-4 mb-3">
                                <img src="{{ asset('storage/' . $actor->photo) }}"
                                    alt="Foto actual"
                                    class="w-16 h-16 object-cover border-2 border-ambar rounded-lg">
                                <span class="text-sm text-gray-600">Foto actual</span>
                            </div>
                            @endif
                            <input type="file" name="photo" id="photo"
                                accept="image/*"
                                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-naranja-vibrante focus:border-naranja-vibrante">
                            <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
                            @error('photo')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Audio -->
                        <div class="p-4 border border-gray-200 bg-gray-50 rounded-lg">
                            <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                                Muestra de voz
                            </label>
                            @if($actor->audio_path)
                            <div class="flex items-center space-x-4 mb-3">
                                <i class="fas fa-volume-up text-rosa-electrico text-xl"></i>
                                <audio controls class="h-8">
                                    <source src="{{ asset('storage/' . $actor->audio_path) }}" type="audio/mpeg">
                                </audio>
                            </div>
                            @endif
                            <input type="file" name="audio_path" id="audio_path"
                                accept="audio/*"
                                class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-rosa-electrico focus:border-rosa-electrico">
                            <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
                            @error('audio_path')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Escuelas y Obras -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <!-- Escuelas -->
                        <div class="p-4 border border-gray-200 bg-gray-50 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Escuelas de formación
                            </label>
                            <div class="filter-scroll-container border border-gray-200 bg-white rounded-lg">
                                @foreach($schools as $school)
                                <label class="flex items-center p-3 border-b border-gray-100 last:border-b-0 hover:bg-ambar/10 cursor-pointer">
                                    <input type="checkbox" name="schools[]" value="{{ $school->id }}"
                                        class="border-gray-300 text-ambar focus:ring-ambar focus:ring-2"
                                        {{ in_array($school->id, old('schools', $actor->schools->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm text-gray-700">{{ $school->name }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('schools')
                            <p class="text-rojo-intenso text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Obras -->
                        <div class="p-4 border border-gray-200 bg-gray-50 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Obras participadas
                            </label>
                            <div class="filter-scroll-container border border-gray-200 bg-white rounded-lg">
                                @foreach($works as $work)
                                <div class="flex items-start p-3 border-b border-gray-100 last:border-b-0 hover:bg-rosa-electrico/5">
                                    <input type="checkbox" name="works[]" value="{{ $work->id }}"
                                        class="mt-1 border-gray-300 text-rosa-electrico focus:ring-rosa-electrico focus:ring-2"
                                        {{ in_array($work->id, old('works', $actor->works->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <div class="ml-3 flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <span class="text-sm font-medium text-gray-700">{{ $work->title }}</span>
                                                <div class="text-xs text-gray-500 capitalize">
                                                    {{ $work->type }} @if($work->year)• {{ $work->year }}@endif
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                        $characterName = $actor->works->find($work->id)->pivot->character_name ?? '';
                                        @endphp
                                        <input type="text" name="character_names[{{ $work->id }}]"
                                            placeholder="Nombre del personaje"
                                            class="mt-2 w-full text-sm border border-gray-300 px-3 py-1 rounded focus:border-rosa-electrico focus:ring-rosa-electrico focus:ring-1"
                                            value="{{ old('character_names.' . $work->id, $characterName) }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Profesor (Solo para Admin) -->
                    @if(isset($isAdmin) && $isAdmin)
                    <div class="mt-6 p-4 border border-gray-200 bg-gray-50 rounded-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Información como Profesor</h2>
                        <div class="space-y-3">
                            @foreach($schools as $school)
                            <div class="flex items-center justify-between p-3 border border-gray-200 bg-white rounded-lg">
                                <label class="flex items-center">
                                    <input type="checkbox" name="teaching_schools[]" value="{{ $school->id }}"
                                        {{ in_array($school->id, $currentTeachingSchools ?? []) ? 'checked' : '' }}
                                        class="text-ambar focus:ring-ambar focus:ring-2 teaching-school-checkbox">
                                    <span class="ml-2 text-sm text-gray-700">{{ $school->name }}</span>
                                </label>

                                <div class="teaching-school-fields ml-4 {{ in_array($school->id, $currentTeachingSchools ?? []) ? '' : 'hidden' }}">
                                    <input type="text" name="teaching_subjects[{{ $school->id }}]"
                                        placeholder="Materia que imparte"
                                        value="{{ $actor->teachingSchools->firstWhere('id', $school->id)?->pivot?->subject }}"
                                        class="border border-gray-300 px-3 py-1 text-sm w-48 rounded">
                                    <textarea name="teaching_bios[{{ $school->id }}]"
                                        placeholder="Bio como profesor"
                                        class="border border-gray-300 px-3 py-1 text-sm w-48 ml-2 rounded">{{ $actor->teachingSchools->firstWhere('id', $school->id)?->pivot?->teaching_bio }}</textarea>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Botones -->
                    <div class="flex {{ isset($isAdmin) && $isAdmin ? 'justify-between' : 'justify-end' }} items-center pt-6 border-t border-gray-200">
                        @if(isset($isAdmin) && $isAdmin)
                        <div>
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-info-circle text-naranja-vibrante mr-1"></i>
                                Usuario: {{ $actor->user->email }}
                            </p>
                        </div>
                        @endif
                        <div class="flex space-x-4">
                            <a href="{{ isset($isAdmin) && $isAdmin ? route('admin.actors') : route('actors.show', $actor) }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 transition duration-200 font-medium rounded-lg">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="px-6 py-3 {{ isset($isAdmin) && $isAdmin ? 'bg-naranja-vibrante hover:bg-naranja-vibrante/90 focus:ring-naranja-vibrante' : 'bg-verde-menta hover:bg-verde-menta/90 focus:ring-verde-menta' }} text-white hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-200 font-medium flex items-center rounded-lg">
                                <i class="fas fa-save mr-2"></i>
                                {{ isset($isAdmin) && $isAdmin ? 'Actualizar Actor' : 'Actualizar Perfil' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Columna de Información Lateral (Solo para Actor) -->
        @if(!isset($isAdmin))
        <div class="lg:w-1/4">
            <div class="bg-white p-6 shadow-md sticky top-4 border border-gray-200 rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Estado del perfil</h2>

                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Visibilidad:</span>
                        <span class="text-sm font-medium {{ $actor->is_available ? 'text-verde-menta' : 'text-rojo-intenso' }}">
                            {{ $actor->is_available ? 'Público' : 'No disponible' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Última actualización:</span>
                        <span class="text-sm text-gray-500">{{ $actor->updated_at->diffForHumans() }}</span>
                    </div>
                </div>

                <!-- Consejos para mejorar -->
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="font-medium text-gray-700 mb-2">Consejos para mejorar</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        @if(!$actor->photo)
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-camera text-naranja-vibrante"></i>
                            <span>Añade una foto profesional</span>
                        </div>
                        @endif
                        @if(!$actor->audio_path)
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-volume-up text-rosa-electrico"></i>
                            <span>Sube una muestra de voz</span>
                        </div>
                        @endif
                        @if(!$actor->bio)
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-file-alt text-ambar"></i>
                            <span>Completa tu biografía</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .filter-scroll-container {
        max-height: 12rem;
        overflow-y: auto;
        padding: 0;
    }

    .filter-scroll-container::-webkit-scrollbar {
        width: 6px;
    }

    .filter-scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .filter-scroll-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    .filter-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Colores personalizados según tu paleta */
    .text-naranja-vibrante {
        color: #f97316;
    }

    /* Naranja para actores */
    .text-ambar {
        color: #f59e0b;
    }

    /* Amarillo yema para escuelas */
    .text-rosa-electrico {
        color: #ec4899;
    }

    /* Rosa para obras */
    .text-verde-menta {
        color: #10b981;
    }

    /* Verde para disponibilidad */
    .text-rojo-intenso {
        color: #ef4444;
    }

    /* Rojo para errores */

    .bg-naranja-vibrante {
        background-color: #f97316;
    }

    .bg-ambar {
        background-color: #f59e0b;
    }

    .bg-rosa-electrico {
        background-color: #ec4899;
    }

    .bg-verde-menta {
        background-color: #10b981;
    }

    .bg-rojo-intenso {
        background-color: #ef4444;
    }

    .border-naranja-vibrante {
        border-color: #f97316;
    }

    .border-ambar {
        border-color: #f59e0b;
    }

    .border-rosa-electrico {
        border-color: #ec4899;
    }

    .border-verde-menta {
        border-color: #10b981;
    }

    .border-rojo-intenso {
        border-color: #ef4444;
    }

    .focus\:ring-naranja-vibrante:focus {
        --tw-ring-color: #f97316;
    }

    .focus\:ring-ambar:focus {
        --tw-ring-color: #f59e0b;
    }

    .focus\:ring-rosa-electrico:focus {
        --tw-ring-color: #ec4899;
    }

    .focus\:ring-verde-menta:focus {
        --tw-ring-color: #10b981;
    }

    .from-naranja-vibrante {
        --tw-gradient-from: #f97316;
    }

    .to-ambar {
        --tw-gradient-to: #f59e0b;
    }
</style>
@endsection
{{-- DEBUG: Solo temporal para verificar --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('=== EDIT PAGE DEBUG ===');
        console.log('Toggle:', document.getElementById('availabilityToggle'));
        console.log('Input:', document.getElementById('availabilityInput'));
        console.log('Valor inicial:', document.getElementById('availabilityInput')?.value);

        // Verificar si ActorFilters se cargó
        console.log('ActorFilters en window:', window.actorFilters);
    });
</script>
@endpush