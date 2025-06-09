@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion du Charroi Automobile</h1>
        </div>
        <a href="{{ route('charroi.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Nouvelle Mission
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Véhicules</h3>
            <div class="mt-2 grid grid-cols-2 gap-2">
                <div>
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['vehicules_total'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Disponibles</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['vehicules_disponibles'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Chauffeurs</h3>
            <div class="mt-2 grid grid-cols-2 gap-2">
                <div>
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['chauffeurs_total'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Disponibles</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['chauffeurs_disponibles'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Missions</h3>
            <div class="mt-2 grid grid-cols-2 gap-2">
                <div>
                    <p class="text-sm text-gray-500">En cours</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $stats['missions_en_cours'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Terminées</p>
                    <p class="text-2xl font-bold text-gray-600">{{ $stats['missions_terminees'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des missions -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Demandeur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Chauffeur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Véhicule</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Départ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($missions as $mission)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $mission->reference }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $mission->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $mission->chauffeur->nom_complet }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $mission->vehicule->marque }} {{ $mission->vehicule->modele }}
                        ({{ $mission->vehicule->immatriculation }})
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $mission->date_heure_depart->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($mission->status === 'en_cours') bg-blue-100 text-blue-800
                            @elseif($mission->status === 'termine') bg-green-100 text-green-800
                            @elseif($mission->status === 'annule') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $mission->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('charroi.show', $mission) }}" class="text-blue-600 hover:text-blue-900">
                            Voir détails
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $missions->links() }}
        </div>
    </div>
</div>
@endsection