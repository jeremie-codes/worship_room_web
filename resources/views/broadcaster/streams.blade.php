@extends('layouts.app')

@section('title', 'Mes Lives - Worship Room')
@section('page-title', 'Mes Lives')
@section('page-subtitle', 'Gérez vos diffusions en direct')

@section('content')
<div class="space-y-8">
    <!-- Header Actions -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-400">{{ $streams->total() }} live(s) au total</p>
        </div>
        <a href="{{ route('broadcaster.streams.create') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
            <i class='bx bx-plus mr-2'></i>Nouveau Live
        </a>
    </div>

    @if($streams->count() > 0)
        <!-- Streams Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($streams as $stream)
                <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                    <div class="relative">
                        @if($stream->cover_image)
                            <img src="{{ Storage::url($stream->cover_image) }}" alt="{{ $stream->title }}" class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center">
                                <i class='bx bx-broadcast text-white text-3xl'></i>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if($stream->status === 'live') bg-red-500 text-white
                                @elseif($stream->status === 'scheduled') bg-accent-500 text-white
                                @elseif($stream->status === 'ended') bg-green-500 text-white
                                @else bg-gray-500 text-white @endif">
                                @if($stream->status === 'live') EN DIRECT
                                @elseif($stream->status === 'scheduled') PROGRAMMÉ
                                @elseif($stream->status === 'ended') TERMINÉ
                                @else {{ strtoupper($stream->status) }} @endif
                            </span>
                        </div>
                        
                        @if($stream->status === 'live')
                            <div class="absolute top-4 right-4 bg-black/50 text-white px-2 py-1 rounded text-sm">
                                {{ number_format($stream->viewer_count) }} spectateurs
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-white mb-2 line-clamp-2">{{ $stream->title }}</h3>
                        
                        @if($stream->description)
                            <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $stream->description }}</p>
                        @endif
                        
                        <!-- Stream Stats -->
                        <div class="flex items-center gap-4 text-sm text-gray-400 mb-4">
                            @if($stream->max_viewers > 0)
                                <span><i class='bx bx-user mr-1'></i>{{ number_format($stream->max_viewers) }} max</span>
                            @endif
                            @if($stream->likes->count() > 0)
                                <span><i class='bx bx-heart mr-1'></i>{{ $stream->likes->count() }}</span>
                            @endif
                            @if($stream->comments->count() > 0)
                                <span><i class='bx bx-message mr-1'></i>{{ $stream->comments->count() }}</span>
                            @endif
                        </div>
                        
                        <!-- Date Info -->
                        <div class="text-sm text-gray-400 mb-4">
                            @if($stream->status === 'live')
                                <i class='bx bx-time mr-1'></i>Commencé {{ $stream->started_at->diffForHumans() }}
                            @elseif($stream->status === 'scheduled')
                                <i class='bx bx-calendar mr-1'></i>Prévu le {{ $stream->scheduled_at->format('j M Y à H:i') }}
                            @elseif($stream->status === 'ended')
                                <i class='bx bx-check mr-1'></i>Terminé {{ $stream->ended_at->diffForHumans() }}
                            @endif
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('streams.show', $stream) }}" 
                               class="flex-1 bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors text-center">
                                <i class='bx bx-show mr-2'></i>Voir
                            </a>
                            
                            @if($stream->status === 'scheduled')
                                <button class="px-4 py-2 bg-accent-500 hover:bg-accent-600 text-white rounded-lg text-sm font-semibold transition-colors">
                                    <i class='bx bx-edit mr-2'></i>Modifier
                                </button>
                            @elseif($stream->status === 'live')
                                <button class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-semibold transition-colors">
                                    <i class='bx bx-stop mr-2'></i>Arrêter
                                </button>
                            @endif
                            
                            <div class="relative">
                                <button onclick="toggleStreamMenu({{ $stream->id }})" class="p-2 text-gray-400 hover:text-white transition-colors">
                                    <i class='bx bx-dots-vertical-rounded'></i>
                                </button>
                                <div id="stream-menu-{{ $stream->id }}" class="hidden absolute right-0 mt-2 w-48 bg-gray-700 border border-gray-600 rounded-lg shadow-lg py-2 z-10">
                                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-600 hover:text-white">
                                        <i class='bx bx-edit mr-2'></i>Modifier
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-600 hover:text-white">
                                        <i class='bx bx-copy mr-2'></i>Dupliquer
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-600 hover:text-white">
                                        <i class='bx bx-bar-chart mr-2'></i>Statistiques
                                    </a>
                                    <hr class="border-gray-600 my-2">
                                    <a href="#" class="block px-4 py-2 text-red-400 hover:bg-gray-600">
                                        <i class='bx bx-trash mr-2'></i>Supprimer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $streams->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class='bx bx-broadcast text-gray-400 text-4xl'></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Aucun Live Créé</h3>
            <p class="text-gray-400 mb-6">Commencez à partager votre message avec votre communauté en créant votre premier live.</p>
            <a href="{{ route('broadcaster.streams.create') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white px-8 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                <i class='bx bx-plus mr-2'></i>Créer Mon Premier Live
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function toggleStreamMenu(streamId) {
        const menu = document.getElementById(`stream-menu-${streamId}`);
        
        // Close all other menus
        document.querySelectorAll('[id^="stream-menu-"]').forEach(m => {
            if (m.id !== `stream-menu-${streamId}`) {
                m.classList.add('hidden');
            }
        });
        
        menu.classList.toggle('hidden');
    }

    // Close menus when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('[onclick*="toggleStreamMenu"]') && !e.target.closest('[id^="stream-menu-"]')) {
            document.querySelectorAll('[id^="stream-menu-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });
</script>
@endpush
@endsection