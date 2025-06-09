@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Demande de Congé</h1>
            <a href="{{ route('conges.index') }}" class="text-blue-600 hover:text-blue-800">
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
                        <dd class="mt-1 text-sm text-gray-900">{{ $conge->agent->nom_complet }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Matricule</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $conge->agent->matricule }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Service</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $conge->agent->service->nom }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Ancienneté</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $conge->agent->anciennete }} ans</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Période</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            Du {{ $conge->date_debut->format('d/m/Y') }}
                            au {{ $conge->date_fin->format('d/m/Y') }}
                            ({{ $conge->duree }} jours)
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($conge->status === 'valide_drh') bg-green-100 text-green-800
                                @elseif($conge->status === 'refuse') bg-red-100 text-red-800
                                @else bg-blue-100 text-blue-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $conge->status)) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Motif -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Motif</h2>
                <p class="text-gray-700">{{ $conge->motif }}</p>
            </div>

            <!-- Workflow -->
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Workflow d'Approbation</h2>
                
                <!-- Approbation Directeur -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">1. Approbation Directeur</h3>
                    @if($conge->status === 'en_attente' && auth()->user()->role === 'directeur')
                        <form action="{{ route('conges.approuver.directeur', $conge) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Commentaire</label>
                                <textarea name="commentaire_directeur" rows="2" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                            </div>
                            <div class="flex space-x-3">
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                    Approuver
                                </button>
                                <button type="button" onclick="document.getElementById('refuser-form').submit()"
                                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                    Refuser
                                </button>
                            </div>
                        </form>
                    @elseif($conge->status !== 'en_attente')
                        <div class="bg-gray-50 rounded-md p-4">
                            <p class="text-sm text-gray-700">
                                <span class="font-medium">Commentaire :</span>
                                {{ $conge->commentaire_directeur ?? 'Aucun commentaire' }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Traitement RH -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">2. Traitement RH</h3>
                    @if($conge->status === 'approuve_directeur' && auth()->user()->role === 'rh')
                        <form action="{{ route('conges.traiter.rh', $conge) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Commentaire</label>
                                <textarea name="commentaire_rh" rows="2" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                            </div>
                            <div class="flex space-x-3">
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                    Valider le traitement
                                </button>
                                <button type="button" onclick="document.getElementById('refuser-form').submit()"
                                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                    Refuser
                                </button>
                            </div>
                        </form>
                    @elseif($conge->status !== 'approuve_directeur' && $conge->commentaire_rh)
                        <div class="bg-gray-50 rounded-md p-4">
                            <p class="text-sm text-gray-700">
                                <span class="font-medium">Commentaire :</span>
                                {{ $conge->commentaire_rh }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Validation DRH -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">3. Validation DRH</h3>
                    @if($conge->status === 'traite_rh' && auth()->user()->role === 'drh')
                        <form action="{{ route('conges.valider.drh', $conge) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Commentaire</label>
                                <textarea name="commentaire_drh" rows="2" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                            </div>
                            <div class="flex space-x-3">
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                    Valider définitivement
                                </button>
                                <button type="button" onclick="document.getElementById('refuser-form').submit()"
                                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                    Refuser
                                </button>
                            </div>
                        </form>
                    @elseif($conge->status !== 'traite_rh' && $conge->commentaire_drh)
                        <div class="bg-gray-50 rounded-md p-4">
                            <p class="text-sm text-gray-700">
                                <span class="font-medium">Commentaire :</span>
                                {{ $conge->commentaire_drh }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Formulaire de refus caché -->
        <form id="refuser-form" action="{{ route('conges.refuser', $conge) }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="commentaire" value="Demande refusée">
        </form>
    </div>
</div>
@endsection