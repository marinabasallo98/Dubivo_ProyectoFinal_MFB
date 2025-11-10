@extends('layouts.app')

@section('title', $work->title . ' - Banco de Voces')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header de la Obra -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="md:flex">
            <!-- Poster -->
            <div class="md:w-1/3">
                @if($work->poster)
                    <img src="{{ asset('storage/' . $work->poster) }}" 
                         alt="{{ $work->title }}" 
                         class="w-full h-64 md:h-full object-cover">
                @else
                    <div class="w-full h-64 md:h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                        <i class="fas fa-{{ $work->type == 'movie' ? 'film' : ($work->type == 'series' ? 'tv' : ($work->type == 'videogame' ? 'gamepad' : 'bullhorn')) }} text-white text-6xl"></i>
                    </div>
                @endif
            </div>
            
            <!-- Información -->
            <div class="md:w-2/3 p-8">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-4xl font-bold mb-2">{{ $work->title }}</h1>
                        
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium capitalize">
                                {{ $work->type }}
                            </span>
                            @if($work->year)
                                <span class="text-gray-600">
                                    <i class="fas fa-calendar-alt mr-1"></i>{{ $work->year }}
                                </span>
                            @endif
                            <span class="text-gray-600">
                                <i class="fas fa-users mr-1"></i>{{ $work->actors_count }} actores
                            </span>
                        </div>
                    </div>
                    
                    @auth
    @if(Auth::user()->role == 'admin')
        
            <div class="flex justify-between items-center">
                <div class="flex space-x-3">
                    {{-- Botón Editar --}}
                    <a href="{{ route('admin.works.edit', $work) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center">
                       <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                       </svg>
                       Editar
                    </a>
                    
                    {{-- Botón Eliminar --}}
                    <form action="{{ route('admin.works.destroy', $work) }}" method="POST" 
                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta obra? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            
        </div>
    @endif
@endauth
                </div>

                @if($work->description)
                    <div class="prose max-w-none mb-6">
                        <p class="text-gray-700 leading-relaxed text-lg">{{ $work->description }}</p>
                    </div>
                @endif

                <!-- Metadatos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-semibold text-gray-600">Tipo:</span>
                        <span class="ml-2 capitalize">{{ $work->type }}</span>
                    </div>
                    @if($work->year)
                        <div>
                            <span class="font-semibold text-gray-600">Año:</span>
                            <span class="ml-2">{{ $work->year }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="font-semibold text-gray-600">Actores participantes:</span>
                        <span class="ml-2">{{ $work->actors_count }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-600">Registrada:</span>
                        <span class="ml-2">{{ $work->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actores que participaron -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold mb-6">Actores en esta obra</h2>
        
        @if($work->actors->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($work->actors as $actor)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-300">
                        <div class="flex items-start space-x-4">
                            @if($actor->photo)
                                <img src="{{ asset('storage/' . $actor->photo) }}" 
                                     alt="{{ $actor->name }}" 
                                     class="w-16 h-16 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <h3 class="font-semibold text-lg mb-1">{{ $actor->name }}</h3>
                                
                                <!-- Personaje (si existe) -->
                                @if($actor->pivot->character_name)
                                    <p class="text-blue-600 font-medium text-sm mb-2">
                                        Personaje: {{ $actor->pivot->character_name }}
                                    </p>
                                @endif
                                
                                <p class="text-gray-600 text-sm mb-2 capitalize">
                                    {{ $actor->gender }} • {{ str_replace('_', ' ', $actor->voice_age) }}
                                </p>
                                
                                @if($actor->bio)
                                    <p class="text-gray-700 text-sm mb-3 line-clamp-2">
                                        {{ Str::limit($actor->bio, 80) }}
                                    </p>
                                @endif
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('actors.show', $actor) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Ver perfil →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-500 mb-2">No hay actores registrados</h3>
                <p class="text-gray-400">Esta obra aún no tiene actores asociados en nuestra base de datos.</p>
            </div>
        @endif
    </div>

    

    <!-- Obras Relacionadas (mismo tipo) -->
    @if($relatedWorks->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6">Obras similares</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($relatedWorks as $related)
                    <a href="{{ route('works.show', $related) }}" 
                       class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-300 block">
                        <h4 class="font-semibold text-lg mb-2">{{ $related->title }}</h4>
                        <div class="flex items-center space-x-2 text-sm text-gray-600">
                            <span class="capitalize">{{ $related->type }}</span>
                            @if($related->year)
                                <span>•</span>
                                <span>{{ $related->year }}</span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 mt-2">
                            {{ $related->actors_count }} actores
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Navegación -->
    <div class="mt-8 flex justify-between items-center">
        <a href="{{ route('works.index') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>Volver a todas las obras
        </a>
        
        @if($work->actors->count() > 0)
            <div class="text-gray-600 text-sm">
                Mostrando {{ $work->actors->count() }} actor{{ $work->actors->count() > 1 ? 'es' : '' }}
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