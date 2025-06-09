@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Véhicules</h1>
        </div>
        <a href="{{ route('charroi.vehicules.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Nouveau Véhicule
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Bon état</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['bon_etat'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En panne</h3>
            <p class="text-3xl font-bold text-red-600">{{ $stats['en_panne'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En entretien</h3>
            <p class="text-3xl font-bold text-orange-600">{{ $stats['en_entretien'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">À déclasser</h3>
            <p class="text-3xl font-bold text-gray-600">{{ $stats['a_declasser'] }}</p>
        </div>
    </div>

    <!-- Liste des véhicules -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Immatriculation</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marque</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modèle</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Année</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">État</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($vehicules as $vehicule)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vehicule->immatriculation }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vehicule->marque }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vehicule->modele }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vehicule->annee }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($vehicule->etat === 'bon_etat') bg-green-100 text-green-800
                            @elseif($vehicule->etat === 'en_panne') bg-red-100 text-red-800
                            @elseif($vehicule->etat === 'en_entretien') bg-orange-100 text-orange-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $vehicule->etat)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('charroi.vehicules.edit', $vehicule) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            Modifier
                        </a>
                        @if(!$vehicule->missions()->exists())
                            <form action="{{ route('charroi.vehicules.destroy', $vehicule) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')">
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
            {{ $vehicules->links() }}
        </div>
    </div>
</div>
@endsection