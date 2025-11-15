@extends('layouts.app')

@section('title', $school->name . ' - Banco de Voces')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header de la Escuela -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-8 text-white">
            <div class="flex justify-between items-start">
                <div class="flex items-start space-x-6">
                    {{-- Logo de la escuela --}}
                    @if($school->logo)
                    <div class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $school->logo) }}"
                            alt="{{ $school->name }}"
                            class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover">
                    </div>
                    @else
                    <div class="flex-shrink-0 w-24 h-24 bg-white bg-opacity-20 rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                        <i class="fas fa-school text-white text-3xl"></i>
                    </div>
                    @endif

                    <div>
                        <h1 class="text-4xl font-bold mb-2">{{ $school->name }}</h1>
                        @if($school->city)
                        <p class="text-xl mb-4">
                            <i class="fas fa-map-marker-alt mr-2"></i>{{ $school->city }}
                        </p>
                        @endif
                        @if($school->founded_year)
                        <p class="text-lg opacity-90">
                            <i class="fas fa-calendar-alt mr-2"></i>Fundada en {{ $school->founded_year }}
                        </p>
                        @endif
                    </div>
                </div>

                {{-- Botones de admin --}}
                @auth
                @if(auth()->user()->role === 'admin')
                <div class="flex space-x-2">
                    <a href="{{ route('admin.schools.edit', $school) }}"
                        class="bg-white text-blue-600 px-4 py-2 rounded hover:bg-gray-100 font-medium">
                        <i class="fas fa-edit mr-1"></i>Editar
                    </a>
                    <form action="{{ route('admin.schools.destroy', $school) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de eliminar esta escuela?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 font-medium">
                            <i class="fas fa-trash mr-1"></i>Eliminar
                        </button>
                    </form>
                </div>
                @endif
                @endauth
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="p-8">
            @if($school->website)
            <div class="mb-6">
                <a href="{{ $school->website }}" target="_blank"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Visitar sitio web
                </a>
            </div>
            @endif

            @if($school->description)
            <div class="prose max-w-none mb-8">
                <h2 class="text-2xl font-bold mb-4">Sobre la escuela</h2>
                <p class="text-gray-700 leading-relaxed text-lg">{{ $school->description }}</p>
            </div>
            @endif

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600 mb-1">{{ $school->actors_count }}</div>
                    <div class="text-gray-600">Actores Formados</div>
                </div>
                @if($school->founded_year)
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 mb-1">{{ now()->year - $school->founded_year }}</div>
                    <div class="text-gray-600">Años de Experiencia</div>
                </div>
                @endif
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600 mb-1">{{ $school->city ? 'Local' : 'Nacional' }}</div>
                    <div class="text-gray-600">Alcance</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección de Profesores --}}
    <section class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Profesorado</h2>

            @auth
            @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.schools.teachers.create', $school) }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                + Agregar Profesor
            </a>
            @endif
            @endauth
        </div>

        @if($school->teacherActors->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($school->teacherActors as $actor)
            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                {{-- Foto del profesor --}}
                @if($actor->photo)
                <img src="{{ asset('storage/' . $actor->photo) }}"
                    alt="{{ $actor->name }}"
                    class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                @else
                <div class="w-24 h-24 bg-gray-300 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <span class="text-gray-600 text-2xl">{{ substr($actor->name, 0, 1) }}</span>
                </div>
                @endif

                {{-- Información del profesor --}}
                <h3 class="text-xl font-semibold text-center text-gray-800 mb-2">
                    {{ $actor->name }}
                </h3>

                @if($actor->pivot->subject)
                <p class="text-green-600 text-center font-medium mb-2">
                    {{ $actor->pivot->subject }}
                </p>
                @endif

                @if($actor->pivot->teaching_bio)
                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                    {{ $actor->pivot->teaching_bio }}
                </p>
                @endif

                {{-- Botones de acción --}}
                <div class="flex justify-between items-center">
                    <a href="{{ route('actors.show', $actor) }}"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Ver perfil completo
                    </a>

                    @auth
                    @if(Auth::user()->role == 'admin')
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.schools.teachers.edit', [$school, $actor]) }}"
                            class="text-yellow-600 hover:text-yellow-800 text-sm">
                            Editar
                        </a>
                        <form action="{{ route('admin.schools.teachers.destroy', [$school, $actor]) }}"
                            method="POST"
                            onsubmit="return confirm('¿Eliminar este profesor?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                Eliminar
                            </button>
                        </form>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-gray-100 rounded-lg p-8 text-center">
            <p class="text-gray-600 mb-4">Esta escuela aún no tiene profesores registrados.</p>
            @auth
            @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.schools.teachers.create', $school) }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg inline-block">
                Agregar el primer profesor
            </a>
            @endif
            @endauth
        </div>
        @endif
    </section>

    <!-- Actores de esta Escuela -->
    @if($school->actors->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Actores Formados en {{ $school->name }}</h2>
        <div class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($school->actors as $actor)
                <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                    {{-- Foto con link --}}
                    <a href="{{ route('actors.show', $actor) }}" class="flex-shrink-0">
                        @if($actor->photo)
                        <img src="{{ asset('storage/' . $actor->photo) }}"
                            alt="{{ $actor->user->name }}"
                            class="w-12 h-12 rounded-full object-cover hover:opacity-80 transition duration-200">
                        @else
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition duration-200">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        @endif
                    </a>

                    <div class="flex-1">
                        {{-- Nombre con link --}}
                        <a href="{{ route('actors.show', $actor) }}" class="hover:text-blue-600 transition duration-200">
                            <h4 class="font-medium text-gray-800 hover:text-blue-600">{{ $actor->user->name }}</h4>
                        </a>

                        {{-- Géneros y edades vocales --}}
                        <p class="text-gray-600 text-sm mb-2">
                            @php
                            $genders = $actor->genders && count($actor->genders) > 0 ? implode(', ', $actor->genders) : 'Género no especificado';
                            $voiceAges = $actor->voice_ages && count($actor->voice_ages) > 0 ? implode(', ', $actor->voice_ages) : 'Edad no especificada';
                            @endphp
                            {{ $genders }} • {{ $voiceAges }}
                        </p>

                        {{-- Biografía breve --}}
                        @if($actor->bio)
                        <p class="text-gray-700 text-sm mb-2 line-clamp-2">
                            {{ Str::limit($actor->bio, 80) }}
                        </p>
                        @endif

                        {{-- Link "Ver perfil" --}}
                        <a href="{{ route('actors.show', $actor) }}"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-block mt-1">
                            Ver perfil completo →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="text-center py-8">
            <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-500 mb-2">No hay actores registrados</h3>
            <p class="text-gray-400">Esta escuela aún no tiene actores asociados en nuestra base de datos.</p>
        </div>
        @endif
    </div>

    <!-- Navegación -->
    <div class="mt-8 flex justify-between">
        <a href="{{ route('schools.index') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>Volver a todas las escuelas
        </a>

        @if($school->actors->count() > 0)
        <div class="text-gray-600">
            Mostrando {{ $school->actors->count() }} actor{{ $school->actors->count() > 1 ? 'es' : '' }}
        </div>
        @endif
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection