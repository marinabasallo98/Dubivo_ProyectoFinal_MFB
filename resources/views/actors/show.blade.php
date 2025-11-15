@extends('layouts.app')

@section('title', $actor->name . ' - Banco de Voces')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header del perfil -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="md:flex">
            <!-- Foto -->
            <div class="md:w-1/3">
                @if($actor->photo)
                <img src="{{ asset('storage/' . $actor->photo) }}" alt="{{ $actor->name }}" class="w-full h-64 object-cover">
                @else
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">Sin foto</span>
                </div>
                @endif
            </div>

            <!-- Información -->
            <div class="md:w-2/3 p-6">
               <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $actor->name }}</h1>
                    
                    <div class="flex items-center space-x-4 mb-4">
                        @if($actor->is_available)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-check mr-1"></i>Disponible
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-times mr-1"></i>No disponible
                            </span>
                        @endif
                    </div>
                </div>
                
                {{-- BOTONES DE ADMIN (COMO EN WORKS) --}}
                @auth
                    @if(Auth::user()->role == 'admin')
                        <div class="flex space-x-3">
                            {{-- Botón Editar --}}
                            <a href="{{ route('admin.actors.edit', $actor) }}" 
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center">
                               <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                               </svg>
                               Editar
                            </a>
                            
                            {{-- Botón Eliminar --}}
                            <form action="{{ route('admin.actors.destroy', $actor) }}" method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de que quieres eliminar este actor? Esta acción no se puede deshacer.');">
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
                    @endif
                @endauth
            </div>
            {{-- FIN DE LA NUEVA SECCIÓN --}}

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <span class="font-semibold">Género:</span>
                    @if($actor->genders && count($actor->genders) > 0)
                        {{ implode(', ', $actor->genders) }}
                    @else
                        No especificados
                    @endif
                </div>
                <div>
                    <span class="font-semibold">Edad vocal:</span>
                    @if($actor->voice_ages && count($actor->voice_ages) > 0)
                        {{ implode(', ', $actor->voice_ages) }}
                    @else
                        No especificadas
                    @endif
                </div>

            </div>

            <!-- Audio -->
            @if($actor->audio_path)
                <div class="mb-4">
                    <span class="font-semibold block mb-2">Muestra de voz:</span>
                    <audio controls class="w-full">
                        <source src="{{ asset('storage/' . $actor->audio_path) }}" type="audio/mpeg">
                        Tu navegador no soporta el elemento de audio.
                    </audio>
                </div>
            @endif

            <!-- Acciones -->
            @auth
                @if(Auth::user()->role == 'client' || Auth::user()->role == 'admin')
                    <a href="{{ route('requests.create', $actor->id) }}" 
                       class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                        <i class="fas fa-envelope mr-2"></i>Contactar Actor
                    </a>
                @else
                    <button onclick="openContactModal()"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                        <i class="fas fa-envelope mr-2"></i>Contactar Actor
                    </button>
                @endif
            @else
                <button onclick="openContactModal()"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                    <i class="fas fa-envelope mr-2"></i>Contactar Actor
                </button>
            @endauth
        </div>
    </div>
</div>

    <!-- Biografía -->
    @if($actor->bio)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">Biografía</h2>
        <p class="text-gray-700 leading-relaxed">{{ $actor->bio }}</p>
    </div>
    @endif

    <!-- Escuelas -->
    @if($actor->schools->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">Formación</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($actor->schools as $school)
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="font-semibold text-lg">{{ $school->name }}</h3>
                <p class="text-gray-600">{{ $school->city }}</p>
                <a href="{{ route('schools.show', $school) }}" class="text-blue-600 hover:underline mt-2 inline-block">
                    Ver escuela
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Obras -->
    @if($actor->works->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">Trabajos Destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($actor->works as $work)
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="font-semibold text-lg">{{ $work->title }}</h3>
                <p class="text-gray-600 capitalize">{{ $work->type }} ({{ $work->year }})</p>
                @if($work->pivot->character_name)
                <p class="text-sm text-gray-500">Personaje: {{ $work->pivot->character_name }}</p>
                @endif
                <a href="{{ route('works.show', $work) }}" class="text-blue-600 hover:underline mt-2 inline-block">
                    Ver obra
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
{{-- Modal de Contacto --}}
<div id="contactModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            {{-- Icono --}}
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full 
                       {{ Auth::check() && Auth::user()->role == 'actor' ? 'bg-yellow-100' : 'bg-blue-100' }}">
                <i class="{{ Auth::check() && Auth::user()->role == 'actor' ? 'fas fa-exclamation-triangle text-yellow-600' : 'fas fa-lock text-blue-600' }} text-xl"></i>
            </div>

            {{-- Título --}}
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">
                @if(Auth::check() && Auth::user()->role == 'actor')
                Acción no disponible
                @else
                Inicia sesión para contactar
                @endif
            </h3>

            {{-- Mensaje --}}
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    @if(Auth::check() && Auth::user()->role == 'actor')
                    Los actores no pueden contactar a otros actores. Por favor, utilice otros medios de comunicación.
                    @else
                    Para contactar a <span class="font-semibold">{{ $actor->user->name }}</span> necesitas una cuenta de cliente.
                    @endif
                </p>
            </div>

            {{-- Botones --}}
            <div class="items-center px-4 py-3">
                @if(Auth::check() && Auth::user()->role == 'actor')
                <button onclick="closeContactModal()"
                    class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Entendido
                </button>
                @else
                <div class="flex space-x-2">
                    <a href="{{ route('login') }}"
                        class="flex-1 px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 text-center">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register.client') }}"
                        class="flex-1 px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 text-center">
                        Registrarse
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- JavaScript para el modal --}}
<script>
    function openContactModal() {
        document.getElementById('contactModal').classList.remove('hidden');
    }

    function closeContactModal() {
        document.getElementById('contactModal').classList.add('hidden');
    }

    // Cerrar modal al hacer click fuera
    document.getElementById('contactModal').addEventListener('click', function(e) {
        if (e.target.id === 'contactModal') {
            closeContactModal();
        }
    });

    // Cerrar modal con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeContactModal();
        }
    });
</script>

<style>
    #contactModal {
        backdrop-filter: blur(4px);
    }
</style>
@endsection