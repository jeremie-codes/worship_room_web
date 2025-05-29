@extends('layout.app')

@section('content')
<div class="container mx-auto">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Gestion des Rôles et Permissions</h1>
            <p class="text-gray-600">Définissez les accès et permissions des utilisateurs du système</p>
        </div>
        <div class="mt-4 md:mt-0">
            <x-button type="button" class="bg-blue-600 hover:bg-blue-700" onclick="openModal('modal-ajouter-role')">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Ajouter un rôle
            </x-button>
        </div>
    </div>

    <!-- Rôles existants -->
    <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Administrateur -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-600 p-4">
                <h3 class="text-lg font-semibold text-white">Administrateur</h3>
                <p class="text-blue-100 text-sm">Accès complet au système</p>
            </div>
            <div class="p-5">
                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-2">Utilisateurs avec ce rôle</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Martin Dubois
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Sophie Lambert
                        </span>
                    </div>
                </div>
                <div class="space-y-3">
                    <h4 class="font-medium text-gray-800 text-sm">Permissions</h4>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Gestion des employés</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Gestion des congés</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Gestion des utilisateurs</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Gestion des rôles</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Accès aux rapports</span>
                    </div>
                </div>
                <div class="mt-5 flex space-x-2 pt-4 border-t">
                    <x-button type="button" class="bg-blue-600 hover:bg-blue-700" onclick="openModal('modal-modifier-role')">
                        Modifier
                    </x-button>
                    <x-button type="button" class="bg-gray-500 hover:bg-gray-600">
                        Dupliquer
                    </x-button>
                </div>
            </div>
        </div>

        <!-- Responsable RH -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-500 p-4">
                <h3 class="text-lg font-semibold text-white">Responsable RH</h3>
                <p class="text-blue-100 text-sm">Gestion des ressources humaines</p>
            </div>
            <div class="p-5">
                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-2">Utilisateurs avec ce rôle</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Jean Bernard
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Marie Petit
                        </span>
                    </div>
                </div>
                <div class="space-y-3">
                    <h4 class="font-medium text-gray-800 text-sm">Permissions</h4>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Gestion des employés</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Gestion des congés</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Gestion des présences</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="text-sm">Gestion des rôles</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Accès aux rapports</span>
                    </div>
                </div>
                <div class="mt-5 flex space-x-2 pt-4 border-t">
                    <x-button type="button" class="bg-blue-600 hover:bg-blue-700" onclick="openModal('modal-modifier-role')">
                        Modifier
                    </x-button>
                    <x-button type="button" class="bg-gray-500 hover:bg-gray-600">
                        Dupliquer
                    </x-button>
                </div>
            </div>
        </div>

        <!-- Employé -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-400 p-4">
                <h3 class="text-lg font-semibold text-white">Employé</h3>
                <p class="text-blue-100 text-sm">Accès limité au système</p>
            </div>
            <div class="p-5">
                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-2">Utilisateurs avec ce rôle</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            118 utilisateurs
                        </span>
                    </div>
                </div>
                <div class="space-y-3">
                    <h4 class="font-medium text-gray-800 text-sm">Permissions</h4>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="text-sm">Gestion des employés</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Demande de congés</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm">Consultation de présence</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="text-sm">Gestion des rôles</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="text-sm">Accès aux rapports</span>
                    </div>
                </div>
                <div class="mt-5 flex space-x-2 pt-4 border-t">
                    <x-button type="button" class="bg-blue-600 hover:bg-blue-700" onclick="openModal('modal-modifier-role')">
                        Modifier
                    </x-button>
                    <x-button type="button" class="bg-gray-500 hover:bg-gray-600">
                        Dupliquer
                    </x-button>
                </div>
            </div>
        </div>
    </div>

    <!-- Gestion des utilisateurs -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Utilisateurs du système</h2>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <x-table>
                    <x-slot name="header">
                        <x-table.heading>Utilisateur</x-table.heading>
                        <x-table.heading>Email</x-table.heading>
                        <x-table.heading>Rôle</x-table.heading>
                        <x-table.heading>Dernière connexion</x-table.heading>
                        <x-table.heading>Statut</x-table.heading>
                        <x-table.heading>Actions</x-table.heading>
                    </x-slot>
                    
                    <x-table.row>
                        <x-table.cell>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/1.jpg" alt="Photo utilisateur">
                                </div>
                                <div class="ml-4">
                                    <div class="font-medium text-gray-900">Martin Dubois</div>
                                </div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>m.dubois@anadec.fr</x-table.cell>
                        <x-table.cell>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Administrateur
                            </span>
                        </x-table.cell>
                        <x-table.cell>Aujourd'hui à 10:25</x-table.cell>
                        <x-table.cell>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Actif
                            </span>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex space-x-2">
                                <button onclick="openModal('modal-modifier-utilisateur')" class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="if(confirm('Êtes-vous sûr de vouloir désactiver cet utilisateur?')) alert('Utilisateur désactivé')" class="text-red-600 hover:text-red-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                </button>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                    
                    <x-table.row>
                        <x-table.cell>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/women/3.jpg" alt="Photo utilisateur">
                                </div>
                                <div class="ml-4">
                                    <div class="font-medium text-gray-900">Sophie Lambert</div>
                                </div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>s.lambert@anadec.fr</x-table.cell>
                        <x-table.cell>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Administrateur
                            </span>
                        </x-table.cell>
                        <x-table.cell>Hier à 16:42</x-table.cell>
                        <x-table.cell>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Actif
                            </span>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex space-x-2">
                                <button onclick="openModal('modal-modifier-utilisateur')" class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="if(confirm('Êtes-vous sûr de vouloir désactiver cet utilisateur?')) alert('Utilisateur désactivé')" class="text-red-600 hover:text-red-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                </button>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                    
                    <x-table.row>
                        <x-table.cell>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/5.jpg" alt="Photo utilisateur">
                                </div>
                                <div class="ml-4">
                                    <div class="font-medium text-gray-900">Jean Bernard</div>
                                </div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>j.bernard@anadec.fr</x-table.cell>
                        <x-table.cell>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Responsable RH
                            </span>
                        </x-table.cell>
                        <x-table.cell>15/08/2023</x-table.cell>
                        <x-table.cell>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Actif
                            </span>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex space-x-2">
                                <button onclick="openModal('modal-modifier-utilisateur')" class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="if(confirm('Êtes-vous sûr de vouloir désactiver cet utilisateur?')) alert('Utilisateur désactivé')" class="text-red-600 hover:text-red-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                </button>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                    
                    <x-table.row>
                        <x-table.cell>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/9.jpg" alt="Photo utilisateur">
                                </div>
                                <div class="ml-4">
                                    <div class="font-medium text-gray-900">Marc Petit</div>
                                </div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>m.petit@anadec.fr</x-table.cell>
                        <x-table.cell>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Employé
                            </span>
                        </x-table.cell>
                        <x-table.cell>14/08/2023</x-table.cell>
                        <x-table.cell>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Inactif
                            </span>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex space-x-2">
                                <button onclick="openModal('modal-modifier-utilisateur')" class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                                <button onclick="if(confirm('Êtes-vous sûr de vouloir activer cet utilisateur?')) alert('Utilisateur activé')" class="text-green-600 hover:text-green-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                                Affichage de <span class="font-medium">1</span> à <span class="font-medium">4</span> sur <span class="font-medium">127</span> utilisateurs
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
    </div>

    <!-- Modal Ajouter Rôle -->
    <x-modal id="modal-ajouter-role" title="Ajouter un rôle">
        <form action="{{ route('users.roles.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom du rôle</label>
                <input type="text" id="nom" name="nom" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Ex: Responsable Département" required>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="2" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Décrivez brièvement ce rôle"></textarea>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Permissions</h3>
                <div class="space-y-2 max-h-64 overflow-y-auto p-2 border border-gray-200 rounded-md">
                    <div class="flex items-center">
                        <input id="perm_employes" name="permissions[]" value="employes" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="perm_employes" class="ml-2 block text-sm text-gray-700">Gestion des employés</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_conges" name="permissions[]" value="conges" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="perm_conges" class="ml-2 block text-sm text-gray-700">Gestion des congés</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_presences" name="permissions[]" value="presences" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="perm_presences" class="ml-2 block text-sm text-gray-700">Gestion des présences</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_utilisateurs" name="permissions[]" value="utilisateurs" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="perm_utilisateurs" class="ml-2 block text-sm text-gray-700">Gestion des utilisateurs</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_roles" name="permissions[]" value="roles" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="perm_roles" class="ml-2 block text-sm text-gray-700">Gestion des rôles</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_rapports" name="permissions[]" value="rapports" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="perm_rapports" class="ml-2 block text-sm text-gray-700">Accès aux rapports</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_logistique" name="permissions[]" value="logistique" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="perm_logistique" class="ml-2 block text-sm text-gray-700">Gestion de la logistique</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_finances" name="permissions[]" value="finances" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="perm_finances" class="ml-2 block text-sm text-gray-700">Accès aux finances</label>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <x-button type="button" class="bg-gray-500 hover:bg-gray-600" onclick="closeModal('modal-ajouter-role')">
                    Annuler
                </x-button>
                <x-button type="submit" class="bg-blue-600 hover:bg-blue-700">
                    Créer le rôle
                </x-button>
            </div>
        </form>
    </x-modal>
    
    <!-- Modal Modifier Rôle -->
    <x-modal id="modal-modifier-role" title="Modifier un rôle">
        <form action="{{ route('users.roles.update', 1) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="nom_edit" class="block text-sm font-medium text-gray-700 mb-1">Nom du rôle</label>
                <input type="text" id="nom_edit" name="nom" value="Administrateur" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="description_edit" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description_edit" name="description" rows="2" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">Accès complet au système</textarea>
            </div>
            
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Permissions</h3>
                <div class="space-y-2 max-h-64 overflow-y-auto p-2 border border-gray-200 rounded-md">
                    <div class="flex items-center">
                        <input id="perm_employes_edit" name="permissions[]" value="employes" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                        <label for="perm_employes_edit" class="ml-2 block text-sm text-gray-700">Gestion des employés</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_conges_edit" name="permissions[]" value="conges" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                        <label for="perm_conges_edit" class="ml-2 block text-sm text-gray-700">Gestion des congés</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_presences_edit" name="permissions[]" value="presences" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                        <label for="perm_presences_edit" class="ml-2 block text-sm text-gray-700">Gestion des présences</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_utilisateurs_edit" name="permissions[]" value="utilisateurs" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                        <label for="perm_utilisateurs_edit" class="ml-2 block text-sm text-gray-700">Gestion des utilisateurs</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_roles_edit" name="permissions[]" value="roles" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                        <label for="perm_roles_edit" class="ml-2 block text-sm text-gray-700">Gestion des rôles</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_rapports_edit" name="permissions[]" value="rapports" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                        <label for="perm_rapports_edit" class="ml-2 block text-sm text-gray-700">Accès aux rapports</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_logistique_edit" name="permissions[]" value="logistique" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                        <label for="perm_logistique_edit" class="ml-2 block text-sm text-gray-700">Gestion de la logistique</label>
                    </div>
                    <div class="flex items-center">
                        <input id="perm_finances_edit" name="permissions[]" value="finances" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" checked>
                        <label for="perm_finances_edit" class="ml-2 block text-sm text-gray-700">Accès aux finances</label>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <x-button type="button" class="bg-gray-500 hover:bg-gray-600" onclick="closeModal('modal-modifier-role')">
                    Annuler
                </x-button>
                <x-button type="submit" class="bg-blue-600 hover:bg-blue-700">
                    Mettre à jour
                </x-button>
            </div>
        </form>
    </x-modal>
    
    <!-- Modal Modifier Utilisateur -->
    <x-modal id="modal-modifier-utilisateur" title="Modifier un utilisateur">
        <form action="{{ route('users.update', 1) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="user_name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                <input type="text" id="user_name" name="name" value="Martin Dubois" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="user_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="user_email" name="email" value="m.dubois@anadec.fr" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="user_role" class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                <select id="user_role" name="role" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="administrateur" selected>Administrateur</option>
                    <option value="responsable_rh">Responsable RH</option>
                    <option value="employe">Employé</option>
                </select>
            </div>
            <div>
                <div class="flex items-center mb-2">
                    <input id="change_password" name="change_password" type="checkbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="change_password" class="ml-2 block text-sm text-gray-700">Changer le mot de passe</label>
                </div>
                <div class="mt-2">
                    <label for="user_password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                    <input type="password" id="user_password" name="password" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Laissez vide pour conserver l'actuel">
                </div>
            </div>
            <div>
                <label for="user_status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select id="user_status" name="status" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="active" selected>Actif</option>
                    <option value="inactive">Inactif</option>
                </select>
            </div>
            
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <x-button type="button" class="bg-gray-500 hover:bg-gray-600" onclick="closeModal('modal-modifier-utilisateur')">
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