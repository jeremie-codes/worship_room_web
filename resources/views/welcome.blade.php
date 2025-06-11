@extends('layouts.app')

@section('title', 'Worship Room - Plateforme de Streaming en Direct')

@section('content')
<div class="min-h-screen bg-gray-900">
    <!-- Hero Section with Background Image -->
    <section class="relative bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 py-20 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="https://images.pexels.com/photos/1190297/pexels-photo-1190297.jpeg?auto=compress&cs=tinysrgb&w=1920&h=1080&fit=crop"
                 alt="Culte et Musique"
                 class="w-full h-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/80 via-gray-800/70 to-gray-900/80"></div>
        </div>

        <!-- Overlay gradients for better text readability -->
        <div class="absolute inset-0 bg-gradient-to-r from-primary-900/30 to-accent-900/30"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-gray-900/50"></div>

        <div class="relative max-w-7xl mx-auto px-6 z-10">
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-r from-primary-500 to-accent-500 rounded-2xl flex items-center justify-center shadow-2xl">
                        <i class='bx bx-video text-white text-4xl'></i>
                    </div>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 text-shadow-lg">
                    Bienvenue sur <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-yellow-500">Worship Room</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-8 max-w-4xl mx-auto leading-relaxed text-shadow">
                    Rejoignez des milliers de croyants dans des expériences de culte en direct. Diffusez, regardez et connectez-vous avec votre communauté de foi depuis n'importe où dans le monde.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @guest
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white px-8 py-4 rounded-lg font-semibold transition-all transform hover:scale-105 shadow-xl">
                            <i class='bx bx-user-plus mr-2'></i>Rejoindre Maintenant
                        </a>
                        <a href="{{ route('login') }}" class="bg-gray-800/80 backdrop-blur-sm hover:bg-gray-700/80 text-white px-8 py-4 rounded-lg font-semibold transition-all border border-gray-600/50 shadow-xl">
                            <i class='bx bx-log-in mr-2'></i>Se Connecter
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white px-8 py-4 rounded-lg font-semibold transition-all transform hover:scale-105 shadow-xl">
                            <i class='bx bx-home mr-2'></i>Aller au Tableau de Bord
                        </a>
                    @endguest
                </div>

                {{-- <!-- Additional decorative elements -->
                <div class="mt-12 flex justify-center space-x-8 text-gray-300">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">1000+</div>
                        <div class="text-sm">Croyants connectés</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">24/7</div>
                        <div class="text-sm">Culte disponible</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">100%</div>
                        <div class="text-sm">Gratuit</div>
                    </div>
                </div> --}}
            </div>
        </div>

        <!-- Floating elements for visual appeal -->
        <div class="absolute top-20 left-10 w-4 h-4 bg-primary-400/30 rounded-full animate-pulse"></div>
        <div class="absolute top-40 right-20 w-6 h-6 bg-accent-400/20 rounded-full animate-pulse delay-1000"></div>
        <div class="absolute bottom-20 left-20 w-3 h-3 bg-primary-300/40 rounded-full animate-pulse delay-500"></div>
    </section>

    @if($liveStreams->count() > 0)
    <!-- Live Streams Section -->
    <section class="py-16 bg-gray-800/50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">En Direct Maintenant</h2>
                    <p class="text-gray-400">Rejoignez ces sessions de culte actives</p>
                </div>
                <a href="{{ route('streams.index') }}" class="text-primary-400 hover:text-primary-300 font-semibold">
                    Voir Tout <i class='bx bx-chevron-right ml-1'></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($liveStreams as $stream)
                    <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow group">
                        <div class="relative">
                            @if($stream->cover_image)
                                <img src="{{ Storage::url($stream->cover_image) }}" alt="{{ $stream->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center">
                                    <i class='bx bx-broadcast text-white text-4xl'></i>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center">
                                    <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                                    EN DIRECT
                                </span>
                            </div>
                            <div class="absolute top-4 right-4 bg-black/50 text-white px-2 py-1 rounded text-sm">
                                {{ number_format($stream->viewer_count) }} spectateurs
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-primary-400 transition-colors">
                                {{ $stream->title }}
                            </h3>
                            <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $stream->description }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                                        @if($stream->broadcaster->avatar)
                                            <img src="{{ Storage::url($stream->broadcaster->avatar) }}" alt="{{ $stream->broadcaster->name }}" class="w-full h-full rounded-full object-cover">
                                        @else
                                            <i class='bx bx-user text-white text-sm'></i>
                                        @endif
                                    </div>
                                    <span class="text-gray-300 text-sm">{{ $stream->broadcaster->name }}</span>
                                </div>
                                <a href="{{ route('streams.show', $stream) }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                                    Regarder
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($featuredVideos->count() > 0)
    <!-- Featured Videos Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">Messages en Vedette</h2>
                    <p class="text-gray-400">Contenu inspirant sélectionné pour vous</p>
                </div>
                <a href="{{ route('videos.index') }}" class="text-primary-400 hover:text-primary-300 font-semibold">
                    Voir Tout <i class='bx bx-chevron-right ml-1'></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredVideos as $video)
                    <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow group">
                        <div class="relative">
                            @if($video->thumbnail)
                                <img src="{{ Storage::url($video->thumbnail) }}" alt="{{ $video->title }}" class="w-full h-32 object-cover">
                            @else
                                <div class="w-full h-32 bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center">
                                    <i class='bx bx-play-circle text-white text-3xl'></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                <i class='bx bx-play-circle text-white text-4xl opacity-0 group-hover:opacity-100 transition-opacity'></i>
                            </div>
                            <div class="absolute bottom-2 right-2 bg-black/50 text-white px-2 py-1 rounded text-xs">
                                {{ $video->formatted_duration }}
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-white mb-2 group-hover:text-primary-400 transition-colors line-clamp-2">
                                {{ $video->title }}
                            </h3>
                            <div class="flex items-center justify-between text-xs text-gray-400">
                                <span>{{ $video->broadcaster->name }}</span>
                                <span>{{ number_format($video->view_count) }} vues</span>
                            </div>
                            <a href="{{ route('videos.show', $video) }}" class="block mt-3 bg-primary-500 hover:bg-primary-600 text-white px-3 py-2 rounded text-sm font-semibold transition-colors text-center">
                                Regarder
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($recentVideos->count() > 0)
    <!-- Recent Videos Section -->
    <section class="py-16 bg-gray-800/30">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">Derniers Ajouts</h2>
                    <p class="text-gray-400">Dernier contenu de culte de notre communauté</p>
                </div>
                <a href="{{ route('videos.index') }}" class="text-primary-400 hover:text-primary-300 font-semibold">
                    Voir Tout <i class='bx bx-chevron-right ml-1'></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recentVideos->take(8) as $video)
                    <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow group">
                        <div class="relative">
                            @if($video->thumbnail)
                                <img src="{{ Storage::url($video->thumbnail) }}" alt="{{ $video->title }}" class="w-full h-32 object-cover">
                            @else
                                <div class="w-full h-32 bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center">
                                    <i class='bx bx-play-circle text-white text-3xl'></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                <i class='bx bx-play-circle text-white text-4xl opacity-0 group-hover:opacity-100 transition-opacity'></i>
                            </div>
                            <div class="absolute bottom-2 right-2 bg-black/50 text-white px-2 py-1 rounded text-xs">
                                {{ $video->formatted_duration }}
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-white mb-2 group-hover:text-primary-400 transition-colors line-clamp-2">
                                {{ $video->title }}
                            </h3>
                            <div class="flex items-center justify-between text-xs text-gray-400 mb-3">
                                <span>{{ $video->broadcaster->name }}</span>
                                <span>{{ number_format($video->view_count) }} vues</span>
                            </div>
                            <a href="{{ route('videos.show', $video) }}" class="block bg-primary-500 hover:bg-primary-600 text-white px-3 py-2 rounded text-sm font-semibold transition-colors text-center">
                                Regarder
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Features Section -->
    <section class="py-16 bg-gray-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-white mb-4">Pourquoi Choisir Worship Room ?</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Découvrez l'avenir du culte numérique avec notre plateforme de pointe conçue pour les croyants du monde entier.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class='bx bx-broadcast text-white text-2xl'></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Streaming en Direct</h3>
                    <p class="text-gray-400">Diffusez des services de culte de haute qualité et connectez-vous avec votre congrégation en temps réel.</p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class='bx bx-heart text-white text-2xl'></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Soutien Communautaire</h3>
                    <p class="text-gray-400">Soutenez vos diffuseurs préférés par des dons et créez des connexions durables.</p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class='bx bx-video text-white text-2xl'></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Contenu à la Demande</h3>
                    <p class="text-gray-400">Accédez à une vaste bibliothèque de sermons enregistrés et de contenu de culte à tout moment, n'importe où.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    @guest
    <section class="py-16 bg-gradient-to-r from-primary-900 to-accent-900 relative overflow-hidden">
        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.pexels.com/photos/1190297/pexels-photo-1190297.jpeg?auto=compress&cs=tinysrgb&w=1920&h=1080&fit=crop"
                 alt="Communauté de culte"
                 class="w-full h-full object-cover">
        </div>
        <div class="relative max-w-4xl mx-auto text-center px-6">
            <h2 class="text-3xl font-bold text-white mb-4">Prêt à Commencer Votre Voyage de Culte ?</h2>
            <p class="text-primary-100 mb-8 text-lg">Rejoignez des milliers de croyants qui ont fait de Worship Room leur sanctuaire numérique.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-primary-900 px-8 py-4 rounded-lg font-bold hover:bg-gray-100 transition-colors shadow-xl">
                    <i class='bx bx-user-plus mr-2'></i>Créer un Compte Gratuit
                </a>
                <a href="{{ route('streams.index') }}" class="bg-primary-700/80 backdrop-blur-sm hover:bg-primary-600 text-white px-8 py-4 rounded-lg font-semibold transition-colors border border-primary-500/50 shadow-xl">
                    <i class='bx bx-play mr-2'></i>Parcourir le Contenu
                </a>
            </div>
        </div>
    </section>
    @endguest
</div>

<style>
.text-shadow {
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.text-shadow-lg {
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
