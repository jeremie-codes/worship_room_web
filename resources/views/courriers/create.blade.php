@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Nouveau Courrier</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('courriers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Informations de base -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Informations Générales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type de Courrier</label>
                            <select name="type" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                <option value="entrant">Entrant</option>
                                <option value="sortant">Sortant</option>
                                <option value="interne">Interne</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Motif</label>
                            <select name="motif" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                <option value="demande">Demande</option>
                                <option value="reponse">Réponse</option>
                                <option value="notification">Notification</option>
                                <option value="convocation">Convocation</option>
                                <option value="rapport">Rapport</option>
                                <option value="facture">Facture</option>
                                <option value="contrat">Contrat</option>
                                <option value="correspondance">Correspondance</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Priorité</label>
                            <select name="priorite" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                <option value="normale">Normale</option>
                                <option value="urgente">Urgente</option>
                                <option value="tres_urgente">Très Urgente</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Objet et description -->
                <div class="border-b pb-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Objet</label>
                            <input type="text" name="objet" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Expéditeur/Destinataire -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Expéditeur et Destinataire</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Expéditeur (externe)</label>
                            <input type="text" name="expediteur"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Service Expéditeur</label>
                            <select name="service_expediteur_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                <option value="">Sélectionner un service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Destinataire (externe)</label>
                            <input type="text" name="destinataire"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Service Destinataire</label>
                            <select name="service_destinataire_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                <option value="">Sélectionner un service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Dates</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date du Courrier</label>
                            <input type="date" name="date_courrier" value="{{ date('Y-m-d') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date de Réception</label>
                            <input type="date" name="date_reception"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date d'Envoi</label>
                            <input type="date" name="date_envoi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date Limite de Réponse</label>
                            <input type="date" name="date_limite_reponse"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                    </div>
                </div>

                <!-- Assignation et classification -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Assignation et Classification</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Agent Responsable</label>
                            <select name="agent_responsable_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                <option value="">Sélectionner un agent</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->nom_complet }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Répertoire/Dossier</label>
                            <input type="text" name="repertoire"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Numéro Chrono</label>
                            <input type="text" name="numero_chrono"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="confidentiel" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Courrier confidentiel</span>
                        </label>
                    </div>
                </div>

                <!-- Documents -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Documents</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fichiers (PDF, DOC, DOCX, JPG, PNG - Max 10MB)</label>
                        <input type="file" name="documents[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>

                <!-- Observations -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Observations</label>
                    <textarea name="observations" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('courriers.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                        Annuler
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection