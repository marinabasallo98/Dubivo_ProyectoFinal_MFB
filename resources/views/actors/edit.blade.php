@extends('layouts.app')

@section('title', 'Editar Perfil de Actor - Banco de Voces')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Editar Perfil de Actor</h1>
            <p class="text-gray-600 mt-2">Actualiza la información de tu perfil</p>
        </div>

        <form action="{{ route('actors.update', $actor) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Información Básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Géneros (MÚLTIPLE SELECCIÓN) -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-3">
        Géneros que puedes interpretar <span class="text-red-500">*</span>
    </label>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        @foreach($genders as $gender)
        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition duration-150">
            <input type="checkbox" name="genders[]" value="{{ $gender }}" 
                   {{ in_array($gender, old('genders', $actor->genders ?? [])) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <span class="ml-3 text-sm font-medium text-gray-700">{{ $gender }}</span>
        </label>
        @endforeach
    </div>
    @error('genders')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                <!-- Edades Vocales (MÚLTIPLE SELECCIÓN) -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-3">
        Edades vocales que puedes interpretar <span class="text-red-500">*</span>
    </label>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach($voiceAges as $age)
        <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition duration-150">
            <input type="checkbox" name="voice_ages[]" value="{{ $age }}" 
                   {{ in_array($age, old('voice_ages', $actor->voice_ages ?? [])) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <span class="ml-3 text-sm font-medium text-gray-700">{{ $age }}</span>
        </label>
        @endforeach
    </div>
    @error('voice_ages')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
            </div>

            <!-- Disponibilidad (CHECKBOX ÚNICO) -->
<div>
    <label class="flex items-center space-x-3 cursor-pointer p-3 border border-gray-300 rounded-lg hover:bg-gray-50">
        <input type="checkbox" name="is_available" value="1" 
               {{ old('is_available', $actor->is_available) ? 'checked' : '' }}
               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
        <span class="text-sm font-medium text-gray-700">Disponible para nuevos proyectos</span>
    </label>
    @error('is_available')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

            <!-- Biografía -->
            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                    Biografía
                </label>
                <textarea name="bio" id="bio" rows="4"
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Cuéntanos sobre tu experiencia, formación y especialidades...">{{ old('bio', $actor->bio) }}</textarea>
                @error('bio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Archivos Actuales -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Foto Actual -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Foto de Perfil Actual
                    </label>
                    @if($actor->photo)
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('storage/' . $actor->photo) }}" 
                                 alt="Foto actual" 
                                 class="w-16 h-16 rounded-full object-cover">
                            <span class="text-sm text-gray-600">Foto actual</span>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No hay foto de perfil</p>
                    @endif
                </div>

                <!-- Audio Actual -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Muestra de Voz Actual
                    </label>
                    @if($actor->audio_path)
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-volume-up text-blue-500 text-xl"></i>
                            <audio controls class="h-8">
                                <source src="{{ asset('storage/' . $actor->audio_path) }}" type="audio/mpeg">
                            </audio>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No hay muestra de voz</p>
                    @endif
                </div>
            </div>

            <!-- Nuevos Archivos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nueva Foto -->
                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                        Cambiar Foto de Perfil
                    </label>
                    <input type="file" name="photo" id="photo" 
                           accept="image/*"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nuevo Audio -->
                <div>
                    <label for="audio_path" class="block text-sm font-medium text-gray-700 mb-2">
                        Cambiar Muestra de Voz
                    </label>
                    <input type="file" name="audio_path" id="audio_path" 
                           accept="audio/*"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Dejar vacío para mantener la actual</p>
                    @error('audio_path')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Escuelas -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Formación Académica
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-48 overflow-y-auto border border-gray-200 rounded-md p-4">
                    @forelse($schools as $school)
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" name="schools[]" value="{{ $school->id }}" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   {{ in_array($school->id, old('schools', $actor->schools->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">
                                {{ $school->name }} 
                                @if($school->city)
                                    <span class="text-gray-500">({{ $school->city }})</span>
                                @endif
                            </span>
                        </label>
                    @empty
                        <p class="text-gray-500 text-sm col-span-2">No hay escuelas registradas</p>
                    @endforelse
                </div>
                @error('schools')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


{{-- Sección para asignar como profesor --}}
@if(Auth::user()->role == 'admin')
<div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
    <h3 class="text-lg font-semibold text-blue-800 mb-4">🏫 Asignar como Profesor</h3>
    
    <form action="{{ route('admin.schools.teachers.store', $actor) }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Escuela</label>
                <select name="school_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Seleccionar escuela...</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" 
                            {{ $actor->teachingSchools->contains($school->id) ? 'selected' : '' }}>
                            {{ $school->name }} - {{ $school->city }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Materia que imparte</label>
                <input type="text" name="subject" 
                       value="{{ $actor->teachingSchools->first() ? $actor->teachingSchools->first()->pivot->subject : '' }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2"
                       placeholder="Ej: Doblaje, Interpretación...">
            </div>
        </div>
        
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Bio como profesor</label>
            <textarea name="teaching_bio" rows="3" 
                      class="w-full border border-gray-300 rounded-lg px-3 py-2"
                      placeholder="Información específica como profesor...">{{ $actor->teachingSchools->first() ? $actor->teachingSchools->first()->pivot->teaching_bio : '' }}</textarea>
        </div>
        
        <div class="mt-4 flex justify-between">
            @if($actor->teachingSchools->count() > 0)
                <button type="submit" name="action" value="update" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Actualizar información de profesor
                </button>
                <button type="submit" name="action" value="remove" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg"
                        onclick="return confirm('¿Remover como profesor?')">
                    Remover como profesor
                </button>
            @else
                <button type="submit" name="action" value="add" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                    Asignar como profesor
                </button>
            @endif
        </div>
    </form>
</div>
@endif

            <!-- Obras -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Trabajos Destacados
                </label>
                <div class="space-y-3 max-h-48 overflow-y-auto border border-gray-200 rounded-md p-4">
                    @forelse($works as $work)
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" name="works[]" value="{{ $work->id }}" 
                                   class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   {{ in_array($work->id, old('works', $actor->works->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-700">{{ $work->title }}</span>
                                <div class="text-xs text-gray-500">
                                    <span class="capitalize">{{ $work->type }}</span>
                                    @if($work->year)
                                        · {{ $work->year }}
                                    @endif
                                </div>
                                <!-- Campo para nombre del personaje -->
                                @php
                                    $characterName = $actor->works->find($work->id)->pivot->character_name ?? '';
                                @endphp
                                <input type="text" name="character_names[{{ $work->id }}]" 
                                       placeholder="Personaje que interpretaste"
                                       class="mt-1 w-full text-xs border border-gray-300 rounded px-2 py-1"
                                       value="{{ old('character_names.' . $work->id, $characterName) }}">
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No hay obras registradas</p>
                    @endforelse
                </div>
                @error('works')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('actors.show', $actor) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition duration-200">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                    Actualizar Perfil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection