@extends('layouts.app')

@section('title', 'Vidéos - Worship Room')
@section('page-title', 'Bibliothèque de Vidéos')
@section('page-subtitle', 'Découvrez notre collection de contenus spirituels')

@section('content')
<div class="space-y-8">
    @if($featuredVideos->count() > 0)
    <!-- Featured Videos Section -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Vidéos en Vedette</h2>
                <p class="text-gray-400">Contenu sélectionné par notre équipe</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($featuredVideos as $video)
                <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow group">
                    <div class="relative">
                        @if($video->thumbnail)
                            <img src="{{ Storage::url($video->thumbnail) }}" alt="{{ $video->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center">
                                <i class='bx bx-play-circle text-white text-4xl'></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                            <i class='bx bx-play-circle text-white text-5xl opacity-0 group-hover:opacity-100 transition-opacity'></i>
                        </div>
                        <div class="absolute bottom-2 right-2 bg-black/50 text-white px-2 py-1 rounded text-sm">
                            {{ $video->formatted_duration }}
                        </div>
                        <div class="absolute top-4 left-4">
                            <span class="bg-accent-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                EN VEDETTE
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-primary-400 transition-colors line-clamp-2">
                            {{ $video->title }}
                        </h3>
                        <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $video->description }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                                    @if($video->broadcaster->avatar)
                                        <img src="{{ Storage::url($video->broadcaster->avatar) }}" alt="{{ $video->broadcaster->name }}" class="w-full h-full rounded-full object-cover">
                                    @else
                                        <i class='bx bx-user text-white text-sm'></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-gray-300 text-sm">{{ $video->broadcaster->name }}</p>
                                    <p class="text-gray-500 text-xs">{{ number_format($video->view_count) }} vues</p>
                                </div>
                            </div>
                            <a href="{{ route('videos.show', $video) }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                                Regarder
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- All Videos Section -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Toutes les Vidéos</h2>
                <p class="text-gray-400">{{ $recentVideos->total() }} vidéo(s) disponible(s)</p>
            </div>
            
            <!-- Filters -->
            <div class="flex items-center gap-4">
                <select class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary-500">
                    <option>Plus Récentes</option>
                    <option>Plus Populaires</option>
                    <option>Plus Anciennes</option>
                    <option>Durée Courte</option>
                    <option>Durée Longue</option>
                </select>
                
                <button class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors">
                    <i class='bx bx-filter mr-2'></i>Filtres
                </button>
            </div>
        </div>
        
        @if($recentVideos->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($recentVideos as $video)
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
                            @if($video->is_featured)
                                <div class="absolute top-2 left-2">
                                    <span class="bg-accent-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                        VEDETTE
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-white mb-2 group-hover:text-primary-400 transition-colors line-clamp-2">
                                {{ $video->title }}
                            </h3>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-6 h-6 bg-primary-500 rounded-full flex items-center justify-center">
                                    @if($video->broadcaster->avatar)
                                        <img src="{{ Storage::url($video->broadcaster->avatar) }}" alt="{{ $video->broadcaster->name }}" class="w-full h-full rounded-full object-cover">
                                    @else
                                        <i class='bx bx-user text-white text-xs'></i>
                                    @endif
                                </div>
                                <span class="text-gray-300 text-xs">{{ $video->broadcaster->name }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs text-gray-400 mb-3">
                                <span>{{ number_format($video->view_count) }} vues</span>
                                <span>{{ $video->published_at->diffForHumans() }}</span>
                            </div>
                            <a href="{{ route('videos.show', $video) }}" class="block bg-primary-500 hover:bg-primary-600 text-white px-3 py-2 rounded text-sm font-semibold transition-colors text-center">
                                Regarder
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $recentVideos->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class='bx bx-video text-gray-400 text-4xl'></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Aucune Vidéo Disponible</h3>
                <p class="text-gray-400 mb-6">Il n'y a pas de vidéos disponibles pour le moment.</p>
                <a href="{{ route('streams.index') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    Voir les Lives
                </a>
            </div>
        @endif
    </section>
</div>
@endsection