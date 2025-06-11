@extends('layouts.app')

@section('title', 'Tableau de Bord Spectateur - Worship Room')
@section('page-title', 'Tableau de Bord')
@section('page-subtitle', 'Bon retour dans votre voyage de culte')

@section('content')
<div class="space-y-8">
    @if($liveStreams->count() > 0)
    <!-- Live Streams Section -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">En Direct Maintenant</h2>
                <p class="text-gray-400">Rejoignez les sessions de culte actives</p>
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
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                            <i class='bx bx-play-circle text-white text-5xl opacity-0 group-hover:opacity-100 transition-opacity'></i>
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
    </section>
    @endif

    @if($upcomingStreams->count() > 0)
    <!-- Upcoming Streams Section -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">À Venir</h2>
                <p class="text-gray-400">Sessions de culte programmées</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($upcomingStreams as $stream)
                <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        @if($stream->cover_image)
                            <img src="{{ Storage::url($stream->cover_image) }}" alt="{{ $stream->title }}" class="w-full h-32 object-cover">
                        @else
                            <div class="w-full h-32 bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center">
                                <i class='bx bx-time text-white text-2xl'></i>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="bg-accent-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                À VENIR
                            </span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-white mb-2 line-clamp-2">{{ $stream->title }}</h3>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 bg-primary-500 rounded-full flex items-center justify-center">
                                @if($stream->broadcaster->avatar)
                                    <img src="{{ Storage::url($stream->broadcaster->avatar) }}" alt="{{ $stream->broadcaster->name }}" class="w-full h-full rounded-full object-cover">
                                @else
                                    <i class='bx bx-user text-white text-xs'></i>
                                @endif
                            </div>
                            <span class="text-gray-300 text-xs">{{ $stream->broadcaster->name }}</span>
                        </div>
                        <div class="text-xs text-gray-400 mb-3">
                            <i class='bx bx-calendar mr-1'></i>
                            {{ $stream->scheduled_at->format('j M Y') }}
                        </div>
                        <div class="text-xs text-gray-400">
                            <i class='bx bx-time mr-1'></i>
                            {{ $stream->scheduled_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if($featuredVideos->count() > 0)
    <!-- Featured Videos Section -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Messages en Vedette</h2>
                <p class="text-gray-400">Contenu inspirant sélectionné avec soin</p>
            </div>
            <a href="{{ route('videos.index') }}" class="text-primary-400 hover:text-primary-300 font-semibold">
                Voir Tout <i class='bx bx-chevron-right ml-1'></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredVideos as $video)
                <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow group">
                    <div class="relative">
                        @if($video->thumbnail)
                            <img src="{{ Storage::url($video->thumbnail) }}" alt="{{ $video->title }}" class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center">
                                <i class='bx bx-play-circle text-white text-3xl'></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                            <i class='bx bx-play-circle text-white text-5xl opacity-0 group-hover:opacity-100 transition-opacity'></i>
                        </div>
                        <div class="absolute bottom-2 right-2 bg-black/50 text-white px-2 py-1 rounded text-xs">
                            {{ $video->formatted_duration }}
                        </div>
                        <div class="absolute top-4 left-4">
                            <span class="bg-accent-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                EN VEDETTE
                            </span>
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
                            Regarder Maintenant
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if($subscribedBroadcasters->count() > 0)
    <!-- Subscribed Broadcasters Section -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Vos Abonnements</h2>
                <p class="text-gray-400">Diffuseurs que vous suivez</p>
            </div>
            <a href="{{ route('subscriptions.index') }}" class="text-primary-400 hover:text-primary-300 font-semibold">
                Voir Tout <i class='bx bx-chevron-right ml-1'></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($subscribedBroadcasters as $broadcaster)
                <div class="bg-gray-800 rounded-xl p-4 text-center hover:bg-gray-700 transition-colors">
                    <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center mx-auto mb-3">
                        @if($broadcaster->avatar)
                            <img src="{{ Storage::url($broadcaster->avatar) }}" alt="{{ $broadcaster->name }}" class="w-full h-full rounded-full object-cover">
                        @else
                            <i class='bx bx-user text-white text-xl'></i>
                        @endif
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-1">{{ $broadcaster->name }}</h3>
                    <p class="text-xs text-gray-400 mb-3">{{ $broadcaster->subscribers_count }} abonnés</p>
                    <div class="flex gap-2">
                        <a href="#" class="flex-1 bg-primary-500 hover:bg-primary-600 text-white px-2 py-1 rounded text-xs font-semibold transition-colors">
                            Voir
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if($recentVideos->count() > 0)
    <!-- Recent Videos Section -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Derniers Ajouts</h2>
                <p class="text-gray-400">Dernier contenu de la communauté</p>
            </div>
            <a href="{{ route('videos.index') }}" class="text-primary-400 hover:text-primary-300 font-semibold">
                Voir Tout <i class='bx bx-chevron-right ml-1'></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($recentVideos->take(6) as $video)
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow group">
                    <div class="relative">
                        @if($video->thumbnail)
                            <img src="{{ Storage::url($video->thumbnail) }}" alt="{{ $video->title }}" class="w-full h-24 object-cover">
                        @else
                            <div class="w-full h-24 bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center">
                                <i class='bx bx-play-circle text-white text-xl'></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                            <i class='bx bx-play-circle text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity'></i>
                        </div>
                        <div class="absolute bottom-1 right-1 bg-black/50 text-white px-1 py-0.5 rounded text-xs">
                            {{ $video->formatted_duration }}
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-xs font-semibold text-white mb-1 group-hover:text-primary-400 transition-colors line-clamp-2">
                            {{ $video->title }}
                        </h3>
                        <div class="text-xs text-gray-400">
                            {{ $video->broadcaster->name }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if($liveStreams->count() == 0 && $upcomingStreams->count() == 0 && $featuredVideos->count() == 0 && $recentVideos->count() == 0)
    <!-- Empty State -->
    <div class="text-center py-16">
        <div class="w-24 h-24 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class='bx bx-video text-gray-400 text-4xl'></i>
        </div>
        <h3 class="text-xl font-semibold text-white mb-2">Aucun Contenu Disponible</h3>
        <p class="text-gray-400 mb-6">Il semble qu'il n'y ait pas de contenu disponible pour le moment. Revenez plus tard !</p>
        <a href="{{ route('streams.index') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
            Parcourir Tout le Contenu
        </a>
    </div>
    @endif
</div>
@endsection
