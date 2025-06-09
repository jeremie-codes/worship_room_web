@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Courrier : {{ $courrier->reference }}</h1>
            <div class="flex space-x-3">
                <a href="{{ route('courriers.index') }}" class="text-blue-600 hover:text-blue-800">
                    &larr; Retour à la liste
                </a>
                <a href="{{ route('courriers.edit', $courrier) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Modifier
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informations principales -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- En-tête -->
                    <div class="p-6 border-b">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">{{ $courrier->objet }}</h2>
                                <div class="mt-2 flex space-x-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($courrier->type === 'entrant') bg-blue-100 text-blue-800
                                        @elseif($courrier->type === 'sortant') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($courrier->type) }}
                                    </span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($courrier->priorite === 'tres_urgente') bg-red-100 text-red-800
                                        @elseif($courrier->priorite === 'urgente') bg-orange-100 text-orange-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $courrier->priorite)) }}
                                    </span>
                                    @if($courrier->confidentiel)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Confidentiel
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($courrier->status === 'traite') bg-green-100 text-green-800
                                    @elseif($courrier->status === 'en_cours_traitement') bg-blue-100 text-blue-800
                                    @elseif($courrier->status === 'archive') bg-gray-100 text-gray-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $courrier->status)) }}
                                </span>
                                @if($courrier->estEnRetard())
                                    <div class="mt-1 text-xs text-red-600 font-semibold">EN RETARD</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Détails -->
                    <div class="p-6 border-b">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Motif</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($courrier->motif) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date du Courrier</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $courrier->date_courrier->format('d/m/Y') }}</dd>
                            </div>
                            @if($courrier->expediteur || $courrier->serviceExpediteur)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Expéditeur</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $courrier->expediteur ?? $courrier->serviceExpediteur?->nom }}
                                </dd>
                            </div>
                            @endif
                            @if($courrier->destinataire || $courrier->serviceDestinataire)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Destinataire</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $courrier->destinataire ?? $courrier->serviceDestinataire?->nom }}
                                </dd>
                            </div>
                            @endif
                            @if($courrier->date_reception)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date de Réception</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $courrier->date_reception->format('d/m/Y') }}</dd>
                            </div>
                            @endif
                            @if($courrier->date_limite_reponse)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date Limite de Réponse</dt>
                                <dd class="mt-1 text-sm {{ $courrier->estEnRetard() ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                                    {{ $courrier->date_limite_reponse->format('d/m/Y') }}
                                </dd>
                            </div>
                            @endif
                            @if($courrier->agentResponsable)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Agent Responsable</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $courrier->agentResponsable->nom_complet }}</dd>
                            </div>
                            @endif
                            @if($courrier->repertoire)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Répertoire</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $courrier->repertoire }}</dd>
                            </div>
                            @endif
                            @if($courrier->numero_chrono)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Numéro Chrono</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $courrier->numero_chrono }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                    @if($courrier->description)
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold mb-2">Description</h3>
                        <p class="text-gray-700">{{ $courrier->description }}</p>
                    </div>
                    @endif

                    @if($courrier->observations)
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold mb-2">Observations</h3>
                        <p class="text-gray-700">{{ $courrier->observations }}</p>
                    </div>
                    @endif

                    <!-- Documents -->
                    @if($courrier->documents->count() > 0)
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold mb-4">Documents</h3>
                        <div class="space-y-3">
                            @foreach($courrier->documents as $document)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if(str_contains($document->type_mime, 'pdf'))
                                            <svg class="h-8 w-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="h-8 w-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $document->nom_document }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ ucfirst(str_replace('_', ' ', $document->type_document)) }} • 
                                            {{ $document->taille_humaine_lisible }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('courriers.documents.telecharger', $document) }}" 
                                        class="text-blue-600 hover:text-blue-900 text-sm">
                                        Télécharger
                                    </a>
                                    <form action="{{ route('courriers.documents.supprimer', $document) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm"
                                            onclick="return confirm('Supprimer ce document ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Ajouter un document -->
                        <div class="mt-4 p-4 border-2 border-dashed border-gray-300 rounded-lg">
                            <form action="{{ route('courriers.documents.ajouter', $courrier) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Document</label>
                                        <input type="file" name="document" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Type</label>
                                        <select name="type_document" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                            <option value="piece_jointe">Pièce jointe</option>
                                            <option value="reponse">Réponse</option>
                                            <option value="accusé_reception">Accusé de réception</option>
                                            <option value="autre">Autre</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <input type="text" name="description"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                </div>
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                    Ajouter le Document
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Actions</h3>
                        <div class="flex flex-wrap gap-3">
                            <button type="button" onclick="document.getElementById('status-modal').classList.remove('hidden')"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Changer le Statut
                            </button>
                            <button type="button" onclick="document.getElementById('transmission-modal').classList.remove('hidden')"
                                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                Transmettre
                            </button>
                            <form action="{{ route('courriers.destroy', $courrier) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700"
                                    onclick="return confirm('Supprimer ce courrier ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Historique des actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Historique des Actions</h3>
                    <div class="space-y-4">
                        @foreach($courrier->suivis->sortByDesc('created_at') as $suivi)
                        <div class="border-l-4 border-blue-500 pl-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $suivi->action_libelle }}</p>
                                    <p class="text-sm text-gray-600">{{ $suivi->user->name }}</p>
                                    @if($suivi->commentaire)
                                        <p class="text-sm text-gray-700 mt-1">{{ $suivi->commentaire }}</p>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500">{{ $suivi->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Informations système -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Informations Système</h3>
                    <dl class="space-y-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Enregistré par</dt>
                            <dd class="text-sm text-gray-900">{{ $courrier->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Date de création</dt>
                            <dd class="text-sm text-gray-900">{{ $courrier->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dernière modification</dt>
                            <dd class="text-sm text-gray-900">{{ $courrier->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        @if($courrier->delai_traitement)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Délai de traitement</dt>
                            <dd class="text-sm text-gray-900">{{ $courrier->delai_traitement }} jours</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Changement de Statut -->
    <div id="status-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Changer le Statut</h3>
                <form action="{{ route('courriers.changer-status', $courrier) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nouveau Statut</label>
                        <select name="status" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            <option value="en_attente">En attente</option>
                            <option value="en_cours_traitement">En cours de traitement</option>
                            <option value="traite">Traité</option>
                            <option value="en_attente_reponse">En attente de réponse</option>
                            <option value="archive">Archivé</option>
                            <option value="clos">Clos</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Commentaire</label>
                        <textarea name="commentaire" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('status-modal').classList.add('hidden')"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Transmission -->
    <div id="transmission-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Transmettre le Courrier</h3>
                <form action="{{ route('courriers.transmettre', $courrier) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Service Destinataire</label>
                        <select name="service_destinataire_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            @foreach(\App\Models\Service::orderBy('nom')->get() as $service)
                                <option value="{{ $service->id }}">{{ $service->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Agent Responsable</label>
                        <select name="agent_responsable_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            <option value="">Sélectionner un agent</option>
                            @foreach(\App\Models\Agent::where('status', 'actif')->orderBy('nom')->get() as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->nom_complet }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Commentaire</label>
                        <textarea name="commentaire" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('transmission-modal').classList.add('hidden')"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Transmettre
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection