@extends('layout.app')

@section('content')
<div class="container mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Gestion des Congés</h1>
            <p class="text-gray-600">Gérez les demandes et les approbations de congés</p>
        </div>

        <div class="flex items-center gap-x-4">
            <a href="{{ route('conges.planning') }}" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 text-white rounded">
                {{-- <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg> --}}
                Planning
            </a>
            <a href="{{ route('conges.attribution') }}" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 text-white rounded">
                {{-- <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg> --}}
                Attribuer
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulaire de demande de congé -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Demande de congé</h2>
                <form action="{{ route('conges.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="type_conge" class="block text-sm font-medium text-gray-700 mb-1">Type de congé</label>
                        <select id="type_conge" name="type_conge" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="annuel">Congé annuel</option>
                            <option value="maladie">Congé maladie</option>
                            <option value="familial">Congé familial</option>
                            <option value="special">Congé spécial</option>
                            <option value="sans_solde">Congé sans solde</option>
                        </select>
                    </div>
                    <div>
                        <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                        <input type="date" id="date_debut" name="date_debut" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                        <input type="date" id="date_fin" name="date_fin" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="motif" class="block text-sm font-medium text-gray-700 mb-1">Motif / Commentaires</label>
                        <textarea id="motif" name="motif" rows="3" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <div>
                        <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">Contact pendant l'absence</label>
                        <input type="text" id="contact" name="contact" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="pt-4">
                        <x-button type="submit" class="w-full bg-blue-600 hover:bg-blue-700">
                            Soumettre la demande
                        </x-button>
                    </div>
                </form>
            </div>

            <!-- Solde de congés -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Solde de congés</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Congés annuels</span>
                        <span class="font-medium">18 jours restants</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: 72%"></div>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">RTT</span>
                        <span class="font-medium">5 jours restants</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: 45%"></div>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Congés exceptionnels</span>
                        <span class="font-medium">3 jours restants</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-amber-600 h-2.5 rounded-full" style="width: 100%"></div>
                    </div>

                    <div class="border-t pt-4 mt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-800">Consommés cette année</span>
                            <span class="font-medium text-blue-600">7 jours</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des congés -->
        <div class="lg:col-span-2">
            <!-- Onglets -->
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px">
                    <li class="mr-2">
                        <a href="#" class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active" aria-current="page">En attente</a>
                    </li>
                    <li class="mr-2">
                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">Approuvés</a>
                    </li>
                    <li class="mr-2">
                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">Refusés</a>
                    </li>
                    <li class="mr-2">
                        <a href="#" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300">Historique</a>
                    </li>
                </ul>
            </div>

            <!-- Tableau des congés en attente -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <x-table>
                        <x-slot name="header">
                            <x-table.heading>Employé</x-table.heading>
                            <x-table.heading>Type</x-table.heading>
                            <x-table.heading>Début</x-table.heading>
                            <x-table.heading>Fin</x-table.heading>
                            <x-table.heading>Durée</x-table.heading>
                            <x-table.heading>Motif</x-table.heading>
                            <x-table.heading>Actions</x-table.heading>
                        </x-slot>

                        <x-table.row>
                            <x-table.cell>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/4.jpg" alt="Photo employé">
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">Jean Dubois</div>
                                        <div class="text-gray-500 text-xs">Informatique</div>
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>Congé annuel</x-table.cell>
                            <x-table.cell>25/08/2023</x-table.cell>
                            <x-table.cell>05/09/2023</x-table.cell>
                            <x-table.cell>8 jours</x-table.cell>
                            <x-table.cell>Vacances familiales</x-table.cell>
                            <x-table.cell>
                                <div class="flex space-x-2">
                                    <x-button type="button" class="py-1 px-2 text-xs bg-green-600 hover:bg-green-700">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Approuver
                                    </x-button>
                                    <x-button type="button" class="py-1 px-2 text-xs bg-red-600 hover:bg-red-700">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Refuser
                                    </x-button>
                                </div>
                            </x-table.cell>
                        </x-table.row>

                        <x-table.row>
                            <x-table.cell>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/women/8.jpg" alt="Photo employé">
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">Marie Lambert</div>
                                        <div class="text-gray-500 text-xs">Administration</div>
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>Congé maladie</x-table.cell>
                            <x-table.cell>15/08/2023</x-table.cell>
                            <x-table.cell>18/08/2023</x-table.cell>
                            <x-table.cell>4 jours</x-table.cell>
                            <x-table.cell>Arrêt maladie</x-table.cell>
                            <x-table.cell>
                                <div class="flex space-x-2">
                                    <x-button type="button" class="py-1 px-2 text-xs bg-green-600 hover:bg-green-700">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Approuver
                                    </x-button>
                                    <x-button type="button" class="py-1 px-2 text-xs bg-red-600 hover:bg-red-700">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Refuser
                                    </x-button>
                                </div>
                            </x-table.cell>
                        </x-table.row>

                        <x-table.row>
                            <x-table.cell>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/9.jpg" alt="Photo employé">
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">Marc Petit</div>
                                        <div class="text-gray-500 text-xs">Production</div>
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>RTT</x-table.cell>
                            <x-table.cell>20/08/2023</x-table.cell>
                            <x-table.cell>20/08/2023</x-table.cell>
                            <x-table.cell>1 jour</x-table.cell>
                            <x-table.cell>Récupération</x-table.cell>
                            <x-table.cell>
                                <div class="flex space-x-2">
                                    <x-button type="button" class="py-1 px-2 text-xs bg-green-600 hover:bg-green-700">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Approuver
                                    </x-button>
                                    <x-button type="button" class="py-1 px-2 text-xs bg-red-600 hover:bg-red-700">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Refuser
                                    </x-button>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    </x-table>
                </div>
            </div>

            <!-- Calendrier des absences -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Calendrier des absences</h2>
                <div class="border rounded-lg overflow-hidden">
                    <!-- En-tête du calendrier -->
                    <div class="grid grid-cols-7 gap-px bg-gray-200">
                        <div class="bg-white p-2 text-center text-sm font-medium text-gray-800">Lun</div>
                        <div class="bg-white p-2 text-center text-sm font-medium text-gray-800">Mar</div>
                        <div class="bg-white p-2 text-center text-sm font-medium text-gray-800">Mer</div>
                        <div class="bg-white p-2 text-center text-sm font-medium text-gray-800">Jeu</div>
                        <div class="bg-white p-2 text-center text-sm font-medium text-gray-800">Ven</div>
                        <div class="bg-white p-2 text-center text-sm font-medium text-gray-800">Sam</div>
                        <div class="bg-white p-2 text-center text-sm font-medium text-gray-800">Dim</div>
                    </div>

                    <!-- Corps du calendrier -->
                    <div class="grid grid-cols-7 gap-px bg-gray-200">
                        <!-- Semaine 1 -->
                        <div class="bg-white p-2 h-24 text-gray-400">31</div>
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">1</div>
                        </div>
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">2</div>
                        </div>
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">3</div>
                        </div>
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">4</div>
                        </div>
                        <div class="bg-white p-2 h-24 bg-gray-50">
                            <div class="font-medium">5</div>
                        </div>
                        <div class="bg-white p-2 h-24 bg-gray-50">
                            <div class="font-medium">6</div>
                        </div>

                        <!-- Semaine 2 -->
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">7</div>
                        </div>
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">8</div>
                        </div>
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">9</div>
                        </div>
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">10</div>
                        </div>
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">11</div>
                        </div>
                        <div class="bg-white p-2 h-24 bg-gray-50">
                            <div class="font-medium">12</div>
                        </div>
                        <div class="bg-white p-2 h-24 bg-gray-50">
                            <div class="font-medium">13</div>
                        </div>

                        <!-- Semaine 3 -->
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">14</div>
                        </div>
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">15</div>
                            <div class="mt-1 p-1 text-xs bg-red-100 text-red-800 rounded">
                                Marie L.
                            </div>
                        </div>
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">16</div>
                            <div class="mt-1 p-1 text-xs bg-red-100 text-red-800 rounded">
                                Marie L.
                            </div>
                        </div>
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">17</div>
                            <div class="mt-1 p-1 text-xs bg-red-100 text-red-800 rounded">
                                Marie L.
                            </div>
                        </div>
                        <div class="bg-white p-2 h-24">
                            <div class="font-medium">18</div>
                            <div class="mt-1 p-1 text-xs bg-red-100 text-red-800 rounded">
                                Marie L.
                            </div>
                        </div>
                        <div class="bg-white p-2 h-24 bg-gray-50">
                            <div class="font-medium">19</div>
                        </div>
                        <div class="bg-white p-2 h-24 bg-gray-50">
                            <div class="font-medium">20</div>
                            <div class="mt-1 p-1 text-xs bg-green-100 text-green-800 rounded">
                                Marc P.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex space-x-4">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-100 rounded-full mr-2"></div>
                        <span class="text-xs text-gray-700">Congé maladie</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-100 rounded-full mr-2"></div>
                        <span class="text-xs text-gray-700">Congé annuel</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-100 rounded-full mr-2"></div>
                        <span class="text-xs text-gray-700">RTT</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
