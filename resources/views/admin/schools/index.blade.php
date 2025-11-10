@extends('layouts.app')

@section('title', 'Gestión de Escuelas - Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Gestión de Escuelas</h1>
                <p class="text-gray-600 mt-2">Administra todas las escuelas de doblaje registradas</p>
            </div>
            <a href="{{ route('admin.schools.create') }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Nueva Escuela
            </a>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $schools->total() }}</div>
            <div class="text-sm text-gray-600">Total Escuelas</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-orange-600">{{ $schools->sum('teachers_count') }}</div>
            <div class="text-sm text-gray-600">Total Profesores</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-orange-600">{{ $schools->sum('actors_count') }}</div>
            <div class="text-sm text-gray-600">Total Actores</div>
        </div>
    </div>

    <!-- Lista de Escuelas -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Escuela
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ciudad
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Año
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actores
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($schools as $school)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            
                            <!-- Nombre -->
                            <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex items-center">
        @if($school->logo)
            <img class="h-10 w-10 rounded-lg object-cover mr-3" 
                 src="{{ asset('storage/' . $school->logo) }}" 
                 alt="{{ $school->name }}">
        @else
            <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-school text-blue-600"></i>
            </div>
        @endif
        <div>
            <div class="text-sm font-medium text-gray-900">{{ $school->name }}</div>
            @if($school->website)
                <div class="text-sm text-gray-500">
                    <a href="{{ $school->website }}" target="_blank" class="hover:text-blue-600">
                        {{ parse_url($school->website, PHP_URL_HOST) }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</td>

                            <!-- Ciudad -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $school->city ?? '<span class="text-gray-400">No especificada</span>' }}
                                </div>
                            </td>

                            <!-- Año -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $school->founded_year ?? '<span class="text-gray-400">-</span>' }}
                                </div>
                            </td>

                            <!-- Actores -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">
                                    {{ $school->actors_count }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    actores formados
                                </div>
                            </td>

                            <!-- Estado -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $school->actors_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $school->actors_count > 0 ? 'Activa' : 'Sin actores' }}
                                </span>
                            </td>

                            <!-- Acciones -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
    <div class="flex space-x-2">
        <a href="{{ route('schools.show', $school) }}" 
           class="text-blue-600 hover:text-blue-900" 
           title="Ver pública">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('admin.schools.edit', $school) }}" 
           class="text-green-600 hover:text-green-900"
           title="Editar">
            <i class="fas fa-edit"></i>
        </a>
        <form action="{{ route('admin.schools.destroy', $school) }}" 
              method="POST" 
              class="inline"
              onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta escuela? Esta acción no se puede deshacer.');">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="text-red-600 hover:text-red-900"
                    title="Eliminar">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>
</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <i class="fas fa-school text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">No hay escuelas registradas</p>
                                    <p class="mt-2">Comienza añadiendo la primera escuela</p>
                                    <a href="{{ route('admin.schools.create') }}" 
                                       class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                        Crear Primera Escuela
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($schools->hasPages())
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                {{ $schools->links() }}
            </div>
        @endif
    </div>

    <!-- Información Adicional -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Información de gestión</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>• Solo puedes eliminar escuelas que no tengan actores asociados</p>
                    <p>• Las escuelas con actores aparecen como "Activas"</p>
                    <p>• Los cambios se reflejan inmediatamente en la vista pública</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection