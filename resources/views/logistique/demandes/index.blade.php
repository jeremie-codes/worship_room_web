@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Demandes de Fournitures</h1>
        </div>
        <a href="{{ route('demandes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Nouvelle Demande
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En Attente</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['en_attente'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Approuvées</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['approuvees'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Refusées</h3>
            <p class="text-3xl font-bold text-red-600">{{ $stats['refusees'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Livrées</h3>
            <p class="text-3xl font-bold text-gray-600">{{ $stats['livrees'] }}</p>
        </div>
    </div>

    <!-- Liste des demandes -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Demandeur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urgence</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($demandes as $demande)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $demande->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $demande->service->nom }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $demande->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $demande->article->nom }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $demande->quantite }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($demande->niveau_urgence === 'tres_urgent') bg-red-100 text-red-800
                            @elseif($demande->niveau_urgence === 'urgent') bg-orange-100 text-orange-800
                            @else bg-blue-100 text-blue-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $demande->niveau_urgence)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($demande->status === 'approuve') bg-green-100 text-green-800
                            @elseif($demande->status === 'refuse') bg-red-100 text-red-800
                            @elseif($demande->status === 'livre') bg-gray-100 text-gray-800
                            @else bg-blue-100 text-blue-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $demande->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('demandes.show', $demande) }}" class="text-blue-600 hover:text-blue-900">
                            Voir détails
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $demandes->links() }}
        </div>
    </div>
</div>
@endsection