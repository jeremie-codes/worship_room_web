@extends('layouts.app')

@section('title', $stream->title . ' - Worship Room')
@section('page-title', $stream->title)
@section('page-subtitle', 'Par ' . $stream->broadcaster->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Video Player -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Video Player -->
        <div class="bg-gray-800 rounded-xl overflow-hidden">
            <div class="relative aspect-video bg-black">
                @if($stream->isLive())
                    <!-- Live Video Player Placeholder -->
                    <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-primary-500 to-accent-500">
                        <div class="text-center text-white">
                            <i class='bx bx-broadcast text-6xl mb-4'></i>
                            <h3 class="text-2xl font-bold mb-2">Live en Direct</h3>
                            <p class="text-primary-100">Le lecteur vidéo sera intégré ici</p>
                        </div>
                    </div>
                    <div class="absolute top-4 left-4">
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center">
                            <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                            EN DIRECT
                        </span>
                    </div>
                    <div class="absolute top-4 right-4 bg-black/50 text-white px-3 py-1 rounded">
                        <span class="viewer-count">{{ number_format($stream->viewer_count) }}</span> spectateurs
                    </div>
                @else
                    <div class="absolute inset-0 flex items-center justify-center bg-gray-700">
                        <div class="text-center text-gray-400">
                            <i class='bx bx-time text-4xl mb-4'></i>
                            <h3 class="text-xl font-semibold mb-2">
                                @if($stream->isScheduled())
                                    Live Programmé
                                @else
                                    Live Terminé
                                @endif
                            </h3>
                            @if($stream->scheduled_at)
                                <p>Prévu le {{ $stream->scheduled_at->format('j M Y à H:i') }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stream Info -->
        <div class="bg-gray-800 rounded-xl p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-white mb-2">{{ $stream->title }}</h1>
                    <div class="flex items-center gap-4 text-sm text-gray-400 mb-4">
                        <span><i class='bx bx-user mr-1'></i>{{ number_format($stream->max_viewers) }} spectateurs max</span>
                        <span><i class='bx bx-heart mr-1'></i>{{ $stream->likes->count() }} j'aime</span>
                        @if($stream->started_at)
                            <span><i class='bx bx-time mr-1'></i>{{ $stream->started_at->diffForHumans() }}</span>
                        @endif
                    </div>
                </div>
                
                @auth
                <div class="flex items-center gap-3">
                    <button onclick="toggleLike('streams', {{ $stream->id }}, this)" 
                            class="flex items-center gap-2 px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors {{ $userHasLiked ? 'text-red-500' : 'text-gray-300' }}">
                        <i class='bx {{ $userHasLiked ? 'bxs-heart' : 'bx-heart' }} text-lg'></i>
                        <span class="like-count">{{ $stream->likes->count() }}</span>
                    </button>
                    
                    @if(auth()->user()->id !== $stream->broadcaster_id)
                        <button onclick="toggleSubscription({{ $stream->broadcaster_id }}, this)" 
                                class="px-4 py-2 rounded-lg font-semibold transition-colors {{ $userIsSubscribed ? 'bg-green-500 hover:bg-green-600 subscribed' : 'bg-primary-500 hover:bg-primary-600' }} text-white">
                            @if($userIsSubscribed)
                                <i class="bx bx-check mr-2"></i>Abonné
                            @else
                                <i class="bx bx-plus mr-2"></i>S'abonner
                            @endif
                        </button>
                        
                        <a href="{{ route('donations.create', ['broadcaster_id' => $stream->broadcaster_id, 'stream_id' => $stream->id]) }}" 
                           class="px-4 py-2 bg-accent-500 hover:bg-accent-600 text-white rounded-lg font-semibold transition-colors">
                            <i class='bx bx-dollar mr-2'></i>Faire un Don
                        </a>
                    @endif
                </div>
                @endauth
            </div>
            
            @if($stream->description)
                <div class="text-gray-300">
                    <h3 class="font-semibold mb-2">Description</h3>
                    <p class="leading-relaxed">{{ $stream->description }}</p>
                </div>
            @endif
        </div>

        <!-- Broadcaster Info -->
        <div class="bg-gray-800 rounded-xl p-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center">
                    @if($stream->broadcaster->avatar)
                        <img src="{{ Storage::url($stream->broadcaster->avatar) }}" alt="{{ $stream->broadcaster->name }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <i class='bx bx-user text-white text-2xl'></i>
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-white">{{ $stream->broadcaster->name }}</h3>
                    <p class="text-gray-400 text-sm">
                        <span class="subscriber-count">{{ number_format($stream->broadcaster->subscribers_count) }}</span> abonnés
                    </p>
                    @if($stream->broadcaster->bio)
                        <p class="text-gray-300 text-sm mt-2">{{ $stream->broadcaster->bio }}</p>
                    @endif
                </div>
                @auth
                    @if(auth()->user()->id !== $stream->broadcaster_id)
                        <button onclick="toggleSubscription({{ $stream->broadcaster_id }}, this)" 
                                class="px-6 py-2 rounded-lg font-semibold transition-colors {{ $userIsSubscribed ? 'bg-green-500 hover:bg-green-600 subscribed' : 'bg-primary-500 hover:bg-primary-600' }} text-white">
                            @if($userIsSubscribed)
                                <i class="bx bx-check mr-2"></i>Abonné
                            @else
                                <i class="bx bx-plus mr-2"></i>S'abonner
                            @endif
                        </button>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Live Chat -->
        @if($stream->isLive())
        <div class="bg-gray-800 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Chat en Direct</h3>
            
            <!-- Chat Messages -->
            <div class="h-64 bg-gray-700/50 rounded-lg p-4 mb-4 overflow-y-auto comments-list">
                @foreach($stream->comments->take(10) as $comment)
                    @include('partials.comment', ['comment' => $comment])
                @endforeach
            </div>
            
            <!-- Chat Input -->
            @auth
                <form onsubmit="return submitComment('streams', {{ $stream->id }}, this)" class="flex gap-2">
                    @csrf
                    <input type="text" name="content" placeholder="Tapez votre message..." 
                           class="flex-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                    <button type="submit" class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors">
                        <i class='bx bx-send'></i>
                    </button>
                </form>
            @else
                <p class="text-gray-400 text-center py-4">
                    <a href="{{ route('login') }}" class="text-primary-400 hover:text-primary-300">Connectez-vous</a> pour participer au chat
                </p>
            @endauth
        </div>
        @endif

        <!-- Related Streams -->
        @if($relatedStreams->count() > 0)
        <div class="bg-gray-800 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Autres Lives de {{ $stream->broadcaster->name }}</h3>
            <div class="space-y-4">
                @foreach($relatedStreams as $relatedStream)
                    <div class="flex gap-3">
                        <div class="w-20 h-12 bg-gray-700 rounded flex items-center justify-center flex-shrink-0">
                            @if($relatedStream->cover_image)
                                <img src="{{ Storage::url($relatedStream->cover_image) }}" alt="{{ $relatedStream->title }}" class="w-full h-full object-cover rounded">
                            @else
                                <i class='bx bx-broadcast text-gray-400'></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-white line-clamp-2 mb-1">{{ $relatedStream->title }}</h4>
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($relatedStream->status === 'live') bg-red-500 text-white
                                    @elseif($relatedStream->status === 'scheduled') bg-accent-500 text-white
                                    @else bg-gray-600 text-gray-300 @endif">
                                    @if($relatedStream->status === 'live') LIVE
                                    @elseif($relatedStream->status === 'scheduled') PROGRAMMÉ
                                    @else TERMINÉ @endif
                                </span>
                                @if($relatedStream->max_viewers > 0)
                                    <span>{{ number_format($relatedStream->max_viewers) }} vues</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@if($stream->isLive())
    @push('scripts')
    <script>
        // Start viewer count refresh for live streams
        startViewerCountRefresh({{ $stream->id }});
    </script>
    @endpush
@endif
@endsection