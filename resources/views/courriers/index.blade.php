@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Courriers</h1>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('courriers.tableau_bord') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                Tableau de Bord
            </a>
            <a href="{{ route('courriers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Nouveau Courrier
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En Attente</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ $stats['en_attente'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En Cours</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['en_cours'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Traités</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['traites'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En Retard</h3>
            <p class="text-3xl font-bold text-red-600">{{ $stats['en_retard'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Urgents</h3>
            <p class="text-3xl font-bold text-orange-600">{{ $stats['urgents'] }}</p>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form action="{{ route('courriers.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Type</label>
                <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    <option value="">Tous</option>
                    <option value="entrant" {{ $type === 'entrant' ? 'selected' : '' }}>Entrant</option>
                    <option value="sortant" {{ $type === 'sortant' ? 'selected' : '' }}>Sortant</option>
                    <option value="interne" {{ $type === 'interne' ? 'selected' : '' }}>Interne</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Statut</label>
                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    <option value="">Tous</option>
                    <option value="en_attente" {{ $status === 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="en_cours_traitement" {{ $status === 'en_cours_traitement' ? 'selected' : '' }}>En cours</option>
                    <option value="traite" {{ $status === 'traite' ? 'selected' : '' }}>Traité</option>
                    <option value="archive" {{ $status === 'archive' ? 'selected' : '' }}>Archivé</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Priorité</label>
                <select name="priorite" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    <option value="">Toutes</option>
                    <option value="normale" {{ $priorite === 'normale' ? 'selected' : '' }}>Normale</option>
                    <option value="urgente" {{ $priorite === 'urgente' ? 'selected' : '' }}>Urgente</option>
                    <option value="tres_urgente" {{ $priorite === 'tres_urgente' ? 'selected' : '' }}>Très urgente</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Service</label>
                <select name="service_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    <option value="">Tous</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ $service_id == $service->id ? 'selected' : '' }}>
                            {{ $service->nom }}
                        </option>
                    @endforeach
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
        <form action="{{ route('courriers.recherche') }}" method="GET" class="flex space-x-4">
            <div class="flex-1">
                <input type="text" name="q" placeholder="Rechercher par référence, objet, expéditeur..." 
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            </div>
            <div>
                <input type="date" name="date_debut" placeholder="Date début"
                    class="block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            </div>
            <div>
                <input type="date" name="date_fin" placeholder="Date fin"
                    class="block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Rechercher
            </button>
        </form>
    </div>

    <!-- Liste des courriers -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Objet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expéditeur/Destinataire</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priorité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($courriers as $courrier)
                <tr class="{{ $courrier->estEnRetard() ? 'bg-red-50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            {{ $courrier->reference }}
                            @if($courrier->confidentiel)
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Confidentiel
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($courrier->type === 'entrant') bg-blue-100 text-blue-800
                            @elseif($courrier->type === 'sortant') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($courrier->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ Str::limit($courrier->objet, 50) }}</div>
                        <div class="text-sm text-gray-500">{{ ucfirst($courrier->motif) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($courrier->type === 'entrant')
                            <div class="text-sm text-gray-900">{{ $courrier->expediteur ?? $courrier->serviceExpediteur?->nom }}</div>
                        @else
                            <div class="text-sm text-gray-900">{{ $courrier->destinataire ?? $courrier->serviceDestinataire?->nom }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $courrier->date_courrier->format('d/m/Y') }}
                        @if($courrier->date_limite_reponse)
                            <div class="text-xs {{ $courrier->estEnRetard() ? 'text-red-600' : 'text-gray-500' }}">
                                Limite: {{ $courrier->date_limite_reponse->format('d/m/Y') }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($courrier->priorite === 'tres_urgente') bg-red-100 text-red-800
                            @elseif($courrier->priorite === 'urgente') bg-orange-100 text-orange-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $courrier->priorite)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($courrier->status === 'traite') bg-green-100 text-green-800
                            @elseif($courrier->status === 'en_cours_traitement') bg-blue-100 text-blue-800
                            @elseif($courrier->status === 'archive') bg-gray-100 text-gray-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $courrier->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('courriers.show', $courrier) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            Voir
                        </a>
                        <a href="{{ route('courriers.edit', $courrier) }}" class="text-green-600 hover:text-green-900">
                            Modifier
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $courriers->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection