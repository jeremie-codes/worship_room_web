<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Worship Room - Plateforme de Streaming en Direct')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        accent: {
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Inter Font -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        @auth
            <!-- Sidebar -->
            <aside class="w-64 bg-gray-800 border-r border-gray-700 flex-shrink-0">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-accent-500 rounded-lg flex items-center justify-center">
                            <i class='bx bx-video text-white text-xl'></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-white">Worship Room</h1>
                            <p class="text-sm text-gray-400">Streaming en Direct</p>
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="mb-8 p-4 bg-gray-700/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center">
                                @if(auth()->user()->avatar)
                                    <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full rounded-full object-cover">
                                @else
                                    <i class='bx bx-user text-white'></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 capitalize">{{ auth()->user()->role === 'broadcaster' ? 'Diffuseur' : 'Spectateur' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="space-y-2">
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-3 px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary-500/20 text-primary-400 border-l-4 border-primary-500' : '' }}">
                            <i class='bx bx-home text-xl'></i>
                            <span>Tableau de Bord</span>
                        </a>

                        <a href="{{ route('streams.index') }}"
                           class="flex items-center gap-3 px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('streams.*') ? 'bg-primary-500/20 text-primary-400' : '' }}">
                            <i class='bx bx-broadcast text-xl'></i>
                            <span>Lives en Direct</span>
                        </a>

                        <a href="{{ route('videos.index') }}"
                           class="flex items-center gap-3 px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('videos.*') ? 'bg-primary-500/20 text-primary-400' : '' }}">
                            <i class='bx bx-video text-xl'></i>
                            <span>Vidéos</span>
                        </a>

                        @if(auth()->user()->isBroadcaster())
                            <div class="pt-4 mt-4 border-t border-gray-700">
                                <p class="text-xs text-gray-400 uppercase tracking-wider mb-3 px-4">Diffuseur</p>

                                <a href="{{ route('broadcaster.streams.create') }}"
                                   class="flex items-center gap-3 px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors">
                                    <i class='bx bx-plus-circle text-xl'></i>
                                    <span>Créer un Live</span>
                                </a>

                                <a href="{{ route('broadcaster.streams') }}"
                                   class="flex items-center gap-3 px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('broadcaster.streams*') ? 'bg-primary-500/20 text-primary-400' : '' }}">
                                    <i class='bx bx-list-ul text-xl'></i>
                                    <span>Mes Lives</span>
                                </a>

                                <a href="{{ route('broadcaster.donations') }}"
                                   class="flex items-center gap-3 px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('broadcaster.donations') ? 'bg-primary-500/20 text-primary-400' : '' }}">
                                    <i class='bx bx-dollar text-xl'></i>
                                    <span>Dons Reçus</span>
                                </a>
                            </div>
                        @else
                            <a href="{{ route('subscriptions.index') }}"
                               class="flex items-center gap-3 px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('subscriptions.*') ? 'bg-primary-500/20 text-primary-400' : '' }}">
                                <i class='bx bx-heart text-xl'></i>
                                <span>Abonnements</span>
                            </a>

                            <a href="{{ route('donations.history') }}"
                               class="flex items-center gap-3 px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('donations.*') ? 'bg-primary-500/20 text-primary-400' : '' }}">
                                <i class='bx bx-history text-xl'></i>
                                <span>Historique des Dons</span>
                            </a>
                        @endif

                        <a href="{{ route('notifications.index') }}"
                           class="flex items-center gap-3 px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors {{ request()->routeIs('notifications.*') ? 'bg-primary-500/20 text-primary-400' : '' }}">
                            <i class='bx bx-bell text-xl'></i>
                            <span>Notifications</span>
                            <span id="notification-badge" class="hidden ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full"></span>
                        </a>
                    </nav>

                    <!-- Logout -->
                    <div class="mt-8 pt-4 border-t border-gray-700">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-3 text-gray-300 rounded-lg hover:bg-red-600/20 hover:text-red-400 transition-colors w-full text-left">
                                <i class='bx bx-log-out text-xl'></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>
        @endauth

        <!-- Main Content -->
        <main class="flex-1 overflow-auto">
            @auth
                <!-- Top Header -->
                <header class="bg-gray-800 border-b border-gray-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold text-white">@yield('page-title', 'Tableau de Bord')</h1>
                            <p class="text-gray-400">@yield('page-subtitle', 'Bon retour parmi nous !')</p>
                        </div>

                        <div class="flex items-center gap-4">
                            <!-- Notifications -->
                            <div class="relative">
                                <button onclick="toggleNotifications()" class="relative p-2 text-gray-400 hover:text-white transition-colors">
                                    <i class='bx bx-bell text-xl'></i>
                                    <span id="notification-dot" class="hidden absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                                </button>
                            </div>

                            <!-- Profile Dropdown -->
                            <div class="relative">
                                <button onclick="toggleProfileMenu()" class="flex items-center gap-2 p-2 text-gray-400 hover:text-white transition-colors">
                                    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                                        @if(auth()->user()->avatar)
                                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full rounded-full object-cover">
                                        @else
                                            <i class='bx bx-user text-white text-sm'></i>
                                        @endif
                                    </div>
                                    <i class='bx bx-chevron-down'></i>
                                </button>

                                <div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-gray-800 border border-gray-700 rounded-lg shadow-lg py-2">
                                    @if(auth()->user()->isBroadcaster())
                                        <a href="{{ route('broadcaster.profile') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">
                                            <i class='bx bx-user mr-2'></i>Profil
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">
                                            <i class='bx bx-log-out mr-2'></i>Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            @endauth

            <!-- Page Content -->
            <div class="p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-500/20 border border-green-500/50 text-green-400 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-500/20 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleNotifications() {
            // Add notification dropdown functionality
            console.log('Toggle notifications');
        }

        function toggleProfileMenu() {
            const menu = document.getElementById('profile-menu');
            menu.classList.toggle('hidden');
        }

        // Close profile menu when clicking outside
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('profile-menu');
            const button = e.target.closest('button[onclick="toggleProfileMenu()"]');

            if (!button && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        // Load notification count
        async function loadNotificationCount() {
            try {
                const response = await fetch('{{ route("notifications.unread-count") }}');
                const data = await response.json();

                const badge = document.getElementById('notification-badge');
                const dot = document.getElementById('notification-dot');

                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('hidden');
                    dot.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                    dot.classList.add('hidden');
                }
            } catch (error) {
                console.error('Error loading notification count:', error);
            }
        }

        @auth
            // Load notification count on page load
            loadNotificationCount();

            // Refresh notification count every 30 seconds
            setInterval(loadNotificationCount, 30000);
        @endauth
    </script>

    @stack('scripts')
</body>
</html>
