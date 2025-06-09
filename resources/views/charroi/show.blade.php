@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Mission : {{ $mission->reference }}</h1>
            <a href="{{ route('charroi.index') }}" class="text-blue-600 hover:text-blue-800">
                &larr; Retour à la liste
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Informations de base -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Informations Générales</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Demandeur</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $mission->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($mission->status === 'en_cours') bg-blue-100 text-blue-800
                                @elseif($mission->status === 'termine') bg-green-100 text-green-800
                                @elseif($mission->status === 'annule') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $mission->status)) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Chauffeur et Véhicule -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Chauffeur et Véhicule</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Chauffeur</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $mission->chauffeur->nom_complet }}
                            <span class="block text-xs text-gray-500">
                                Matricule : {{ $mission->chauffeur->matricule }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Véhicule</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $mission->vehicule->marque }} {{ $mission->vehicule->modele }}
                            <span class="block text-xs text-gray-500">
                                Immatriculation : {{ $mission->vehicule->immatriculation }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Détails de la mission -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Détails de la Mission</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Motif</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $mission->motif }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Itinéraire</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $mission->itineraire }}</dd>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Départ</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $mission->date_heure_depart->format('d/m/Y H:i') }}
                                <span class="block text-xs text-gray-500">
                                    Kilométrage : {{ number_format($mission->kilometrage_depart) }} km
                                </span>
                            </dd>
                        </div>
                        @if($mission->date_heure_retour)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Retour</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $mission->date_heure_retour->format('d/m/Y H:i') }}
                                <span class="block text-xs text-gray-500">
                                    Kilométrage : {{ number_format($mission->kilometrage_retour) }} km
                                </span>
                            </dd>
                        </div>
                        @endif
                    </div>
                </dl>
            </div>

            @if($mission->observations)
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Observations</h2>
                <p class="text-sm text-gray-700">{{ $mission->observations }}</p>
            </div>
            @endif

            <!-- Actions -->
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Actions</h2>
                <div class="flex space-x-4">
                    @if($mission->status === 'en_attente')
                        <form action="{{ route('charroi.approuver', $mission) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                Approuver
                            </button>
                        </form>
                    @endif

                    @if($mission->status === 'approuve')
                        <form action="{{ route('charroi.demarrer', $mission) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Démarrer
                            </button>
                        </form>
                    @endif

                    @if($mission->estTerminable())
                        <button type="button" onclick="document.getElementById('terminer-modal').classList.remove('hidden')"
                            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Terminer
                        </button>
                    @endif

                    @if($mission->estAnnulable())
                        <button type="button" onclick="document.getElementById('annuler-modal').classList.remove('hidden')"
                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                            Annuler
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Terminer -->
    <div id="terminer-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Terminer la mission</h3>
                <form action="{{ route('charroi.terminer', $mission) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Kilométrage au retour</label>
                        <input type="number" name="kilometrage_retour" min="{{ $mission->kilometrage_depart }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Observations</label>
                        <textarea name="observations" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('terminer-modal').classList.add('hidden')"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Terminer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Annuler -->
    <div id="annuler-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Annuler la mission</h3>
                <form action="{{ route('charroi.annuler', $mission) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Motif d'annulation</label>
                        <textarea name="observations" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('annuler-modal').classList.add('hidden')"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                            Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection