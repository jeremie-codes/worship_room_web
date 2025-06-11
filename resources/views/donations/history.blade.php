@extends('layouts.app')

@section('title', 'Historique des Dons - Worship Room')
@section('page-title', 'Historique des Dons')
@section('page-subtitle', 'Vos contributions à la communauté')

@section('content')
<div class="space-y-8">
    @if($donations->count() > 0)
        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">Total des Dons</p>
                        <p class="text-3xl font-bold">${{ number_format($donations->sum('amount'), 2) }}</p>
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
                        <p class="text-3xl font-bold">{{ $donations->count() }}</p>
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
                        <p class="text-3xl font-bold">${{ number_format($donations->avg('amount'), 2) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class='bx bx-trending-up text-2xl'></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donations List -->
        <div class="bg-gray-800 rounded-xl overflow-hidden">
            <div class="p-6 border-b border-gray-700">
                <h2 class="text-xl font-semibold text-white">Historique Détaillé</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Bénéficiaire
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Montant
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Méthode
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($donations as $donation)
                            <tr class="hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center mr-3">
                                            @if($donation->broadcaster->avatar)
                                                <img src="{{ Storage::url($donation->broadcaster->avatar) }}" alt="{{ $donation->broadcaster->name }}" class="w-full h-full rounded-full object-cover">
                                            @else
                                                <i class='bx bx-user text-white'></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-white">{{ $donation->broadcaster->name }}</div>
                                            @if($donation->stream)
                                                <div class="text-sm text-gray-400">{{ $donation->stream->title }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-green-400">${{ number_format($donation->amount, 2) }}</div>
                                    <div class="text-sm text-gray-400">{{ strtoupper($donation->currency) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($donation->payment_method === 'card')
                                            <i class='bx bx-credit-card text-gray-400 mr-2'></i>
                                            <span class="text-sm text-gray-300">Carte</span>
                                        @else
                                            <i class='bx bx-mobile text-gray-400 mr-2'></i>
                                            <span class="text-sm text-gray-300">Mobile Money</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-300">{{ $donation->created_at->format('j M Y') }}</div>
                                    <div class="text-sm text-gray-400">{{ $donation->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($donation->status === 'completed') bg-green-100 text-green-800
                                        @elseif($donation->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($donation->status === 'failed') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        @if($donation->status === 'completed') Complété
                                        @elseif($donation->status === 'pending') En Attente
                                        @elseif($donation->status === 'failed') Échoué
                                        @else {{ ucfirst($donation->status) }} @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-primary-400 hover:text-primary-300 mr-3" onclick="showDonationDetails({{ $donation->id }})">
                                        <i class='bx bx-show mr-1'></i>Détails
                                    </button>
                                    @if($donation->status === 'completed')
                                        <button class="text-gray-400 hover:text-gray-300">
                                            <i class='bx bx-download mr-1'></i>Reçu
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
            <h3 class="text-xl font-semibold text-white mb-2">Aucun Don Effectué</h3>
            <p class="text-gray-400 mb-6">Vous n'avez pas encore fait de don. Soutenez vos diffuseurs préférés !</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('streams.index') }}" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    <i class='bx bx-broadcast mr-2'></i>Voir les Lives
                </a>
                <a href="{{ route('videos.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    <i class='bx bx-video mr-2'></i>Parcourir les Vidéos
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Donation Details Modal -->
<div id="donation-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-gray-800 rounded-xl p-6 max-w-md w-full mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white">Détails du Don</h3>
            <button onclick="closeDonationModal()" class="text-gray-400 hover:text-white">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>
        <div id="donation-details-content">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showDonationDetails(donationId) {
        // This would typically fetch donation details via AJAX
        document.getElementById('donation-modal').classList.remove('hidden');
        
        // Placeholder content
        document.getElementById('donation-details-content').innerHTML = `
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-400">ID de Transaction:</span>
                    <span class="text-white">DON-${donationId}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Référence:</span>
                    <span class="text-white">PAY_${Math.random().toString(36).substr(2, 9).toUpperCase()}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Statut:</span>
                    <span class="text-green-400">Complété</span>
                </div>
                <div class="pt-4 border-t border-gray-700">
                    <button class="w-full bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class='bx bx-download mr-2'></i>Télécharger le Reçu
                    </button>
                </div>
            </div>
        `;
    }

    function closeDonationModal() {
        document.getElementById('donation-modal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('donation-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDonationModal();
        }
    });
</script>
@endpush
@endsection