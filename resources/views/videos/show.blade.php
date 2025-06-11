@extends('layouts.app')

@section('title', $video->title . ' - Worship Room')
@section('page-title', $video->title)
@section('page-subtitle', 'Par ' . $video->broadcaster->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Video Player -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Video Player -->
        <div class="bg-gray-800 rounded-xl overflow-hidden">
            <div class="relative aspect-video bg-black">
                <!-- Video Player Placeholder -->
                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-gray-700 to-gray-600">
                    <div class="text-center text-white">
                        <i class='bx bx-play-circle text-6xl mb-4'></i>
                        <h3 class="text-2xl font-bold mb-2">Lecteur Vidéo</h3>
                        <p class="text-gray-300">Le lecteur vidéo sera intégré ici</p>
                        <p class="text-gray-400 text-sm mt-2">Durée: {{ $video->formatted_duration }}</p>
                    </div>
                </div>
                @if($video->thumbnail)
                    <img src="{{ Storage::url($video->thumbnail) }}" alt="{{ $video->title }}" class="absolute inset-0 w-full h-full object-cover opacity-30">
                @endif
            </div>
        </div>

        <!-- Video Info -->
        <div class="bg-gray-800 rounded-xl p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-white mb-2">{{ $video->title }}</h1>
                    <div class="flex items-center gap-4 text-sm text-gray-400 mb-4">
                        <span><i class='bx bx-play mr-1'></i>{{ number_format($video->view_count) }} vues</span>
                        <span><i class='bx bx-heart mr-1'></i>{{ $video->likes->count() }} j'aime</span>
                        <span><i class='bx bx-time mr-1'></i>{{ $video->published_at->diffForHumans() }}</span>
                        <span><i class='bx bx-clock mr-1'></i>{{ $video->formatted_duration }}</span>
                    </div>
                </div>
                
                @auth
                <div class="flex items-center gap-3">
                    <button onclick="toggleLike('videos', {{ $video->id }}, this)" 
                            class="flex items-center gap-2 px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors {{ $userHasLiked ? 'text-red-500' : 'text-gray-300' }}">
                        <i class='bx {{ $userHasLiked ? 'bxs-heart' : 'bx-heart' }} text-lg'></i>
                        <span class="like-count">{{ $video->likes->count() }}</span>
                    </button>
                    
                    @if(auth()->user()->id !== $video->broadcaster_id)
                        <button onclick="toggleSubscription({{ $video->broadcaster_id }}, this)" 
                                class="px-4 py-2 rounded-lg font-semibold transition-colors {{ $userIsSubscribed ? 'bg-green-500 hover:bg-green-600 subscribed' : 'bg-primary-500 hover:bg-primary-600' }} text-white">
                            @if($userIsSubscribed)
                                <i class="bx bx-check mr-2"></i>Abonné
                            @else
                                <i class="bx bx-plus mr-2"></i>S'abonner
                            @endif
                        </button>
                        
                        <a href="{{ route('donations.create', ['broadcaster_id' => $video->broadcaster_id]) }}" 
                           class="px-4 py-2 bg-accent-500 hover:bg-accent-600 text-white rounded-lg font-semibold transition-colors">
                            <i class='bx bx-dollar mr-2'></i>Faire un Don
                        </a>
                    @endif
                    
                    <button class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                        <i class='bx bx-share mr-2'></i>Partager
                    </button>
                </div>
                @endauth
            </div>
            
            @if($video->description)
                <div class="text-gray-300">
                    <h3 class="font-semibold mb-2">Description</h3>
                    <div class="bg-gray-700/50 rounded-lg p-4">
                        <p class="leading-relaxed">{{ $video->description }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Broadcaster Info -->
        <div class="bg-gray-800 rounded-xl p-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center">
                    @if($video->broadcaster->avatar)
                        <img src="{{ Storage::url($video->broadcaster->avatar) }}" alt="{{ $video->broadcaster->name }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <i class='bx bx-user text-white text-2xl'></i>
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-white">{{ $video->broadcaster->name }}</h3>
                    <p class="text-gray-400 text-sm">
                        <span class="subscriber-count">{{ number_format($video->broadcaster->subscribers_count) }}</span> abonnés
                    </p>
                    @if($video->broadcaster->bio)
                        <p class="text-gray-300 text-sm mt-2">{{ $video->broadcaster->bio }}</p>
                    @endif
                </div>
                @auth
                    @if(auth()->user()->id !== $video->broadcaster_id)
                        <button onclick="toggleSubscription({{ $video->broadcaster_id }}, this)" 
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

        <!-- Comments Section -->
        <div class="bg-gray-800 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">
                Commentaires ({{ $video->comments->count() }})
            </h3>
            
            <!-- Add Comment -->
            @auth
                <form onsubmit="return submitComment('videos', {{ $video->id }}, this)" class="mb-6">
                    @csrf
                    <div class="flex gap-3">
                        <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center flex-shrink-0">
                            @if(auth()->user()->avatar)
                                <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Votre avatar" class="w-full h-full rounded-full object-cover">
                            @else
                                <i class='bx bx-user text-white'></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <textarea name="content" placeholder="Ajoutez un commentaire..." 
                                      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent resize-none" 
                                      rows="3" required></textarea>
                            <div class="flex justify-end mt-2">
                                <button type="submit" class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-semibold transition-colors">
                                    <i class='bx bx-send mr-2'></i>Publier
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <div class="text-center py-6 border border-gray-700 rounded-lg mb-6">
                    <p class="text-gray-400 mb-3">Connectez-vous pour laisser un commentaire</p>
                    <a href="{{ route('login') }}" class="text-primary-400 hover:text-primary-300 font-semibold">
                        Se Connecter
                    </a>
                </div>
            @endauth
            
            <!-- Comments List -->
            <div class="space-y-4 comments-list">
                @forelse($video->comments as $comment)
                    @include('partials.comment', ['comment' => $comment])
                @empty
                    <div class="text-center py-8">
                        <i class='bx bx-message text-gray-400 text-3xl mb-3'></i>
                        <p class="text-gray-400">Aucun commentaire pour le moment</p>
                        <p class="text-gray-500 text-sm">Soyez le premier à commenter cette vidéo</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Related Videos -->
        @if($relatedVideos->count() > 0)
        <div class="bg-gray-800 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Autres Vidéos de {{ $video->broadcaster->name }}</h3>
            <div class="space-y-4">
                @foreach($relatedVideos as $relatedVideo)
                    <div class="flex gap-3 group cursor-pointer" onclick="window.location.href='{{ route('videos.show', $relatedVideo) }}'">
                        <div class="w-24 h-16 bg-gray-700 rounded flex items-center justify-center flex-shrink-0 relative overflow-hidden">
                            @if($relatedVideo->thumbnail)
                                <img src="{{ Storage::url($relatedVideo->thumbnail) }}" alt="{{ $relatedVideo->title }}" class="w-full h-full object-cover">
                            @else
                                <i class='bx bx-play-circle text-gray-400'></i>
                            @endif
                            <div class="absolute bottom-1 right-1 bg-black/50 text-white px-1 py-0.5 rounded text-xs">
                                {{ $relatedVideo->formatted_duration }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-white line-clamp-2 mb-1 group-hover:text-primary-400 transition-colors">{{ $relatedVideo->title }}</h4>
                            <div class="text-xs text-gray-400 space-y-1">
                                <p>{{ number_format($relatedVideo->view_count) }} vues</p>
                                <p>{{ $relatedVideo->published_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Video Stats -->
        <div class="bg-gray-800 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Statistiques</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Vues</span>
                    <span class="text-white font-semibold">{{ number_format($video->view_count) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">J'aime</span>
                    <span class="text-white font-semibold">{{ $video->likes->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Commentaires</span>
                    <span class="text-white font-semibold">{{ $video->comments->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Publié</span>
                    <span class="text-white font-semibold">{{ $video->published_at->format('j M Y') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-400">Durée</span>
                    <span class="text-white font-semibold">{{ $video->formatted_duration }}</span>
                </div>
            </div>
        </div>

        <!-- Share Video -->
        <div class="bg-gray-800 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Partager cette Vidéo</h3>
            <div class="space-y-3">
                <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors text-left">
                    <i class='bx bxl-facebook text-blue-500 text-xl'></i>
                    <span class="text-white">Partager sur Facebook</span>
                </button>
                <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors text-left">
                    <i class='bx bxl-twitter text-blue-400 text-xl'></i>
                    <span class="text-white">Partager sur Twitter</span>
                </button>
                <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors text-left">
                    <i class='bx bxl-whatsapp text-green-500 text-xl'></i>
                    <span class="text-white">Partager sur WhatsApp</span>
                </button>
                <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors text-left">
                    <i class='bx bx-link text-gray-400 text-xl'></i>
                    <span class="text-white">Copier le Lien</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection