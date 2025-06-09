@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Cotations des Agents</h1>
            <p class="text-gray-600">Année : {{ $annee }}</p>
        </div>
        
        <!-- Filtre par année -->
        <div>
            <form action="{{ route('cotations.index') }}" method="GET" class="flex space-x-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Année</label>
                    <select name="annee" onchange="this.form.submit()"
                        class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        @for($i = date('Y'); $i >= 2000; $i--)
                            <option value="{{ $i }}" {{ $annee == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Cotations</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En Cours</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ $stats['en_cours'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Validées</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['valides'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Refusées</h3>
            <p class="text-3xl font-bold text-red-600">{{ $stats['refuses'] }}</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="mb-8">
        <a href="{{ route('cotations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Nouvelle Cotation
        </a>
    </div>

    <!-- Liste des cotations -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note Finale</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mention</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($cotations as $cotation)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cotation->agent->nom_complet }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cotation->agent->service->nom }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cotation->note_finale }}/20</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($cotation->note_finale >= 16) bg-green-100 text-green-800
                            @elseif($cotation->note_finale >= 14) bg-blue-100 text-blue-800
                            @elseif($cotation->note_finale >= 12) bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $cotation->getMention() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($cotation->status === 'valide') bg-green-100 text-green-800
                            @elseif($cotation->status === 'refuse') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($cotation->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('cotations.show', $cotation) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            Voir
                        </a>
                        @if($cotation->status === 'en_cours')
                            <a href="{{ route('cotations.edit', $cotation) }}" class="text-green-600 hover:text-green-900">
                                Modifier
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $cotations->links() }}
        </div>
    </div>
</div>
@endsection