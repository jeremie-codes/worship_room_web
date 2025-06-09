@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Mission : {{ $mission->reference }}</h1>
            <a href="{{ route('missions.index') }}" class="text-blue-600 hover:text-blue-800">
                &larr; Retour à la liste
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Informations de base -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Informations Générales</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Agent</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $mission->agent->nom_complet }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Matricule</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $mission->agent->matricule }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Service</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $mission->agent->service->nom }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Lieu</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $mission->lieu }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Période</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            Du {{ $mission->date_debut->format('d/m/Y') }}
                            au {{ $mission->date_fin->format('d/m/Y') }}
                            ({{ $mission->duree }} jours)
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Frais de mission</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ number_format($mission->frais_mission, 2, ',', ' ') }} FCFA</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($mission->status === 'en_cours') bg-green-100 text-green-800
                                @elseif($mission->status === 'terminee') bg-blue-100 text-blue-800
                                @elseif($mission->status === 'annulee') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $mission->status)) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Objet -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Objet de la Mission</h2>
                <p class="text-gray-700">{{ $mission->objet }}</p>
            </div>

            <!-- Observations -->
            @if($mission->observations)
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Observations</h2>
                <p class="text-gray-700">{{ $mission->observations }}</p>
            </div>
            @endif

            <!-- Rapport -->
            @if($mission->rapport)
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Rapport de Mission</h2>
                <p class="text-gray-700">{{ $mission->rapport }}</p>
            </div>
            @endif

            <!-- Actions -->
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Actions</h2>
                <div class="flex space-x-4">
                    @if($mission->status === 'en_preparation')
                        <form action="{{ route('missions.demarrer', $mission) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                Démarrer la mission
                            </button>
                        </form>
                    @endif

                    @if($mission->status === 'en_cours')
                        <button type="button" onclick="document.getElementById('rapport-modal').classList.remove('hidden')"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Terminer la mission
                        </button>
                    @endif

                    @if(in_array($mission->status, ['en_preparation', 'en_cours']))
                        <button type="button" onclick="document.getElementById('annulation-modal').classList.remove('hidden')"
                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                            Annuler la mission
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Rapport -->
    <div id="rapport-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Rapport de mission</h3>
                <form action="{{ route('missions.terminer', $mission) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Rapport</label>
                        <textarea name="rapport" rows="4" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('rapport-modal').classList.add('hidden')"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Terminer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Annulation -->
    <div id="annulation-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Annulation de la mission</h3>
                <form action="{{ route('missions.annuler', $mission) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Motif d'annulation</label>
                        <textarea name="motif_annulation" rows="4" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('annulation-modal').classList.add('hidden')"
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