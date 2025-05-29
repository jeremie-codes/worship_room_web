@extends('layout.app')

@section('content')
<div class="container mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Gestion Logistique</h1>
            <p class="text-gray-600">Gérez les demandes de fournitures et le stock de matériel</p>
        </div>
        <div class="mt-4 md:mt-0">
            <x-button type="button" class="bg-blue-600 hover:bg-blue-700" onclick="openModal('modal-ajouter-produit')">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Ajouter un produit
            </x-button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulaire de demande de fournitures -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Demande de fournitures</h2>
                <form action="{{ route('logistique.demande.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="produit" class="block text-sm font-medium text-gray-700 mb-1">Produit</label>
                        <select id="produit" name="produit_id" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Sélectionnez un produit</option>
                            <option value="1">Papier A4 (500 feuilles)</option>
                            <option value="2">Stylos bleus (boîte de 50)</option>
                            <option value="3">Classeurs A4</option>
                            <option value="4">Cartouches d'encre HP 304</option>
                            <option value="5">Post-it (pack de 12)</option>
                        </select>
                    </div>
                    <div>
                        <label for="quantite" class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                        <input type="number" id="quantite" name="quantite" min="1" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Service demandeur</label>
                        <select id="service" name="service_id" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="1">Administration</option>
                            <option value="2">Comptabilité</option>
                            <option value="3">Informatique</option>
                            <option value="4">Marketing</option>
                            <option value="5">Production</option>
                            <option value="6">Ressources Humaines</option>
                        </select>
                    </div>
                    <div>
                        <label for="commentaire" class="block text-sm font-medium text-gray-700 mb-1">Commentaire</label>
                        <textarea id="commentaire" name="commentaire" rows="3" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <div>
                        <label for="urgence" class="block text-sm font-medium text-gray-700 mb-1">Niveau d'urgence</label>
                        <select id="urgence" name="urgence" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="basse">Basse</option>
                            <option value="normale">Normale</option>
                            <option value="haute">Haute</option>
                            <option value="critique">Critique</option>
                        </select>
                    </div>
                    <div class="pt-4">
                        <x-button type="submit" class="w-full bg-blue-600 hover:bg-blue-700">
                            Soumettre la demande
                        </x-button>
                    </div>
                </form>
            </div>

            <!-- Statistiques des demandes -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Statistiques de demandes</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Demandes en attente</p>
                        <div class="flex items-center">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                <div class="bg-amber-500 h-2.5 rounded-full" style="width: 35%"></div>
                            </div>
                            <span class="text-sm font-medium">8</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Demandes traitées ce mois</p>
                        <div class="flex items-center">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: 65%"></div>
                            </div>
                            <span class="text-sm font-medium">42</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Produits en rupture</p>
                        <div class="flex items-center">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                <div class="bg-red-500 h-2.5 rounded-full" style="width: 10%"></div>
                            </div>
                            <span class="text-sm font-medium">3</span>
                        </div>
                    </div>
                    <div class="pt-4 mt-4 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-800 mb-2">Demandes par service</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <span>Administration</span>
                                <span>15%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: 15%"></div>
                            </div>

                            <div class="flex justify-between items-center text-xs">
                                <span>Comptabilité</span>
                                <span>8%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: 8%"></div>
                            </div>

                            <div class="flex justify-between items-center text-xs">
                                <span>Informatique</span>
                                <span>42%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: 42%"></div>
                            </div>

                            <div class="flex justify-between items-center text-xs">
                                <span>Marketing</span>
                                <span>20%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: 20%"></div>
                            </div>

                            <div class="flex justify-between items-center text-xs">
                                <span>RH</span>
                                <span>15%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-blue-600 h-1.5 rounded-full" style="width: 15%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau de stock et demandes -->
        <div class="lg:col-span-2">
            <!-- Onglets -->
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px">
                    <li class="mr-2">
                        <a href="#" class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active" aria-current="page">Inventaire</a>
                    </li>
                    <li class="mr-2">
                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">Demandes en cours</a>
                    </li>
                    <li class="mr-2">
                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">Historique</a>
                    </li>
                </ul>
            </div>

            <!-- Filtres de recherche -->
            <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label for="search_stock" class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="search_stock" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Rechercher un produit...">
                        </div>
                    </div>
                    <div class="w-full md:w-1/4">
                        <label for="categorie" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                        <select id="categorie" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Toutes les catégories</option>
                            <option value="papeterie">Papeterie</option>
                            <option value="informatique">Informatique</option>
                            <option value="bureautique">Bureautique</option>
                            <option value="hygiene">Hygiène et entretien</option>
                        </select>
                    </div>
                    <div class="w-full md:w-1/4">
                        <label for="statut_stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                        <select id="statut_stock" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Tous les statuts</option>
                            <option value="en_stock">En stock</option>
                            <option value="faible">Stock faible</option>
                            <option value="rupture">En rupture</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <x-button type="button" class="bg-gray-600 hover:bg-gray-700 h-10">
                            Filtrer
                        </x-button>
                    </div>
                </div>
            </div>

            <!-- Tableau des produits en stock -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <x-table>
                        <x-slot name="header">
                            <x-table.heading>Produit</x-table.heading>
                            <x-table.heading>Catégorie</x-table.heading>
                            <x-table.heading>Quantité</x-table.heading>
                            <x-table.heading>Seuil d'alerte</x-table.heading>
                            <x-table.heading>Statut</x-table.heading>
                            <x-table.heading>Actions</x-table.heading>
                        </x-slot>

                        <x-table.row>
                            <x-table.cell>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-md flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">Papier A4 (500 feuilles)</div>
                                        <div class="text-gray-500 text-xs">Réf: PAP-A4-001</div>
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>Papeterie</x-table.cell>
                            <x-table.cell>42</x-table.cell>
                            <x-table.cell>20</x-table.cell>
                            <x-table.cell>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    En stock
                                </span>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex space-x-2">
                                    <button onclick="openModal('modal-modifier-produit')" class="text-blue-600 hover:text-blue-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-amber-600 hover:text-amber-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </button>
                                </div>
                            </x-table.cell>
                        </x-table.row>

                        <x-table.row>
                            <x-table.cell>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-md flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">Stylos bleus (boîte de 50)</div>
                                        <div class="text-gray-500 text-xs">Réf: STY-BL-050</div>
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>Papeterie</x-table.cell>
                            <x-table.cell>12</x-table.cell>
                            <x-table.cell>15</x-table.cell>
                            <x-table.cell>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">
                                    Stock faible
                                </span>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex space-x-2">
                                    <button onclick="openModal('modal-modifier-produit')" class="text-blue-600 hover:text-blue-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-amber-600 hover:text-amber-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </button>
                                </div>
                            </x-table.cell>
                        </x-table.row>

                        <x-table.row>
                            <x-table.cell>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-md flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">Classeurs A4</div>
                                        <div class="text-gray-500 text-xs">Réf: CLA-A4-001</div>
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>Papeterie</x-table.cell>
                            <x-table.cell>27</x-table.cell>
                            <x-table.cell>10</x-table.cell>
                            <x-table.cell>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    En stock
                                </span>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex space-x-2">
                                    <button onclick="openModal('modal-modifier-produit')" class="text-blue-600 hover:text-blue-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-amber-600 hover:text-amber-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </button>
                                </div>
                            </x-table.cell>
                        </x-table.row>

                        <x-table.row>
                            <x-table.cell>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-md flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">Cartouches d'encre HP 304</div>
                                        <div class="text-gray-500 text-xs">Réf: ENC-HP-304</div>
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>Informatique</x-table.cell>
                            <x-table.cell>0</x-table.cell>
                            <x-table.cell>5</x-table.cell>
                            <x-table.cell>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    En rupture
                                </span>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex space-x-2">
                                    <button onclick="openModal('modal-modifier-produit')" class="text-blue-600 hover:text-blue-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-amber-600 hover:text-amber-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </button>
                                </div>
                            </x-table.cell>
                        </x-table.row>

                        <x-table.row>
                            <x-table.cell>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-md flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">Post-it (pack de 12)</div>
                                        <div class="text-gray-500 text-xs">Réf: PST-12-001</div>
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>Papeterie</x-table.cell>
                            <x-table.cell>18</x-table.cell>
                            <x-table.cell>10</x-table.cell>
                            <x-table.cell>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    En stock
                                </span>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex space-x-2">
                                    <button onclick="openModal('modal-modifier-produit')" class="text-blue-600 hover:text-blue-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-amber-600 hover:text-amber-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </button>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    </x-table>
                </div>

                <!-- Pagination -->
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Affichage de <span class="font-medium">1</span> à <span class="font-medium">5</span> sur <span class="font-medium">25</span> produits
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">
                                        <span class="sr-only">Précédent</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-gray-300">1</a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">2</a>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">3</a>
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">...</span>
                                    <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">5</a>
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50">
                                        <span class="sr-only">Suivant</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte Fournisseurs -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Fournisseurs principaux</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="border rounded-lg p-4">
                        <div class="font-medium">Office Express</div>
                        <div class="text-sm text-gray-600">Fournitures de bureau</div>
                        <div class="mt-2 text-xs text-gray-500">
                            <div>Contact: Pierre Dupont</div>
                            <div>Tél: 01 23 45 67 89</div>
                            <div>Email: contact@office-express.fr</div>
                        </div>
                        <div class="mt-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Actif
                            </span>
                        </div>
                    </div>

                    <div class="border rounded-lg p-4">
                        <div class="font-medium">InfoTech Solutions</div>
                        <div class="text-sm text-gray-600">Matériel informatique</div>
                        <div class="mt-2 text-xs text-gray-500">
                            <div>Contact: Marie Legrand</div>
                            <div>Tél: 01 23 45 67 90</div>
                            <div>Email: info@infotech-solutions.fr</div>
                        </div>
                        <div class="mt-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Actif
                            </span>
                        </div>
                    </div>

                    <div class="border rounded-lg p-4">
                        <div class="font-medium">Hygiène Pro</div>
                        <div class="text-sm text-gray-600">Produits d'entretien</div>
                        <div class="mt-2 text-xs text-gray-500">
                            <div>Contact: Paul Martin</div>
                            <div>Tél: 01 23 45 67 91</div>
                            <div>Email: contact@hygiene-pro.fr</div>
                        </div>
                        <div class="mt-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Inactif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                        Voir tous les fournisseurs →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ajouter Produit -->
    <x-modal id="modal-ajouter-produit" title="Ajouter un produit">
        {{-- <form action="{{ route('logistique.produit.store') }}" method="POST" class="space-y-4"> --}}
        <form action="{{ url('') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="nom_produit" class="block text-sm font-medium text-gray-700 mb-1">Nom du produit</label>
                    <input type="text" id="nom_produit" name="nom" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="reference" class="block text-sm font-medium text-gray-700 mb-1">Référence</label>
                    <input type="text" id="reference" name="reference" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="categorie_produit" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                    <select id="categorie_produit" name="categorie_id" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="1">Papeterie</option>
                        <option value="2">Informatique</option>
                        <option value="3">Bureautique</option>
                        <option value="4">Hygiène et entretien</option>
                    </select>
                </div>
                <div>
                    <label for="fournisseur" class="block text-sm font-medium text-gray-700 mb-1">Fournisseur</label>
                    <select id="fournisseur" name="fournisseur_id" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="1">Office Express</option>
                        <option value="2">InfoTech Solutions</option>
                        <option value="3">Hygiène Pro</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label for="quantite_stock" class="block text-sm font-medium text-gray-700 mb-1">Quantité en stock</label>
                    <input type="number" id="quantite_stock" name="quantite" min="0" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="seuil_alerte" class="block text-sm font-medium text-gray-700 mb-1">Seuil d'alerte</label>
                    <input type="number" id="seuil_alerte" name="seuil_alerte" min="0" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="prix_unitaire" class="block text-sm font-medium text-gray-700 mb-1">Prix unitaire (€)</label>
                    <input type="number" id="prix_unitaire" name="prix_unitaire" min="0" step="0.01" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="3" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <x-button type="button" class="bg-gray-500 hover:bg-gray-600" onclick="closeModal('modal-ajouter-produit')">
                    Annuler
                </x-button>
                <x-button type="submit" class="bg-blue-600 hover:bg-blue-700">
                    Ajouter
                </x-button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Modifier Produit -->
    <x-modal id="modal-modifier-produit" title="Modifier un produit">
        <form action="{{ route('logistique.produit.update', 1) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="nom_produit_edit" class="block text-sm font-medium text-gray-700 mb-1">Nom du produit</label>
                    <input type="text" id="nom_produit_edit" name="nom" value="Papier A4 (500 feuilles)" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="reference_edit" class="block text-sm font-medium text-gray-700 mb-1">Référence</label>
                    <input type="text" id="reference_edit" name="reference" value="PAP-A4-001" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="categorie_produit_edit" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                    <select id="categorie_produit_edit" name="categorie_id" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="1" selected>Papeterie</option>
                        <option value="2">Informatique</option>
                        <option value="3">Bureautique</option>
                        <option value="4">Hygiène et entretien</option>
                    </select>
                </div>
                <div>
                    <label for="fournisseur_edit" class="block text-sm font-medium text-gray-700 mb-1">Fournisseur</label>
                    <select id="fournisseur_edit" name="fournisseur_id" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="1" selected>Office Express</option>
                        <option value="2">InfoTech Solutions</option>
                        <option value="3">Hygiène Pro</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label for="quantite_stock_edit" class="block text-sm font-medium text-gray-700 mb-1">Quantité en stock</label>
                    <input type="number" id="quantite_stock_edit" name="quantite" min="0" value="42" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="seuil_alerte_edit" class="block text-sm font-medium text-gray-700 mb-1">Seuil d'alerte</label>
                    <input type="number" id="seuil_alerte_edit" name="seuil_alerte" min="0" value="20" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="prix_unitaire_edit" class="block text-sm font-medium text-gray-700 mb-1">Prix unitaire (€)</label>
                    <input type="number" id="prix_unitaire_edit" name="prix_unitaire" min="0" step="0.01" value="4.50" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                </div>
            </div>
            <div>
                <label for="description_edit" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description_edit" name="description" rows="3" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">Ramette de papier blanc A4 80g/m² pour imprimante et photocopieuse. Emballage de 500 feuilles.</textarea>
            </div>
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <x-button type="button" class="bg-gray-500 hover:bg-gray-600" onclick="closeModal('modal-modifier-produit')">
                    Annuler
                </x-button>
                <x-button type="submit" class="bg-blue-600 hover:bg-blue-700">
                    Mettre à jour
                </x-button>
            </div>
        </form>
    </x-modal>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('flex');
            document.getElementById(id).classList.add('hidden');
        }
    </script>
</div>
@endsection
