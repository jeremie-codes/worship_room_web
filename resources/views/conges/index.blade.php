@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Congés</h1>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En cours</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['en_cours'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Validés</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['valides'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Agents Éligibles</h3>
            <p class="text-3xl font-bold text-orange-600">{{ $stats['eligibles'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Non Éligibles</h3>
            <p class="text-3xl font-bold text-red-600">{{ $stats['non_eligibles'] }}</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="mb-8">
        <a href="{{ route('conges.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Nouvelle Demande
        </a>
    </div>

    <!-- Liste des congés -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durée</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($conges as $conge)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $conge->agent->nom_complet }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Du {{ $conge->date_debut->format('d/m/Y') }}
                        au {{ $conge->date_fin->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $conge->duree }} jours</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($conge->status === 'valide_drh') bg-green-100 text-green-800
                            @elseif($conge->status === 'refuse') bg-red-100 text-red-800
                            @else bg-blue-100 text-blue-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $conge->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('conges.show', $conge) }}" class="text-blue-600 hover:text-blue-900">
                            Voir détails
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $conges->links() }}
        </div>
    </div>
</div>
@endsection