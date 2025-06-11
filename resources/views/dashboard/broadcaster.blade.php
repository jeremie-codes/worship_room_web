@extends('layouts.app')

@section('title', 'Tableau de Bord Diffuseur - Worship Room')
@section('page-title', 'Tableau de Bord Diffuseur')
@section('page-subtitle', 'Gérez votre contenu et suivez votre croissance')

@section('content')
<div class="space-y-8">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total des Dons</p>
                    <p class="text-3xl font-bold">${{ number_format($stats['total_donations'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class='bx bx-dollar text-2xl'></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Abonnés</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_subscribers']) }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class='bx bx-heart text-2xl'></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Total Lives</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_streams']) }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class='bx bx-broadcast text-2xl'></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Total Vidéos</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_videos']) }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class='bx bx-video text-2xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gray-800 rounded-xl p-6">
        <h2 class="text-xl font-semibold text-white mb-4">Actions Rapides</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('broadcaster.streams.create') }}" class="bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white p-4 rounded-lg transition-all transform hover:scale-105">
                <div class="flex items-center gap-3">
                    <i class='bx bx-plus-circle text-2xl'></i>
                    <div>
                        <h3 class="font-semibold">Démarrer un Live</h3>
                        <p class="text-sm text-primary-100">Commencer à diffuser immédiatement</p>
                    </div>
                </div>
            </a>

            <a href="#" class="bg-gradient-to-r from-accent-500 to-accent-600 hover:from-accent-600 hover:to-accent-700 text-white p-4 rounded-lg transition-all transform hover:scale-105">
                <div class="flex items-center gap-3">
                    <i class='bx bx-calendar-plus text-2xl'></i>
                    <div>
                        <h3 class="font-semibold">Programmer un Live</h3>
                        <p class="text-sm text-accent-100">Planifier les prochaines sessions</p>
                    </div>
                </div>
            </a>

            <a href="#" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-4 rounded-lg transition-all transform hover:scale-105">
                <div class="flex items-center gap-3">
                    <i class='bx bx-upload text-2xl'></i>
                    <div>
                        <h3 class="font-semibold">Télécharger une Vidéo</h3>
                        <p class="text-sm text-green-100">Partager du contenu enregistré</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Streams -->
        <div class="bg-gray-800 rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-white">Lives Récents</h2>
                <a href="{{ route('broadcaster.streams') }}" class="text-primary-400 hover:text-primary-300 text-sm font-semibold">
                    Voir Tout <i class='bx bx-chevron-right ml-1'></i>
                </a>
            </div>

            @if($recentStreams->count() > 0)
                <div class="space-y-4">
                    @foreach($recentStreams as $stream)
                        <div class="bg-gray-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-white">{{ $stream->title }}</h3>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
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
                            <div class="flex items-center justify-between text-sm text-gray-400">
                                <div class="flex items-center gap-4">
                                    <span><i class='bx bx-user mr-1'></i>{{ number_format($stream->max_viewers) }} spectateurs max</span>
                                    @if($stream->ended_at)
                                        <span><i class='bx bx-time mr-1'></i>{{ $stream->ended_at->diffForHumans() }}</span>
                                    @elseif($stream->scheduled_at)
                                        <span><i class='bx bx-calendar mr-1'></i>{{ $stream->scheduled_at->format('j M Y') }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('streams.show', $stream) }}" class="text-primary-400 hover:text-primary-300">
                                    Voir <i class='bx bx-external-link ml-1'></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class='bx bx-broadcast text-gray-400 text-4xl mb-3'></i>
                    <p class="text-gray-400">Aucun live pour le moment</p>
                    <a href="{{ route('broadcaster.streams.create') }}" class="text-primary-400 hover:text-primary-300 text-sm font-semibold">
                        Créer votre premier live
                    </a>
                </div>
            @endif
        </div>

        <!-- Recent Donations -->
        <div class="bg-gray-800 rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-white">Dons Récents</h2>
                <a href="{{ route('broadcaster.donations') }}" class="text-primary-400 hover:text-primary-300 text-sm font-semibold">
                    Voir Tout <i class='bx bx-chevron-right ml-1'></i>
                </a>
            </div>

            @if($recentDonations->count() > 0)
                <div class="space-y-4">
                    @foreach($recentDonations as $donation)
                        <div class="bg-gray-700/50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <i class='bx bx-dollar text-white text-sm'></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white">
                                            @if($donation->is_anonymous)
                                                Anonyme
                                            @else
                                                {{ $donation->donor->name }}
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-400">{{ $donation->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <span class="text-green-400 font-bold">${{ number_format($donation->amount, 2) }}</span>
                            </div>
                            @if($donation->message)
                                <p class="text-sm text-gray-300 bg-gray-600/50 rounded p-2 mt-2">
                                    "{{ $donation->message }}"
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class='bx bx-dollar text-gray-400 text-4xl mb-3'></i>
                    <p class="text-gray-400">Aucun don pour le moment</p>
                    <p class="text-gray-500 text-sm">Commencez à diffuser pour recevoir du soutien</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Performance Chart Placeholder -->
    <div class="bg-gray-800 rounded-xl p-6">
        <h2 class="text-xl font-semibold text-white mb-4">Aperçu des Performances</h2>
        <div class="bg-gray-700/50 rounded-lg p-8 text-center">
            <i class='bx bx-bar-chart text-gray-400 text-4xl mb-3'></i>
            <p class="text-gray-400">Les graphiques d'analyse seront affichés ici</p>
            <p class="text-gray-500 text-sm">Suivez votre croissance et vos métriques d'engagement</p>
        </div>
    </div>
</div>
@endsection
