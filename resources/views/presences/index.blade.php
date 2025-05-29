@extends('layout.app')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Présences</h1>
        <p class="text-gray-600">Suivi quotidien des présences du personnel</p>
    </div>

    <div class="mb-6 bg-white rounded-lg shadow-md p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex items-center mb-4 md:mb-0">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Aujourd'hui</h2>
                    <p class="text-gray-600">{{ date('d/m/Y') }}</p>
                </div>
                <div class="ml-6 px-4 py-2 bg-blue-100 text-blue-800 rounded-lg">
                    <div class="font-medium">Effectif présent</div>
                    <div class="text-2xl font-bold">98/127</div>
                </div>
            </div>
            <div class="flex space-x-3">
                <x-button type="button" class="bg-blue-600 hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Changer de date
                </x-button>
                <x-button type="button" class="bg-gray-600 hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Exporter
                </x-button>
            </div>
        </div>
    </div>

    <!-- Résumé par service -->
    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="font-medium text-gray-800">Administration</h3>
            <div class="mt-2 flex items-center space-x-2">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 85%"></div>
                </div>
                <span class="text-sm font-medium text-gray-600">85%</span>
            </div>
            <div class="mt-2 text-sm text-gray-600">17/20 présents</div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="font-medium text-gray-800">Production</h3>
            <div class="mt-2 flex items-center space-x-2">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 75%"></div>
                </div>
                <span class="text-sm font-medium text-gray-600">75%</span>
            </div>
            <div class="mt-2 text-sm text-gray-600">30/40 présents</div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="font-medium text-gray-800">Marketing</h3>
            <div class="mt-2 flex items-center space-x-2">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 70%"></div>
                </div>
                <span class="text-sm font-medium text-gray-600">70%</span>
            </div>
            <div class="mt-2 text-sm text-gray-600">14/20 présents</div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="font-medium text-gray-800">Informatique</h3>
            <div class="mt-2 flex items-center space-x-2">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 92%"></div>
                </div>
                <span class="text-sm font-medium text-gray-600">92%</span>
            </div>
            <div class="mt-2 text-sm text-gray-600">11/12 présents</div>
        </div>
    </div>

    <!-- Filtre de recherche -->
    <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher un employé</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Nom ou ID employé...">
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
                    <option value="present">Présent</option>
                    <option value="retard">En retard</option>
                    <option value="absent">Absent</option>
                    <option value="justifie">Absence justifiée</option>
                    <option value="autorise">Absence autorisée</option>
                </select>
            </div>
            <div class="flex items-end">
                <x-button type="submit" class="bg-gray-600 hover:bg-gray-700 h-10">
                    Filtrer
                </x-button>
            </div>
        </div>
    </div>

    <!-- Tableau des présences -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <x-table>
                <x-slot name="header">
                    <x-table.heading>Employé</x-table.heading>
                    <x-table.heading>Service</x-table.heading>
                    <x-table.heading>Heure d'arrivée</x-table.heading>
                    <x-table.heading>Heure de départ</x-table.heading>
                    <x-table.heading>Statut</x-table.heading>
                    <x-table.heading>Actions</x-table.heading>
                </x-slot>
                
                <x-table.row>
                    <x-table.cell>
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
                    <x-table.cell>Production</x-table.cell>
                    <x-table.cell>08:30</x-table.cell>
                    <x-table.cell>-</x-table.cell>
                    <x-table.cell>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Présent
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex space-x-2">
                            <button class="text-blue-600 hover:text-blue-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button class="text-gray-600 hover:text-gray-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </x-table.cell>
                </x-table.row>
                
                <x-table.row>
                    <x-table.cell>
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
                    <x-table.cell>Comptabilité</x-table.cell>
                    <x-table.cell>-</x-table.cell>
                    <x-table.cell>-</x-table.cell>
                    <x-table.cell>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            Absence autorisée
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex space-x-2">
                            <button class="text-blue-600 hover:text-blue-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button class="text-gray-600 hover:text-gray-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </x-table.cell>
                </x-table.row>
                
                <x-table.row>
                    <x-table.cell>
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
                    <x-table.cell>Informatique</x-table.cell>
                    <x-table.cell>09:15</x-table.cell>
                    <x-table.cell>-</x-table.cell>
                    <x-table.cell>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">
                            En retard
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex space-x-2">
                            <button class="text-blue-600 hover:text-blue-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button class="text-gray-600 hover:text-gray-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </x-table.cell>
                </x-table.row>
                
                <x-table.row>
                    <x-table.cell>
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
                    <x-table.cell>Marketing</x-table.cell>
                    <x-table.cell>-</x-table.cell>
                    <x-table.cell>-</x-table.cell>
                    <x-table.cell>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                            Justifié
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex space-x-2">
                            <button class="text-blue-600 hover:text-blue-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button class="text-gray-600 hover:text-gray-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </x-table.cell>
                </x-table.row>
                
                <x-table.row>
                    <x-table.cell>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/6.jpg" alt="Photo employé">
                            </div>
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">Philippe Moreau</div>
                                <div class="text-gray-500 text-xs">ID: EMP-005</div>
                            </div>
                        </div>
                    </x-table.cell>
                    <x-table.cell>Production</x-table.cell>
                    <x-table.cell>08:05</x-table.cell>
                    <x-table.cell>-</x-table.cell>
                    <x-table.cell>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Présent
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex space-x-2">
                            <button class="text-blue-600 hover:text-blue-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button class="text-gray-600 hover:text-gray-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
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
                            Affichage de <span class="font-medium">1</span> à <span class="font-medium">5</span> sur <span class="font-medium">127</span> employés
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
                            <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">26</a>
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
@endsection