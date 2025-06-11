@extends('layouts.app')

@section('title', 'Dons Reçus - Worship Room')
@section('page-title', 'Dons Reçus')
@section('page-subtitle', 'Gérez les dons de votre communauté')

@section('content')
<div class="space-y-8">
    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total des Dons</p>
                    <p class="text-3xl font-bold">${{ number_format($totalDonations, 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class='bx bx-dollar text-2xl'></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Nombre de Dons</p>
                    <p class="text-3xl font-bold">{{ $donations->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class='bx bx-heart text-2xl'></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Don Moyen</p>
                    <p class="text-3xl font-bold">${{ $donations->count() > 0 ? number_format($totalDonations / $donations->count(), 2) : '0.00' }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class='bx bx-trending-up text-2xl'></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Ce Mois</p>
                    <p class="text-3xl font-bold">${{ number_format($donations->where('created_at', '>=', now()->startOfMonth())->sum('amount'), 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <i class='bx bx-calendar text-2xl'></i>
                </div>
            </div>
        </div>
    </div>

    @if($donations->count() > 0)
        <!-- Donations List -->
        <div class="bg-gray-800 rounded-xl overflow-hidden">
            <div class="p-6 border-b border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-white">Historique des Dons</h2>
                    <div class="flex items-center gap-4">
                        <select class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary-500">
                            <option>Tous les dons</option>
                            <option>Cette semaine</option>
                            <option>Ce mois</option>
                            <option>Cette année</option>
                        </select>
                        <button class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-semibold transition-colors">
                            <i class='bx bx-download mr-2'></i>Exporter
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="divide-y divide-gray-700">
                @foreach($donations as $donation)
                    <div class="p-6 hover:bg-gray-700/30 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class='bx bx-dollar text-white text-xl'></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="text-white font-semibold">
                                            @if($donation->is_anonymous)
                                                Donateur Anonyme
                                            @else
                                                {{ $donation->donor->name }}
                                            @endif
                                        </h3>
                                        <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded text-xs font-semibold">
                                            {{ strtoupper($donation->status) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm text-gray-400">
                                        <span><i class='bx bx-time mr-1'></i>{{ $donation->created_at->diffForHumans() }}</span>
                                        @if($donation->stream)
                                            <span><i class='bx bx-broadcast mr-1'></i>{{ $donation->stream->title }}</span>
                                        @endif
                                        <span>
                                            @if($donation->payment_method === 'card')
                                                <i class='bx bx-credit-card mr-1'></i>Carte
                                            @else
                                                <i class='bx bx-mobile mr-1'></i>Mobile Money
                                            @endif
                                        </span>
                                    </div>
                                    @if($donation->message)
                                        <div class="mt-2 p-3 bg-gray-700/50 rounded-lg">
                                            <p class="text-gray-300 text-sm italic">"{{ $donation->message }}"</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <div class="text-2xl font-bold text-green-400 mb-1">
                                    ${{ number_format($donation->amount, 2) }}
                                </div>
                                <div class="text-sm text-gray-400">
                                    {{ strtoupper($donation->currency) }}
                                </div>
                                @if($donation->payment_reference)
                                    <div class="text-xs text-gray-500 mt-1">
                                        Réf: {{ $donation->payment_reference }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-2 mt-4">
                            @if(!$donation->is_anonymous)
                                <button class="px-3 py-1 bg-primary-500 hover:bg-primary-600 text-white rounded text-sm font-semibold transition-colors">
                                    <i class='bx bx-message mr-1'></i>Remercier
                                </button>
                            @endif
                            <button class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-white rounded text-sm font-semibold transition-colors">
                                <i class='bx bx-show mr-1'></i>Détails
                            </button>
                            <button class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-white rounded text-sm font-semibold transition-colors">
                                <i class='bx bx-download mr-1'></i>Reçu
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $donations->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class='bx bx-heart text-gray-400 text-4xl'></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">Aucun Don Reçu</h3>
            <p class="text-gray-400 mb-6">Vous n'avez pas encore reçu de don. Continuez à créer du contenu inspirant pour votre communauté !</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('broadcaster.streams.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    <i class='bx bx-broadcast mr-2'></i>Créer un Live
                </a>
                <a href="{{ route('dashboard') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    <i class='bx bx-home mr-2'></i>Tableau de Bord
                </a>
            </div>
        </div>
    @endif
</div>
@endsection