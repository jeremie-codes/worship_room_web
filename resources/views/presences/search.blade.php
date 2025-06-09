@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Résultats de recherche</h1>
        <p class="text-gray-600">Recherche : "{{ $query }}" - Date : {{ Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
    </div>

    <!-- Résultats de recherche -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
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

    <div class="mt-4">
        <a href="{{ route('presences.index') }}" class="text-blue-600 hover:text-blue-800">
            &larr; Retour à la liste des présences
        </a>
    </div>
</div>
@endsection