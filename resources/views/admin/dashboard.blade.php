@extends('layouts.app')

@section('title', 'Panel de Administración - Banco de Voces')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Panel de Administración</h1>
        <p class="text-gray-600 mt-2">Gestiona todos los aspectos del banco de voces</p>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
    <!-- Total Usuarios -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Usuarios</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
            </div>
        </div>
    </div>

    <!-- Total Actores -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center">
            <div class="bg-green-100 p-3 rounded-full">
                <i class="fas fa-user-tie text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Actores</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_actors'] }}</p>
            </div>
        </div>
    </div>

        <!-- Total Clientes -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
        <div class="flex items-center">
            <div class="bg-purple-100 p-3 rounded-full">
                <i class="fas fa-user text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Clientes</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_clients'] }}</p>
            </div>
        </div>
    </div>

        <!-- Total Escuelas -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
        <div class="flex items-center">
            <div class="bg-orange-100 p-3 rounded-full">
                <i class="fas fa-school text-orange-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Escuelas</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_schools'] }}</p>
            </div>
        </div>
    </div>

        <!-- Total Obras -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
        <div class="flex items-center">
            <div class="bg-indigo-100 p-3 rounded-full">
                <i class="fas fa-film text-indigo-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Obras</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_works'] }}</p>
            </div>
        </div>
    </div>

        <!-- Total Profesores -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
        <div class="flex items-center">
            <div class="bg-indigo-100 p-3 rounded-full">
                <i class="fas fa-film text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Profesores</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_teacher_actors'] }}</p>
            </div>
        </div>
    </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

        <!-- Gestionar Actores -->
        <a href="{{ route('admin.actors') }}"
            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 border border-gray-200">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Gestionar Actores</h3>
                    <p class="text-gray-600 text-sm mt-1">Administrar todos los actores registrados</p>
                </div>
            </div>
        </a>

        <!-- Gestionar Escuelas -->
        <a href="{{ route('admin.schools') }}"
            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 border border-gray-200">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-school text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Gestionar Escuelas</h3>
                    <p class="text-gray-600 text-sm mt-1">Añadir, editar o eliminar escuelas</p>
                </div>
            </div>
        </a>

        <!-- Gestionar Obras -->
        <a href="{{ route('admin.works') }}"
            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 border border-gray-200">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-film text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Gestionar Obras</h3>
                    <p class="text-gray-600 text-sm mt-1">Administrar películas y series</p>
                </div>
            </div>
        </a>

        <!-- Gestionar Usuarios -->
        <a href="{{ route('admin.users') }}"
            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 border border-gray-200">
            <div class="flex items-center">
                <div class="bg-orange-100 p-3 rounded-full">
                    <i class="fas fa-users-cog text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Gestionar Usuarios</h3>
                    <p class="text-gray-600 text-sm mt-1">Administrar todos los usuarios del sistema</p>
                </div>
            </div>
        </a>

        <!-- Ver Solicitudes -->
        <a href="{{ route('requests.index') }}"
            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 border border-gray-200">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-envelope text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Ver Solicitudes</h3>
                    <p class="text-gray-600 text-sm mt-1">Revisar todas las solicitudes</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Actividad Reciente -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Últimas Solicitudes -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Solicitudes Recientes</h2>
            <div class="space-y-3">
                @forelse($recentRequests as $request)
                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-800">{{ $request->subject }}</p>
                        <p class="text-sm text-gray-600">
                            De: {{ $request->client->name }} → Para: {{ $request->actor->name }}
                        </p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                            {{ $request->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $request->status == 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $request->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($request->status) }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No hay solicitudes recientes</p>
                @endforelse
            </div>
        </div>

        <!-- Últimos Actores Registrados -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Actores Recientes</h2>
            <div class="space-y-3">
                @forelse($recentActors as $actor)
                <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                    @if($actor->photo)
                    <img src="{{ asset('storage/' . $actor->photo) }}"
                        alt="{{ $actor->user->name }}"
                        class="w-10 h-10 rounded-full object-cover">
                    @else
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    @endif
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">{{ $actor->user->name }}</p>
                        <p class="text-sm text-gray-600 capitalize">
                            @if($actor->genders && count($actor->genders) > 0)
                        {{ implode(', ', $actor->genders) }}
                    @else
                        Género no especificado
                    @endif
                    
                    • 
                    
                    @if($actor->voice_ages && count($actor->voice_ages) > 0)
                        {{ implode(', ', $actor->voice_ages) }}
                    @else
                        Edad no especificada
                    @endif
                </p>
            </div>
        </div>
        @empty
        <p class="text-gray-500 text-center py-4">No hay actores registrados recientemente</p>
        @endforelse
    </div>
</div>
    </div>
</div>
@endsection