@extends('layout.app')

@section('content')
    <div class="container mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Planning des Congés</h1>
            <p class="text-gray-600">Gestion automatisée des congés basée sur l'ancienneté</p>
        </div>

        <!-- Statistiques générales -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
            <x-card class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-600 bg-opacity-30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium">Congés en cours</h2>
                        <p class="text-3xl font-bold">8</p>
                        <p class="text-xs text-blue-100">Cette semaine</p>
                    </div>
                </div>
            </x-card>

            <x-card class="bg-gradient-to-r from-green-500 to-green-600 text-white">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-600 bg-opacity-30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium">Congés validés</h2>
                        <p class="text-3xl font-bold">42</p>
                        <p class="text-xs text-green-100">Cette année</p>
                    </div>
                </div>
            </x-card>

            <x-card class="bg-gradient-to-r from-amber-500 to-amber-600 text-white">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-amber-600 bg-opacity-30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium">Congés à venir</h2>
                        <p class="text-3xl font-bold">15</p>
                        <p class="text-xs text-amber-100">Prochains 30 jours</p>
                    </div>
                </div>
            </x-card>

            <x-card class="bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-600 bg-opacity-30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium">Employés éligibles</h2>
                        <p class="text-3xl font-bold">89</p>
                        <p class="text-xs text-purple-100">Sur 127 employés</p>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Filtres -->
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
                        <input type="text" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Nom, ID...">
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
                    <label for="anciennete" class="block text-sm font-medium text-gray-700 mb-1">Ancienneté</label>
                    <select id="anciennete" name="anciennete" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Toute ancienneté</option>
                        <option value="1">1 an et plus</option>
                        <option value="2">2 ans et plus</option>
                        <option value="5">5 ans et plus</option>
                        <option value="10">10 ans et plus</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <x-button type="submit" class="bg-gray-600 hover:bg-gray-700 h-10">
                        Filtrer
                    </x-button>
                </div>
            </div>
        </div>

        <!-- Tableau des congés -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <x-table>
                    <x-slot name="header">
                        <x-table.heading>Employé</x-table.heading>
                        <x-table.heading>Date d'engagement</x-table.heading>
                        <x-table.heading>Éligibilité congés</x-table.heading>
                        <x-table.heading>Droits acquis</x-table.heading>
                        <x-table.heading>Congés pris</x-table.heading>
                        <x-table.heading>Solde</x-table.heading>
                        <x-table.heading>Actions</x-table.heading>
                    </x-slot>

                    <x-table.row>
                        <x-table.cell>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/1.jpg" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="font-medium text-gray-900">Thomas Bernard</div>
                                    <div class="text-gray-500 text-xs">Production</div>
                                </div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>12/03/2018</x-table.cell>
                        <x-table.cell>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Éligible
                            </span>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="text-sm">
                                <div class="font-medium">5 exercices</div>
                                <div class="text-gray-500">(150 jours + 10 jours)</div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="text-sm">
                                <div class="font-medium">3 exercices</div>
                                <div class="text-gray-500">(90 jours)</div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="text-sm">
                                <div class="font-medium">2 exercices</div>
                                <div class="text-gray-500">(70 jours)</div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex space-x-2">
                                <x-button type="button" class="bg-blue-600 hover:bg-blue-700" onclick="openModal('modal-attribuer-conge')">
                                    Attribuer congé
                                </x-button>
                                <button class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </x-table.cell>
                    </x-table.row>

                    <x-table.row>
                        <x-table.cell>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/women/2.jpg" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="font-medium text-gray-900">Marie Lambert</div>
                                    <div class="text-gray-500 text-xs">Comptabilité</div>
                                </div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>05/06/2023</x-table.cell>
                        <x-table.cell>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">
                                Dans 3 mois
                            </span>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="text-sm">
                                <div class="font-medium">0 exercice</div>
                                <div class="text-gray-500">(0 jour)</div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="text-sm">
                                <div class="font-medium">0 exercice</div>
                                <div class="text-gray-500">(0 jour)</div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="text-sm">
                                <div class="font-medium">0 exercice</div>
                                <div class="text-gray-500">(0 jour)</div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex space-x-2">
                                <x-button type="button" class="bg-gray-400 cursor-not-allowed" disabled>
                                    Attribuer congé
                                </x-button>
                                <button class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                        </x-table.cell>
                    </x-table.row>

                    <x-table.row>
                        <x-table.cell>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/3.jpg" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="font-medium text-gray-900">Jean Dubois</div>
                                    <div class="text-gray-500 text-xs">Informatique</div>
                                </div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>20/01/2020</x-table.cell>
                        <x-table.cell>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Éligible
                            </span>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="text-sm">
                                <div class="font-medium">3 exercices</div>
                                <div class="text-gray-500">(90 jours + 6 jours)</div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="text-sm">
                                <div class="font-medium">2 exercices</div>
                                <div class="text-gray-500">(60 jours)</div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="text-sm">
                                <div class="font-medium">1 exercice</div>
                                <div class="text-gray-500">(36 jours)</div>
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex space-x-2">
                                <x-button type="button" class="bg-blue-600 hover:bg-blue-700" onclick="openModal('modal-attribuer-conge')">
                                    Attribuer congé
                                </x-button>
                                <button class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
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
                                Affichage de <span class="font-medium">1</span> à <span class="font-medium">3</span> sur <span class="font-medium">127</span> employés
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
                                <a href="#" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">42</a>
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

    <!-- Modal Attribuer Congé -->
    <x-modal id="modal-attribuer-conge" title="Attribuer un congé">
        <form action="{{ route('conges.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="employe_id" class="block text-sm font-medium text-gray-700 mb-1">Employé</label>
                    <select id="employe_id" name="employe_id" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="1">Thomas Bernard - Production</option>
                        <option value="2">Jean Dubois - Informatique</option>
                    </select>
                </div>

                <div>
                    <label for="type_conge" class="block text-sm font-medium text-gray-700 mb-1">Type de congé</label>
                    <select id="type_conge" name="type_conge" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="annuel">Congé annuel</option>
                        <option value="exceptionnel">Congé exceptionnel</option>
                        <option value="maladie">Congé maladie</option>
                        <option value="maternite">Congé maternité</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                        <input type="date" id="date_debut" name="date_debut" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                        <input type="date" id="date_fin" name="date_fin" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="date_reprise" class="block text-sm font-medium text-gray-700 mb-1">Date de reprise</label>
                        <input type="date" id="date_reprise" name="date_reprise" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>

                <div>
                    <label for="motif" class="block text-sm font-medium text-gray-700 mb-1">Motif</label>
                    <textarea id="motif" name="motif" rows="3" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <!-- Informations sur le solde -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Informations sur le solde</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Solde disponible :</p>
                            <p class="font-medium">2 exercices (70 jours)</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Durée sélectionnée :</p>
                            <p class="font-medium">-- jours</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Solde après congé :</p>
                            <p class="font-medium">-- jours</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Statut :</p>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Solde suffisant
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <x-button type="button" class="bg-gray-500 hover:bg-gray-600" onclick="closeModal('modal-attribuer-conge')">
                    Annuler
                </x-button>
                <x-button type="submit" class="bg-blue-600 hover:bg-blue-700">
                    Attribuer le congé
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

        // Calcul automatique de la date de reprise
        document.getElementById('date_fin').addEventListener('change', function() {
            const dateFin = new Date(this.value);
            const dateReprise = new Date(dateFin);
            dateReprise.setDate(dateReprise.getDate() + 1);

            document.getElementById('date_reprise').value = dateReprise.toISOString().split('T')[0];
        });

        // Calcul de la durée du congé
        function calculateDuration() {
            const dateDebut = new Date(document.getElementById('date_debut').value);
            const dateFin = new Date(document.getElementById('date_fin').value);

            if (dateDebut && dateFin) {
                const diffTime = Math.abs(dateFin - dateDebut);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                return diffDays;
            }
            return 0;
        }

        // Mise à jour des informations de solde
        function updateSoldeInfo() {
            const duree = calculateDuration();
            const soldeInitial = 70; // À remplacer par la valeur réelle
            const soldeRestant = soldeInitial - duree;

            document.querySelector('[class*="Durée sélectionnée"] .font-medium').textContent = `${duree} jours`;
            document.querySelector('[class*="Solde après congé"] .font-medium').textContent = `${soldeRestant} jours`;

            const statutElement = document.querySelector('[class*="Statut"] span');
            if (soldeRestant >= 0) {
                statutElement.className = 'px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800';
                statutElement.textContent = 'Solde suffisant';
            } else {
                statutElement.className = 'px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800';
                statutElement.textContent = 'Solde insuffisant';
            }
        }

        // Écouteurs d'événements pour les dates
        document.getElementById('date_debut').addEventListener('change', updateSoldeInfo);
        document.getElementById('date_fin').addEventListener('change', updateSoldeInfo);
    </script>
@endsection
