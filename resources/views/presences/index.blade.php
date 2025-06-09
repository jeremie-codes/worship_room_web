@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Présences</h1>
            <p class="text-gray-600">{{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
        </div>

        <!-- Filtres -->
        <div class="flex space-x-4">
            <form action="{{ route('presences.index') }}" method="GET" class="flex space-x-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="date" value="{{ $date }}"
                        class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Direction</label>
                    <select name="service_id"
                        class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                        <option value="">Toutes les directions</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $service_id == $service->id ? 'selected' : '' }}>
                                {{ $service->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques globales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 card-gradient-blue text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Effectif Total</h3>
                    <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
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
                    <h3 class="text-lg font-semibold">Présents</h3>
                    <p class="text-3xl font-bold">{{ $stats['presents'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 card-gradient-orange text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Retards</h3>
                    <p class="text-3xl font-bold">{{ $stats['retards'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 card-gradient-red text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Absents</h3>
                    <p class="text-3xl font-bold">{{ $stats['absents'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques par direction -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Résumé par Direction</h2>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Direction</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Effectif</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Présents</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Retards</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Absents</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($statsByService as $stat)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $stat['nom'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $stat['total'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-green-600">{{ $stat['presents'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-orange-600">{{ $stat['retards'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-red-600">{{ $stat['absents'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recherche -->
    <div class="mb-8">
        <form action="{{ route('presences.search') }}" method="GET" class="flex space-x-4">
            <div class="flex-1">
                <input type="text" name="q" placeholder="Rechercher un utilisateur..."
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Rechercher
            </button>
        </form>
    </div>

    <!-- Formulaire d'enregistrement -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Enregistrer une présence</h2>
        <form action="{{ route('presences.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Utilisateur</label>
                    <select name="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                        <option value="present">Présent</option>
                        <option value="retard">Retard</option>
                        <option value="justifie">Justifié</option>
                        <option value="autorise">Absence autorisée</option>
                        <option value="absent">Absent</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Heure d'arrivée</label>
                    <input type="time" name="heure_arrivee" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Justification</label>
                <textarea name="justification" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>

    <!-- Liste des présences -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Direction</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heure d'arrivée</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Justification</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($presences as $presence)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $presence->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $presence->user->service->nom }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($presence->status === 'present') bg-green-100 text-green-800
                            @elseif($presence->status === 'retard') bg-orange-100 text-orange-800
                            @elseif($presence->status === 'absent') bg-red-100 text-red-800
                            @else bg-blue-100 text-blue-800
                            @endif">
                            {{ ucfirst($presence->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $presence->heure_arrivee ? $presence->heure_arrivee->format('H:i') : '-' }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $presence->justification ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
