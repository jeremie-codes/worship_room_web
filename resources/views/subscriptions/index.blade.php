@extends('layouts.app')

@section('title', 'Mes Abonnements - Worship Room')
@section('page-title', 'Mes Abonnements')
@section('page-subtitle', 'Diffuseurs que vous suivez')

@section('content')
<div class="space-y-8">
    @if($subscriptions->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($subscriptions as $subscription)
                @php $broadcaster = $subscription->broadcaster; @endphp
                <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-700 transition-colors">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-primary-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            @if($broadcaster->avatar)
                                <img src="{{ Storage::url($broadcaster->avatar) }}" alt="{{ $broadcaster->name }}" class="w-full h-full rounded-full object-cover">
                            @else
                                <i class='bx bx-user text-white text-2xl'></i>
                            @endif
                        </div>
                        
                        <h3 class="text-lg font-semibold text-white mb-2">{{ $broadcaster->name }}</h3>
                        
                        <div class="text-sm text-gray-400 mb-4">
                            <p>{{ number_format($broadcaster->subscribers_count) }} abonnés</p>
                            <p>Abonné depuis {{ $subscription->subscribed_at->diffForHumans() }}</p>
                        </div>
                        
                        @if($broadcaster->bio)
                            <p class="text-gray-300 text-sm mb-4 line-clamp-3">{{ $broadcaster->bio }}</p>
                        @endif
                        
                        <div class="flex gap-2">
                            <a href="#" class="flex-1 bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                                <i class='bx bx-user mr-2'></i>Voir le Profil
                            </a>
                            <button onclick="toggleSubscription({{ $broadcaster->id }}, this)" 
                                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-semibold transition-colors subscribed">
                                <i class='bx bx-x mr-2'></i>Se Désabonner
                            </button>
                        </div>
                        
                        <!-- Recent Activity -->
                        <div class="mt-4 pt-4 border-t border-gray-700">
                            <h4 class="text-sm font-semibold text-white mb-2">Activité Récente</h4>
                            @php
                                $recentStream = $broadcaster->streams()->latest()->first();
                                $recentVideo = $broadcaster->videos()->published()->latest()->first();
                            @endphp
                            
                            @if($recentStream)
                                <div class="text-xs text-gray-400 mb-1">
                                    <i class='bx bx-broadcast mr-1'></i>
                                    @if($recentStream->isLive())
                                        <span class="text-red-400">En direct maintenant</span>
                                    @elseif($recentStream->isScheduled())
                                        Live programmé {{ $recentStream->scheduled_at->diffForHumans() }}
                                    @else
                                        Dernier live {{ $recentStream->ended_at->diffForHumans() }}
                                    @endif
                                </div>
                            @endif
                            
                            @if($recentVideo)
                                <div class="text-xs text-gray-400">
                                    <i class='bx bx-video mr-1'></i>
                                    Nouvelle vidéo {{ $recentVideo->published_at->diffForHumans() }}
                                </div>
                            @endif
                            
                            @if(!$recentStream && !$recentVideo)
                                <p class="text-xs text-gray-500">Aucune activité récente</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $subscriptions->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class='bx bx-heart text-gray-400 text-4xl'></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Aucun Abonnement</h3>
            <p class="text-gray-400 mb-6">Vous ne suivez aucun diffuseur pour le moment. Découvrez du contenu inspirant !</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('streams.index') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    <i class='bx bx-broadcast mr-2'></i>Découvrir les Lives
                </a>
                <a href="{{ route('videos.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    <i class='bx bx-video mr-2'></i>Parcourir les Vidéos
                </a>
            </div>
        </div>
    @endif
</div>
@endsection