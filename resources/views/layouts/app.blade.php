<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Banco de Voces')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold">Banco de Voces</a>
                <nav class="flex space-x-4 items-center">
                    <!-- Menú de navegación común -->
                    <a href="{{ route('actors.index') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Actores</a>
                    <a href="{{ route('schools.index') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Escuelas</a>
                    <a href="{{ route('works.index') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Obras</a>
                    
                    @auth
                        <!-- Menú según rol -->
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="bg-red-600 hover:bg-red-500 px-3 py-2 rounded">Admin</a>
                        @endif
                        
                        @if(auth()->user()->role === 'actor')
                            @if(auth()->user()->actorProfile)
                                <a href="{{ route('actors.show', auth()->user()->actorProfile) }}" class="hover:bg-blue-500 px-3 py-2 rounded">Mi Perfil</a>
                            @else
                                <a href="{{ route('actors.create') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Crear Perfil</a>
                            @endif
                        @endif
                        
                        @if(auth()->user()->role === 'client' || auth()->user()->role === 'admin')
                            <a href="{{ route('requests.index') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Solicitudes</a>
                        @endif

                        <!-- Dropdown usuario -->
                        <div class="relative">
                            <button class="hover:bg-blue-500 px-3 py-2 rounded flex items-center">
                                {{ auth()->user()->name }}
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Mi Perfil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Cerrar Sesión</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="hover:bg-blue-500 px-3 py-2 rounded">Registrarse</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-6">
            <p class="text-center">&copy; 2024 Banco de Voces. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // Script para el dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownButton = document.querySelector('.relative button');
            const dropdownMenu = document.querySelector('.absolute');
            
            dropdownButton.addEventListener('click', function() {
                dropdownMenu.classList.toggle('hidden');
            });
            
            // Cerrar dropdown al hacer click fuera
            document.addEventListener('click', function(event) {
                if (!dropdownButton.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>