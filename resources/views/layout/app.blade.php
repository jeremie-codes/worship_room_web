<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'RH ANADEC' }}</title>
    <meta name="description" content="Système de gestion des ressources humaines ANADEC">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite('resources/css/app.css')
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar (navigation latérale) -->
        <div id="sidebar" class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-blue-800 text-white">
                <div class="flex items-center justify-center h-16 px-4 bg-blue-900">
                    <h1 class="text-xl font-bold tracking-wider">RH ANADEC</h1>
                </div>
                <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
                    <nav class="flex-1 space-y-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 transition duration-150 ease-in-out rounded-lg hover:bg-blue-500 {{ request()->routeIs('dashboard') ? 'bg-blue-500' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="ml-3">Tableau de bord</span>
                        </a>
                        <a href="{{ route('employes.index') }}" class="flex items-center px-4 py-3 transition duration-150 ease-in-out rounded-lg hover:bg-blue-500 {{ request()->routeIs('employes.*') ? 'bg-blue-500' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="ml-3">Employés</span>
                        </a>
                        <a href="{{ route('conges.index') }}" class="flex items-center px-4 py-3 transition duration-150 ease-in-out rounded-lg hover:bg-blue-500 {{ request()->routeIs('conges.*') ? 'bg-blue-500' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="ml-3">Congés</span>
                        </a>
                        <a href="{{ route('presences.index') }}" class="flex items-center px-4 py-3 transition duration-150 ease-in-out rounded-lg hover:bg-blue-500 {{ request()->routeIs('presences.*') ? 'bg-blue-500' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="ml-3">Présences</span>
                        </a>
                        <a href="{{ route('users.roles') }}" class="flex items-center px-4 py-3 transition duration-150 ease-in-out rounded-lg hover:bg-blue-500 {{ request()->routeIs('users.*') ? 'bg-blue-500' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                            <span class="ml-3">Rôles & Permissions</span>
                        </a>
                        <a href="{{ route('logistique.index') }}" class="flex items-center px-4 py-3 transition duration-150 ease-in-out rounded-lg hover:bg-blue-500 {{ request()->routeIs('logistique.*') ? 'bg-blue-500' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <span class="ml-3">Logistique</span>
                        </a>
                    </nav>
                </div>
                <div class="p-4 bg-blue-900">
                    <div class="flex items-center">
                        <img class="w-8 h-8 rounded-full" src="https://randomuser.me/api/portraits/men/1.jpg" alt="Photo de profil">
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                            <a href="{{ route('logout') }}" class="text-xs text-blue-200 hover:text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Déconnexion
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            <!-- En-tête -->
            <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200">
                <button id="menu-toggle" class="block p-2 md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="flex items-center ml-auto">
                    <div class="relative">
                        <button class="p-1 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span class="absolute top-0 right-0 flex items-center justify-center w-4 h-4 text-xs font-semibold text-white bg-red-500 rounded-full">3</span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Contenu de la page -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>

            <!-- Pied de page -->
            <footer class="py-4 text-center text-sm text-gray-500 bg-white border-t border-gray-200">
                <p>&copy; {{ date('Y') }} ANADEC - Tous droits réservés</p>
            </footer>
        </div>
    </div>

    <!-- Script pour le toggle du menu mobile -->
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });
    </script>
</body>
</html>
