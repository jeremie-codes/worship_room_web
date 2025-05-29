@extends('layout.app')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tableau de bord</h1>
        <p class="text-gray-600">Bienvenue sur le système de gestion RH ANADEC</p>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
        <!-- Carte Employés -->
        <x-card class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-600 bg-opacity-30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium">Total Employés</h2>
                    <p class="text-3xl font-bold">127</p>
                    <p class="text-xs text-blue-100">+3 ce mois</p>
                </div>
            </div>
        </x-card>

        <!-- Carte Congés en attente -->
        <x-card class="bg-gradient-to-r from-amber-500 to-amber-600 text-white">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-amber-600 bg-opacity-30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium">Congés en attente</h2>
                    <p class="text-3xl font-bold">12</p>
                    <p class="text-xs text-amber-100">À traiter</p>
                </div>
            </div>
        </x-card>

        <!-- Carte Congés en cours -->
        <x-card class="bg-gradient-to-r from-green-500 to-green-600 text-white">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-600 bg-opacity-30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium">Congés en cours</h2>
                    <p class="text-3xl font-bold">8</p>
                    <p class="text-xs text-green-100">Cette semaine</p>
                </div>
            </div>
        </x-card>

        <!-- Carte Employés malades -->
        <x-card class="bg-gradient-to-r from-red-500 to-red-600 text-white">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-600 bg-opacity-30">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium">Employés malades</h2>
                    <p class="text-3xl font-bold">5</p>
                    <p class="text-xs text-red-100">Absences maladie</p>
                </div>
            </div>
        </x-card>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Activité récente -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-lg font-semibold text-gray-800">Activité récente</h2>
            <div class="space-y-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-8 h-8 text-white bg-blue-500 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 ml-4">
                        <p class="text-sm font-medium text-gray-800">Martin Dupont a été ajouté</p>
                        <p class="text-xs text-gray-500">Aujourd'hui à 10:30</p>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-8 h-8 text-white bg-green-500 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 ml-4">
                        <p class="text-sm font-medium text-gray-800">Demande de congé approuvée</p>
                        <p class="text-xs text-gray-500">Hier à 15:45</p>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-8 h-8 text-white bg-amber-500 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 ml-4">
                        <p class="text-sm font-medium text-gray-800">Nouvelle demande de congé</p>
                        <p class="text-xs text-gray-500">15/08/2023</p>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-8 h-8 text-white bg-red-500 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 ml-4">
                        <p class="text-sm font-medium text-gray-800">Absence signalée</p>
                        <p class="text-xs text-gray-500">14/08/2023</p>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-center">
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                    Voir toutes les activités →
                </a>
            </div>
        </div>

        <!-- Congés à venir -->
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-lg font-semibold text-gray-800">Congés à venir</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 border-b">
                            <th class="pb-2 font-medium">Employé</th>
                            <th class="pb-2 font-medium">Département</th>
                            <th class="pb-2 font-medium">Début</th>
                            <th class="pb-2 font-medium">Fin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr class="text-sm text-gray-800">
                            <td class="py-3">Sophie Martin</td>
                            <td class="py-3">Comptabilité</td>
                            <td class="py-3">20/08/2023</td>
                            <td class="py-3">27/08/2023</td>
                        </tr>
                        <tr class="text-sm text-gray-800">
                            <td class="py-3">Jean Dubois</td>
                            <td class="py-3">IT</td>
                            <td class="py-3">25/08/2023</td>
                            <td class="py-3">05/09/2023</td>
                        </tr>
                        <tr class="text-sm text-gray-800">
                            <td class="py-3">Claire Leroy</td>
                            <td class="py-3">Marketing</td>
                            <td class="py-3">01/09/2023</td>
                            <td class="py-3">15/09/2023</td>
                        </tr>
                        <tr class="text-sm text-gray-800">
                            <td class="py-3">Thomas Bernard</td>
                            <td class="py-3">Production</td>
                            <td class="py-3">05/09/2023</td>
                            <td class="py-3">12/09/2023</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('conges.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                    Gérer les congés →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection