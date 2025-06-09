@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Demande de Fournitures</h1>
            <a href="{{ route('demandes.index') }}" class="text-blue-600 hover:text-blue-800">
                &larr; Retour à la liste
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Informations de base -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Informations Générales</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Service</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $demande->service->nom }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Demandeur</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $demande->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Article</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $demande->article->nom }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Quantité</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $demande->quantite }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Niveau d'urgence</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($demande->niveau_urgence === 'tres_urgent') bg-red-100 text-red-800
                                @elseif($demande->niveau_urgence === 'urgent') bg-orange-100 text-orange-800
                                @else bg-blue-100 text-blue-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $demande->niveau_urgence)) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($demande->status === 'approuve') bg-green-100 text-green-800
                                @elseif($demande->status === 'refuse') bg-red-100 text-red-800
                                @elseif($demande->status === 'livre') bg-gray-100 text-gray-800
                                @else bg-blue-100 text-blue-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $demande->status)) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Motif -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Motif</h2>
                <p class="text-gray-700">{{ $demande->motif }}</p>
            </div>

            <!-- Commentaire validateur -->
            @if($demande->commentaire_validateur)
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Commentaire du Validateur</h2>
                <p class="text-gray-700">{{ $demande->commentaire_validateur }}</p>
            </div>
            @endif

            <!-- Actions -->
            @if($demande->status === 'en_attente')
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Actions</h2>
                <div class="flex space-x-4">
                    <button type="button" onclick="document.getElementById('approuver-modal').classList.remove('hidden')"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Approuver
                    </button>
                    <button type="button" onclick="document.getElementById('refuser-modal').classList.remove('hidden')"
                        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                        Refuser
                    </button>
                </div>
            </div>
            @endif

            @if($demande->estLivrable())
            <div class="p-6 border-t">
                <form action="{{ route('demandes.livrer', $demande) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Marquer comme livrée
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal Approbation -->
    <div id="approuver-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Approuver la demande</h3>
                <form action="{{ route('demandes.approuver', $demande) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Commentaire</label>
                        <textarea name="commentaire_validateur" rows="4" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('approuver-modal').classList.add('hidden')"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounde
d-md hover:bg-green-700">
                            Approuver
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Refus -->
    <div id="refuser-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Refuser la demande</h3>
                <form action="{{ route('demandes.refuser', $demande) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Motif du refus</label>
                        <textarea name="commentaire_validateur" rows="4" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('refuser-modal').classList.add('hidden')"
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