@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Cotation de {{ $cotation->agent->nom_complet }}</h1>
            <a href="{{ route('cotations.index') }}" class="text-blue-600 hover:text-blue-800">
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
                        <dd class="mt-1 text-sm text-gray-900">{{ $cotation->agent->nom_complet }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Matricule</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $cotation->agent->matricule }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Service</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $cotation->agent->service->nom }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Année</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $cotation->annee }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Évaluateur</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $cotation->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($cotation->status === 'valide') bg-green-100 text-green-800
                                @elseif($cotation->status === 'refuse') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($cotation->status) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Notes -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Notes</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <dt class="text-sm font-medium text-gray-500">Compétence</dt>
                        <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $cotation->note_competence }}/20</dd>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <dt class="text-sm font-medium text-gray-500">Performance</dt>
                        <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $cotation->note_performance }}/20</dd>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <dt class="text-sm font-medium text-gray-500">Comportement</dt>
                        <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $cotation->note_comportement }}/20</dd>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <dt class="text-sm font-medium text-gray-500">Note Finale</dt>
                        <dd class="mt-1">
                            <span class="text-2xl font-semibold text-gray-900">{{ $cotation->note_finale }}/20</span>
                            <span class="block text-sm font-medium
                                @if($cotation->note_finale >= 16) text-green-600
                                @elseif($cotation->note_finale >= 14) text-blue-600
                                @elseif($cotation->note_finale >= 12) text-yellow-600
                                @else text-red-600
                                @endif">
                                {{ $cotation->getMention() }}
                            </span>
                        </dd>
                    </div>
                </div>
            </div>

            <!-- Observations -->
            @if($cotation->observations)
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Observations</h2>
                <p class="text-gray-700">{{ $cotation->observations }}</p>
            </div>
            @endif

            <!-- Commentaire validateur -->
            @if($cotation->commentaire_validateur)
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Commentaire du Validateur</h2>
                <p class="text-gray-700">{{ $cotation->commentaire_validateur }}</p>
            </div>
            @endif

            <!-- Actions -->
            @if($cotation->status === 'en_cours')
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Actions</h2>
                <div class="flex space-x-4">
                    @if(auth()->user()->role === 'validateur')
                        <button type="button" onclick="document.getElementById('validation-modal').classList.remove('hidden')"
                            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Valider
                        </button>
                        <button type="button" onclick="document.getElementById('refus-modal').classList.remove('hidden')"
                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                            Refuser
                        </button>
                    @else
                        <a href="{{ route('cotations.edit', $cotation) }}" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Modifier
                        </a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal Validation -->
    <div id="validation-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Validation de la cotation</h3>
                <form action="{{ route('cotations.valider', $cotation) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Commentaire</label>
                        <textarea name="commentaire_validateur" rows="4" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('validation-modal').classList.add('hidden')"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Valider
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Refus -->
    <div id="refus-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Refus de la cotation</h3>
                <form action="{{ route('cotations.refuser', $cotation) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Motif du refus</label>
                        <textarea name="commentaire_validateur" rows="4" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('refus-modal').classList.add('hidden')"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                            Refuser
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection