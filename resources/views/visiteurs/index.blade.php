@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Visiteurs</h1>
            <p class="text-gray-600">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('visiteurs.rapport') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                Rapport
            </a>
            <a href="{{ route('visiteurs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Nouveau Visiteur
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 card-gradient-blue text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Total Jour</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_jour'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 card-gradient-green text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">En Visite</h3>
                    <p class="text-3xl font-bold">{{ $stats['en_visite'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 card-gradient-orange text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4zm-8-2a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Entrepreneurs</h3>
                    <p class="text-3xl font-bold">{{ $stats['entrepreneurs'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 card-gradient-purple text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Visiteurs</h3>
                    <p class="text-3xl font-bold">{{ $stats['visiteurs'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 card-gradient-teal text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4zm-8-2a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Avec Véhicule</h3>
                    <p class="text-3xl font-bold">{{ $stats['avec_vehicule'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Visiteurs actuellement en visite -->
    @if($visiteursEnCours->count() > 0)
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Visiteurs Actuellement en Visite ({{ $visiteursEnCours->count() }})</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($visiteursEnCours as $visiteur)
            <div class="border rounded-lg p-4 bg-green-50">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $visiteur->nom_complet }}</h3>
                        <p class="text-sm text-gray-600">{{ ucfirst($visiteur->type) }}</p>
                        @if($visiteur->entreprise)
                            <p class="text-sm text-gray-600">{{ $visiteur->entreprise }}</p>
                        @endif
                        <p class="text-sm text-gray-600">{{ $visiteur->service?->nom ?? 'Non spécifié' }}</p>
                        <p class="text-xs text-gray-500">Arrivé à {{ $visiteur->heure_arrivee->format('H:i') }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('visiteurs.show', $visiteur) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                            Voir
                        </a>
                        <form action="{{ route('visiteurs.marquer-sortie', $visiteur) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                Sortie
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form action="{{ route('visiteurs.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="date" value="{{ $date }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Type</label>
                <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                    <option value="">Tous</option>
                    <option value="entrepreneur" {{ $type === 'entrepreneur' ? 'selected' : '' }}>Entrepreneur</option>
                    <option value="visiteur" {{ $type === 'visiteur' ? 'selected' : '' }}>Visiteur</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Service</label>
                <select name="service_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                    <option value="">Tous</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ $service_id == $service->id ? 'selected' : '' }}>
                            {{ $service->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Statut</label>
                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                    <option value="">Tous</option>
                    <option value="en_visite" {{ $status === 'en_visite' ? 'selected' : '' }}>En visite</option>
                    <option value="parti" {{ $status === 'parti' ? 'selected' : '' }}>Parti</option>
                    <option value="refuse" {{ $status === 'refuse' ? 'selected' : '' }}>Refusé</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full">
                    Filtrer
                </button>
            </div>
        </form>
    </div>

    <!-- Recherche -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form action="{{ route('visiteurs.recherche') }}" method="GET" class="flex space-x-4">
            <div class="flex-1">
                <input type="text" name="q" placeholder="Rechercher par nom, entreprise, téléphone, badge..."
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
            </div>
            <div>
                <input type="date" name="date_debut" placeholder="Date début"
                    class="block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
            </div>
            <div>
                <input type="date" name="date_fin" placeholder="Date fin"
                    class="block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Rechercher
            </button>
        </form>
    </div>

    <!-- Liste des visiteurs -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Badge</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visiteur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motif</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destination</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Arrivée</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Départ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($visiteurs as $visiteur)
                <tr class="{{ $visiteur->estEnVisite() ? 'bg-green-50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-mono text-gray-900">{{ $visiteur->badge_numero }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $visiteur->nom_complet }}</div>
                        @if($visiteur->entreprise)
                            <div class="text-sm text-gray-500">{{ $visiteur->entreprise }}</div>
                        @endif
                        @if($visiteur->telephone)
                            <div class="text-sm text-gray-500">{{ $visiteur->telephone }}</div>
                        @endif
                        @if($visiteur->vehicule)
                            <div class="text-xs text-blue-600">🚗 {{ $visiteur->immatriculation_vehicule }}</div>
                        @endif
                        @if($visiteur->nombre_accompagnants > 0)
                            <div class="text-xs text-gray-500">+{{ $visiteur->nombre_accompagnants }} accompagnant(s)</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($visiteur->type === 'entrepreneur') bg-orange-100 text-orange-800
                            @else bg-purple-100 text-purple-800
                            @endif">
                            {{ ucfirst($visiteur->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ Str::limit($visiteur->motif, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $visiteur->service?->nom ?? 'Non spécifié' }}</div>
                        @if($visiteur->destination)
                            <div class="text-sm text-gray-500">{{ $visiteur->destination }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $visiteur->heure_arrivee->format('H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($visiteur->heure_depart)
                            {{ $visiteur->heure_depart->format('H:i') }}
                            <div class="text-xs text-gray-500">{{ $visiteur->duree_visite }}</div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($visiteur->status === 'en_visite') bg-green-100 text-green-800
                            @elseif($visiteur->status === 'parti') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $visiteur->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('visiteurs.show', $visiteur) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            Voir
                        </a>
                        @if($visiteur->estEnVisite())
                            <form action="{{ route('visiteurs.marquer-sortie', $visiteur) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900 mr-3">
                                    Sortie
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('visiteurs.edit', $visiteur) }}" class="text-green-600 hover:text-green-900">
                            Modifier
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $visiteurs->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
