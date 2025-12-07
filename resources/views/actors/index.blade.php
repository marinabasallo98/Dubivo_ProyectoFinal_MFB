@extends('layouts.app')

@section('title', 'Actores de Voz - Dubivo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Actores de Voz</h1>

        @auth
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.actors.create') }}"
            class="bg-verde-menta text-white px-6 py-3 hover:bg-verde-menta hover:bg-opacity-90 transition duration-200 flex items-center font-semibold">
            <i class="fas fa-plus mr-2"></i>
            Nuevo Actor
        </a>
        @endif
        @endauth
    </div>

    <p class="text-gray-600 mb-8 max-w-3xl text-lg">
        Descubre a las mejores voces del doblaje de España y al talento emergente en nuestra plataforma.
    </p>

    <div class="lg:hidden mb-4">
        <button id="filterToggle" class="bg-azul-profundo text-white px-4 py-2 hover:bg-azul-profundo hover:bg-opacity-90 transition duration-200 flex items-center font-semibold w-full justify-center">
            <i class="fas fa-filter mr-2"></i>
            Mostrar Filtros
        </button>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Filtros -->
        <div id="filterColumn" class="lg:w-1/4 hidden lg:block">
            <div class="bg-white p-6 shadow-md sticky top-4 border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Filtros</h2>
                    <button id="closeFilters" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <form method="GET" action="{{ route('actors.index') }}" id="filter-form">

                    <!-- Buscador -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Actor</label>
                        <input type="text" name="search" placeholder="Ej: Constantino..."
                            class="w-full border border-gray-300 px-4 py-2 focus:border-azul-profundo focus:ring-azul-profundo"
                            value="{{ request('search') }}">
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-semibold text-lg mb-2">Disponibilidad</h3>

                        {{-- Disponible (Verde) --}}
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="availability" value="1"
                                {{ request('availability') === '1' ? 'checked' : '' }}
                                class="form-radio h-4 w-4 text-verde-menta accent-verde-menta">
                            <span>Disponible</span>
                        </label>

                        {{-- No Disponible (Rojo) --}}
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="availability" value="0"
                                {{ request('availability') === '0' ? 'checked' : '' }}
                                {{-- Usamos red-600 como rojo estándar, asumiendo que es tu rojo primario --}}
                                class="form-radio h-4 w-4 text-red-600 accent-red-600">
                            <span>No Disponible</span>
                        </label>

                        {{-- Ocultar selección (Blanco/Gris) --}}
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="availability" value=""
                                {{ request('availability') === null || request('availability') === '' ? 'checked' : '' }}
                                class="form-radio h-4 w-4 text-gray-500 accent-gray-500">
                            <span>Cualquiera</span>
                        </label>
                    </div>

                    {{-- Filtro por Géneros --}}
                    <div class="space-y-2 mt-4">
                        <h3 class="font-semibold text-lg mb-2">Géneros</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($genders as $gender)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="genders[]" value="{{ $gender }}"
                                    {{ in_array($gender, request('genders', [])) ? 'checked' : '' }}
                                    class="form-checkbox h-4 w-4 text-naranja-vibrante accent-naranja-vibrante rounded">
                                <span>{{ $gender }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Filtro por Edades Vocales --}}
                    <div class="space-y-2 mt-4">
                        <h3 class="font-semibold text-lg mb-2">Edad Vocal</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($voiceAges as $age)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="voice_ages[]" value="{{ $age }}"
                                    {{ in_array($age, request('voice_ages', [])) ? 'checked' : '' }}
                                    class="form-checkbox h-4 w-4 text-rosa-electrico accent-rosa-electrico rounded">
                                <span>{{ $age }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Filtro por Escuelas --}}
                    <div class="space-y-2 mt-4">
                        <h3 class="font-semibold text-lg mb-2">Escuelas</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($schools as $school)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="schools[]" value="{{ $school->id }}"
                                    {{ in_array($school->id, request('schools', [])) ? 'checked' : '' }}
                                    class="form-checkbox h-4 w-4 text-ambar accent-ambar rounded">
                                <span>{{ $school->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Botones de acción al final del formulario de filtros --}}
                    <div class="flex flex-col space-y-3 mt-8">
                        {{-- Botón Aplicar Filtros (Acción principal: Verde Menta) --}}
                        <button type="submit"
                            class="bg-verde-menta text-negro px-4 py-2 font-bold rounded-lg 
               shadow-lg hover:bg-verde-menta/80 transition duration-300">
                            <i class="fas fa-search mr-2"></i>
                            Aplicar Filtros
                        </button>

                        {{-- Botón Limpiar Filtros (Acción secundaria: Gris/Negro) --}}
                        {{-- Usamos la ruta base 'actors.index' para limpiar todos los filtros --}}
                        <a href="{{ route('actors.index') }}"
                            class="text-center bg-negro text-white px-4 py-2 font-semibold rounded-lg 
               shadow-lg hover:bg-gray-700 transition duration-300">
                            <i class="fas fa-undo-alt mr-2"></i>
                            Limpiar Filtros
                        </a>
                    </div>

                </form>
            </div>
        </div>

        <!-- Resultados -->
        <div class="lg:w-3/4">
            <div class="mb-4">
                <p class="text-sm text-gray-600">{{ $actors->total() }} actores encontrados</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($actors as $actor)
                <div class="actor-card bg-white shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-naranja-vibrante flex flex-col h-full relative">

                    <!-- Foto -->
                        <div class="absolute top-2 right-2 z-30">
                            <div class="w-4 h-4 {{ $actor->is_available ? 'bg-verde-menta' : 'bg-rojo-intenso' }} border border-white shadow-sm"></div>
                        </div>
                        @if($actor->photo)
                        <img src="{{ asset('storage/' . $actor->photo) }}" alt="{{ $actor->name }}" class="w-full h-64 object-cover">
                        @else
                        <div class="w-full h-64 bg-gray-100 flex items-center justify-center group-hover:bg-gray-200">
                            <i class="fas fa-user text-gray-400 text-4xl"></i>
                        </div>
                        @endif

                    <!-- Info -->
                    <a href="{{ route('actors.show', $actor) }}" class="block p-4 flex flex-col flex-1">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $actor->name }}</h3>
                        <p class="text-gray-600 text-sm mb-1"><strong>Géneros:</strong> {{ implode(', ', $actor->genders_array) ?: 'No especificado' }}</p>
                        <p class="text-gray-600 text-sm mb-1"><strong>Edades vocales:</strong> {{ implode(', ', $actor->voice_ages_array) ?: 'No especificado' }}</p>
                        @if($actor->bio)
                        <p class="text-gray-700 text-sm line-clamp-2">{{ Str::limit($actor->bio, 100) }}</p>
                        @endif
                    </a>
                </div>
                @empty
                <div class="text-center py-12 col-span-full">
                    <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-500 mb-2">No se encontraron actores</h3>
                    <p class="text-gray-400">Intenta con otros términos de búsqueda o ajusta los filtros.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $actors->links() }}
            </div>
        </div>
    </div>
</div>

<audio id="globalAudio" class="hidden"></audio>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle filtros móvil
        const filterToggle = document.getElementById('filterToggle');
        const filterColumn = document.getElementById('filterColumn');
        const closeFilters = document.getElementById('closeFilters');
        if (filterToggle && filterColumn) {
            filterToggle.addEventListener('click', () => filterColumn.classList.toggle('hidden'));
            if (closeFilters) closeFilters.addEventListener('click', () => filterColumn.classList.add('hidden'));
        }
    });
</script>
@endsection