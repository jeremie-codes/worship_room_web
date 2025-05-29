@extends('layout.app')

@section('content')
<div class="container mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Gestion des Employés</h1>
            <p class="text-gray-600">Gérez les informations de tous les employés de l'entreprise</p>
        </div>
        <div class="mt-4 md:mt-0">
            <x-button type="button" class="bg-blue-600 hover:bg-blue-700" onclick="openModal('modal-ajouter-employe')">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Ajouter un employé
            </x-button>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Nom, email, fonction...">
                </div>
            </div>
            <div class="w-full md:w-1/4">
                <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                <select id="service" name="service" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous les services</option>
                    <option value="administration">Administration</option>
                    <option value="comptabilite">Comptabilité</option>
                    <option value="informatique">Informatique</option>
                    <option value="marketing">Marketing</option>
                    <option value="production">Production</option>
                    <option value="rh">Ressources Humaines</option>
                </select>
            </div>
            <div class="w-full md:w-1/4">
                <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select id="statut" name="statut" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous les statuts</option>
                    <option value="actif">Actif</option>
                    <option value="conge">En congé</option>
                    <option value="malade">Malade</option>
                    <option value="inactif">Inactif</option>
                </select>
            </div>
            <div class="flex items-end">
                <x-button type="submit" class="bg-gray-600 hover:bg-gray-700 h-10">
                    Filtrer
                </x-button>
            </div>
        </div>
    </div>

    <!-- Tableau des employés -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <x-table>
                <x-slot name="header">
                    <x-table.heading>Nom</x-table.heading>
                    <x-table.heading>Grade</x-table.heading>
                    <x-table.heading>Fonction</x-table.heading>
                    <x-table.heading>Service</x-table.heading>
                    <x-table.heading>Email</x-table.heading>
                    <x-table.heading>Date d'engagement</x-table.heading>
                    <x-table.heading>Statut</x-table.heading>
                    <x-table.heading>Actions</x-table.heading>
                </x-slot>
                
                <x-table.row>
                    <x-table.cell class="font-medium">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/2.jpg" alt="Photo employé">
                            </div>
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">Thomas Bernard</div>
                                <div class="text-gray-500 text-xs">ID: EMP-001</div>
                            </div>
                        </div>
                    </x-table.cell>
                    <x-table.cell>Cadre</x-table.cell>
                    <x-table.cell>Chef de projet</x-table.cell>
                    <x-table.cell>Production</x-table.cell>
                    <x-table.cell>t.bernard@anadec.fr</x-table.cell>
                    <x-table.cell>12/03/2018</x-table.cell>
                    <x-table.cell>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Actif
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex space-x-2">
                            <button onclick="openModal('modal-modifier-employe')" class="text-blue-600 hover:text-blue-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cet employé?')) alert('Employé supprimé')" class="text-red-600 hover:text-red-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </x-table.cell>
                </x-table.row>
                
                <x-table.row>
                    <x-table.cell class="font-medium">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/women/3.jpg" alt="Photo employé">
                            </div>
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">Sophie Martin</div>
                                <div class="text-gray-500 text-xs">ID: EMP-002</div>
                            </div>
                        </div>
                    </x-table.cell>
                    <x-table.cell>Cadre</x-table.cell>
                    <x-table.cell>Responsable</x-table.cell>
                    <x-table.cell>Comptabilité</x-table.cell>
                    <x-table.cell>s.martin@anadec.fr</x-table.cell>
                    <x-table.cell>05/06/2019</x-table.cell>
                    <x-table.cell>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            En congé
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex space-x-2">
                            <button onclick="openModal('modal-modifier-employe')" class="text-blue-600 hover:text-blue-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cet employé?')) alert('Employé supprimé')" class="text-red-600 hover:text-red-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </x-table.cell>
                </x-table.row>
                
                <x-table.row>
                    <x-table.cell class="font-medium">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/4.jpg" alt="Photo employé">
                            </div>
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">Jean Dubois</div>
                                <div class="text-gray-500 text-xs">ID: EMP-003</div>
                            </div>
                        </div>
                    </x-table.cell>
                    <x-table.cell>Employé</x-table.cell>
                    <x-table.cell>Développeur</x-table.cell>
                    <x-table.cell>Informatique</x-table.cell>
                    <x-table.cell>j.dubois@anadec.fr</x-table.cell>
                    <x-table.cell>20/01/2020</x-table.cell>
                    <x-table.cell>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Actif
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex space-x-2">
                            <button onclick="openModal('modal-modifier-employe')" class="text-blue-600 hover:text-blue-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cet employé?')) alert('Employé supprimé')" class="text-red-600 hover:text-red-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </x-table.cell>
                </x-table.row>
                
                <x-table.row>
                    <x-table.cell class="font-medium">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/women/5.jpg" alt="Photo employé">
                            </div>
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">Claire Leroy</div>
                                <div class="text-gray-500 text-xs">ID: EMP-004</div>
                            </div>
                        </div>
                    </x-table.cell>
                    <x-table.cell>Cadre</x-table.cell>
                    <x-table.cell>Directrice</x-table.cell>
                    <x-table.cell>Marketing</x-table.cell>
                    <x-table.cell>c.leroy@anadec.fr</x-table.cell>
                    <x-table.cell>15/09/2017</x-table.cell>
                    <x-table.cell>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                            Malade
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex space-x-2">
                            <button onclick="openModal('modal-modifier-employe')" class="text-blue-600 hover:text-blue-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cet employé?')) alert('Employé supprimé')" class="text-red-600 hover:text-red-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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
                            Affichage de <span class="font-medium">1</span> à <span class="font-medium">4</span> sur <span class="font-medium">127</span> employés
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
                            <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">32</a>
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

    <!-- Modal Ajouter Employé -->
    <x-modal id="modal-ajouter-employe" title="Ajouter un employé">
        <form action="{{ route('employes.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Nom" name="nom" type="text" placeholder="Nom de l'employé" required />
                <x-form-field label="Prénom" name="prenom" type="text" placeholder="Prénom de l'employé" required />
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Email" name="email" type="email" placeholder="email@anadec.fr" required />
                <x-form-field label="Téléphone" name="telephone" type="tel" placeholder="+33 6 12 34 56 78" />
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="grade" class="block text-sm font-medium text-gray-700 mb-1">Grade</label>
                    <select id="grade" name="grade" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="employe">Employé</option>
                        <option value="cadre">Cadre</option>
                        <option value="direction">Direction</option>
                    </select>
                </div>
                <div>
                    <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                    <select id="service" name="service" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="administration">Administration</option>
                        <option value="comptabilite">Comptabilité</option>
                        <option value="informatique">Informatique</option>
                        <option value="marketing">Marketing</option>
                        <option value="production">Production</option>
                        <option value="rh">Ressources Humaines</option>
                    </select>
                </div>
            </div>
            <x-form-field label="Fonction" name="fonction" type="text" placeholder="Ex: Développeur, Comptable, etc." required />
            <x-form-field label="Date d'engagement" name="date_engagement" type="date" required />
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <x-button type="button" class="bg-gray-500 hover:bg-gray-600" onclick="closeModal('modal-ajouter-employe')">
                    Annuler
                </x-button>
                <x-button type="submit" class="bg-blue-600 hover:bg-blue-700">
                    Enregistrer
                </x-button>
            </div>
        </form>
    </x-modal>
    
    <!-- Modal Modifier Employé -->
    <x-modal id="modal-modifier-employe" title="Modifier un employé">
        <form action="{{ route('employes.update', 1) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Nom" name="nom" type="text" placeholder="Nom de l'employé" value="Bernard" required />
                <x-form-field label="Prénom" name="prenom" type="text" placeholder="Prénom de l'employé" value="Thomas" required />
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form-field label="Email" name="email" type="email" placeholder="email@anadec.fr" value="t.bernard@anadec.fr" required />
                <x-form-field label="Téléphone" name="telephone" type="tel" placeholder="+33 6 12 34 56 78" value="+33 6 12 34 56 78" />
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="grade_edit" class="block text-sm font-medium text-gray-700 mb-1">Grade</label>
                    <select id="grade_edit" name="grade" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="employe">Employé</option>
                        <option value="cadre" selected>Cadre</option>
                        <option value="direction">Direction</option>
                    </select>
                </div>
                <div>
                    <label for="service_edit" class="block text-sm font-medium text-gray-700 mb-1">Service</label>
                    <select id="service_edit" name="service" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="administration">Administration</option>
                        <option value="comptabilite">Comptabilité</option>
                        <option value="informatique">Informatique</option>
                        <option value="marketing">Marketing</option>
                        <option value="production" selected>Production</option>
                        <option value="rh">Ressources Humaines</option>
                    </select>
                </div>
            </div>
            <x-form-field label="Fonction" name="fonction" type="text" placeholder="Ex: Développeur, Comptable, etc." value="Chef de projet" required />
            <x-form-field label="Date d'engagement" name="date_engagement" type="date" value="2018-03-12" required />
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <x-button type="button" class="bg-gray-500 hover:bg-gray-600" onclick="closeModal('modal-modifier-employe')">
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