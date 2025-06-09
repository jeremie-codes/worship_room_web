@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Missions</h1>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En préparation</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['en_preparation'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En cours</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['en_cours'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Terminées</h3>
            <p class="text-3xl font-bold text-orange-600">{{ $stats['terminees'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Annulées</h3>
            <p class="text-3xl font-bold text-red-600">{{ $stats['annulees'] }}</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="mb-8">
        <a href="{{ route('missions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Nouvelle Mission
        </a>
    </div>

    <!-- Liste des missions -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lieu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($missions as $mission)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $mission->reference }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $mission->agent->nom_complet }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $mission->lieu }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Du {{ $mission->date_debut->format('d/m/Y') }}
                        au {{ $mission->date_fin->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($mission->status === 'en_cours') bg-green-100 text-green-800
                            @elseif($mission->status === 'terminee') bg-blue-100 text-blue-800
                            @elseif($mission->status === 'annulee') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $mission->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('missions.show', $mission) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            Voir
                        </a>
                        @if($mission->status === 'en_preparation')
                            <a href="{{ route('missions.edit', $mission) }}" class="text-green-600 hover:text-green-900">
                                Modifier
                            </a>
                        @endif
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