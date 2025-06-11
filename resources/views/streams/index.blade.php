@extends('layouts.app')

@section('title', 'Lives en Direct - Worship Room')
@section('page-title', 'Lives en Direct')
@section('page-subtitle', 'Découvrez les sessions de culte en cours et à venir')

@section('content')
<div class="space-y-8">
    @if($liveStreams->count() > 0)
    <!-- Live Streams Section -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">En Direct Maintenant</h2>
                <p class="text-gray-400">{{ $liveStreams->count() }} session(s) active(s)</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
                    <span class="text-red-400 font-semibold">LIVE</span>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
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
                                <div>
                                    <p class="text-gray-300 text-sm">{{ $stream->broadcaster->name }}</p>
                                    <p class="text-gray-500 text-xs">Commencé {{ $stream->started_at->diffForHumans() }}</p>
                                </div>
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
                <h2 class="text-2xl font-bold text-white">Lives Programmés</h2>
                <p class="text-gray-400">{{ $upcomingStreams->count() }} session(s) à venir</p>
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
                        <div class="text-xs text-gray-400 mb-2">
                            <i class='bx bx-calendar mr-1'></i>
                            {{ $stream->scheduled_at->format('j M Y') }}
                        </div>
                        <div class="text-xs text-gray-400 mb-3">
                            <i class='bx bx-time mr-1'></i>
                            {{ $stream->scheduled_at->format('H:i') }}
                        </div>
                        <button class="w-full bg-gray-700 hover:bg-gray-600 text-white px-3 py-2 rounded text-xs font-semibold transition-colors">
                            <i class='bx bx-bell mr-1'></i>Me Rappeler
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if($liveStreams->count() == 0 && $upcomingStreams->count() == 0)
    <!-- Empty State -->
    <div class="text-center py-16">
        <div class="w-24 h-24 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class='bx bx-broadcast text-gray-400 text-4xl'></i>
        </div>
        <h3 class="text-xl font-semibold text-white mb-2">Aucun Live Disponible</h3>
        <p class="text-gray-400 mb-6">Il n'y a pas de sessions de culte en direct pour le moment. Revenez plus tard !</p>
        <a href="{{ route('videos.index') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
            Voir les Vidéos
        </a>
    </div>
    @endif
</div>
@endsection