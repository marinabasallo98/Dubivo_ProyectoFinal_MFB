<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dubivo')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!--     <style>
        /* Colores personalizados */
        background-color: #eae0c1;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4' viewBox='0 0 4 4'%3E%3Cpath fill='%23fffccb' 
        fill-opacity='0.52' d='M1 3h1v1H1V3zm2-2h1v1H3V1z'%3E%3C/path%3E%3C/svg%3E");
    </style> -->
</head>

<body class="bg-off-white">
    <!-- Header -->
    <header class="bg-negro text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo a la izquierda -->
                <a href="{{ url('/') }}" class="text-2xl font-bold text-rosa-electrico hover:text-ambar transition-colors duration-300">
                    Dubivo
                </a>
                
                <!-- Menú de navegación CENTRADO -->
                <nav class="flex space-x-6 items-center absolute left-1/2 transform -translate-x-1/2">
                    <a href="{{ route('actors.index') }}"
                        class="px-4 py-2 rounded-lg text-white hover:text-naranja-vibrante transition-all duration-300 relative group font-semibold">
                        Actores
                        <span class="absolute bottom-1 left-3 right-3 h-1 bg-naranja-vibrante transform scale-x-0 transition-transform duration-300 group-hover:scale-x-100 rounded-full"></span>
                    </a>
                    <a href="{{ route('schools.index') }}"
                        class="px-4 py-2 rounded-lg text-white hover:text-ambar transition-all duration-300 relative group font-semibold">
                        Escuelas
                        <span class="absolute bottom-1 left-3 right-3 h-1 bg-ambar transform scale-x-0 transition-transform duration-300 group-hover:scale-x-100 rounded-full"></span>
                    </a>
                    <a href="{{ route('works.index') }}"
                        class="px-4 py-2 rounded-lg text-white hover:text-rosa-electrico transition-all duration-300 relative group font-semibold">
                        Obras
                        <span class="absolute bottom-1 left-3 right-3 h-1 bg-rosa-electrico transform scale-x-0 transition-transform duration-300 group-hover:scale-x-100 rounded-full"></span>
                    </a>
                </nav>

                <!-- Menú de usuario a la DERECHA - Simplificado -->
                <nav class="flex items-center">
                    @auth
                        <!-- Menú desplegable único -->
                        <div class="relative">
                            <button id="user-menu-button" class="bg-rosa-electrico hover:bg-naranja-vibrante text-white px-4 py-2 rounded-lg flex items-center text-sm font-semibold transition-colors duration-300">
                                {{ auth()->user()->name }}
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 hidden z-50 border border-gray-200">
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 text-sm font-medium transition-colors duration-200">
                                    <i class="fas fa-cog mr-2"></i>Panel de Administración
                                </a>
                                @endif
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 text-sm font-medium transition-colors duration-200">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                                @if(auth()->user()->role === 'actor')
                                    @if(auth()->user()->actorProfile)
                                    <a href="{{ route('actors.show', auth()->user()->actorProfile) }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 text-sm font-medium transition-colors duration-200">
                                        <i class="fas fa-user mr-2"></i>Mi Perfil
                                    </a>
                                    @else
                                    <a href="{{ route('actors.create') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 text-sm font-medium transition-colors duration-200">
                                        <i class="fas fa-plus-circle mr-2"></i>Crear Perfil
                                    </a>
                                    @endif
                                @endif
                                <div class="border-t border-gray-200 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 text-sm font-medium transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-ambar px-3 py-2 rounded-lg text-sm font-semibold transition-colors duration-300">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="bg-ambar hover:bg-amarillo-dorado text-negro px-4 py-2 rounded-lg text-sm font-bold transition-colors duration-300">
                            Registrarse
                        </a>
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
    <footer class="bg-negro text-white mt-12">
        <div class="container mx-auto px-4 py-6">
            <p class="text-center text-ambar">&copy; 2025 Dubivo. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        // Script para el dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownButton = document.getElementById('user-menu-button');
            const dropdownMenu = document.getElementById('user-menu');

            if (dropdownButton && dropdownMenu) {
                dropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('hidden');
                });

                // Cerrar dropdown al hacer click fuera
                document.addEventListener('click', function() {
                    dropdownMenu.classList.add('hidden');
                });

                // Prevenir que el menú se cierre al hacer click en él
                dropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
</body>

</html>