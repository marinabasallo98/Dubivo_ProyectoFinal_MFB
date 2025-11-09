@extends('layouts.app')

@section('title', 'Obras y Producciones - Banco de Voces')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Obras y Producciones</h1>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.works.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    <i class="fas fa-plus mr-2"></i>Nueva Obra
                </a>
            @endif
        @endauth
    </div>

    <!-- Filtros -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-semibold mb-4">Filtrar Obras</h2>
        <form method="GET" action="{{ route('works.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                <select name="type" class="w-full border border-gray-300 rounded-md p-2">
                    <option value="">Todos los tipos</option>
                    <option value="movie" {{ request('type') == 'movie' ? 'selected' : '' }}>Película</option>
                    <option value="series" {{ request('type') == 'series' ? 'selected' : '' }}>Serie</option>
                    <option value="commercial" {{ request('type') == 'commercial' ? 'selected' : '' }}>Comercial</option>
                    <option value="animation" {{ request('type') == 'animation' ? 'selected' : '' }}>Animación</option>
                    <option value="videogame" {{ request('type') == 'videogame' ? 'selected' : '' }}>Videojuego</option>
                    <option value="documentary" {{ request('type') == 'documentary' ? 'selected' : '' }}>Documental</option>
                    <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                <input type="number" name="year" value="{{ request('year') }}" 
                       placeholder="Ej: 2023" 
                       class="w-full border border-gray-300 rounded-md p-2"
                       min="1900" max="{{ date('Y') + 5 }}">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ordenar por</label>
                <select name="sort" class="w-full border border-gray-300 rounded-md p-2">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Más recientes</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Más antiguas</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Título A-Z</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
                    <i class="fas fa-filter mr-2"></i>Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Obras -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($works as $work)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                <!-- Poster -->
                @if($work->poster)
                    <img src="{{ asset('storage/' . $work->poster) }}" alt="{{ $work->title }}" 
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                        <i class="fas fa-{{ $work->type == 'movie' ? 'film' : ($work->type == 'series' ? 'tv' : 'gamepad') }} text-white text-4xl"></i>
                    </div>
                @endif
                
                <!-- Contenido -->
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-lg leading-tight">{{ $work->title }}</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded capitalize">
                            {{ $work->type }}
                        </span>
                    </div>
                    
                    <div class="space-y-1 mb-3">
                        @if($work->year)
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-calendar mr-1"></i>{{ $work->year }}
                            </p>
                        @endif
                        
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-users mr-1"></i>{{ $work->actors_count }} actores
                        </p>
                    </div>

                    @if($work->description)
                        <p class="text-gray-700 text-sm mb-4 line-clamp-2">{{ Str::limit($work->description, 80) }}</p>
                    @endif

                    <a href="{{ route('works.show', $work) }}" class="block w-full bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 text-sm">
                        Ver Detalles
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-film text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-500 mb-2">No hay obras registradas</h3>
                <p class="text-gray-400">No se encontraron obras con los filtros aplicados.</p>
                @if(request()->anyFilled(['type', 'year', 'sort']))
                    <a href="{{ route('works.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                        Limpiar filtros
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($works->hasPages())
        <div class="mt-8">
            {{ $works->links() }}
        </div>
    @endif
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection