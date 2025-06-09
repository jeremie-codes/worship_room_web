@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Chauffeurs</h1>
        </div>
        <a href="{{ route('charroi.chauffeurs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Nouveau Chauffeur
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Disponibles</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['disponibles'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En mission</h3>
            <p class="text-3xl font-bold text-orange-600">{{ $stats['en_mission'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Indisponibles</h3>
            <p class="text-3xl font-bold text-red-600">{{ $stats['indisponibles'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Permis expirés</h3>
            <p class="text-3xl font-bold text-gray-600">{{ $stats['permis_expires'] }}</p>
        </div>
    </div>

    <!-- Liste des chauffeurs -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matricule</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom Complet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Permis</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expiration Permis</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($chauffeurs as $chauffeur)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $chauffeur->matricule }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $chauffeur->nom_complet }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $chauffeur->telephone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $chauffeur->numero_permis }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="@if(!$chauffeur->permisEstValide()) text-red-600 font-semibold @endif">
                            {{ $chauffeur->date_expiration_permis->format('d/m/Y') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($chauffeur->status === 'disponible') bg-green-100 text-green-800
                            @elseif($chauffeur->status === 'en_mission') bg-orange-100 text-orange-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $chauffeur->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('charroi.chauffeurs.edit', $chauffeur) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            Modifier
                        </a>
                        @if(!$chauffeur->missions()->exists())
                            <form action="{{ route('charroi.chauffeurs.destroy', $chauffeur) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce chauffeur ?')">
                                    Supprimer
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $chauffeurs->links() }}
        </div>
    </div>
</div>
@endsection