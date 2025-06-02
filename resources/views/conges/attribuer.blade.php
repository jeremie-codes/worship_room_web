@extends('layout.app')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Attribution de Congé</h1>
        <p class="text-gray-600">Formulaire d'attribution de congé avec calcul automatique</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulaire d'attribution -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('conges.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="employe_id" class="block text-sm font-medium text-gray-700 mb-1">Employé</label>
                            <select id="employe_id" name="employe_id" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Sélectionnez un employé</option>
                                <option value="1">Thomas Bernard - Production</option>
                                <option value="2">Marie Lambert - Comptabilité</option>
                                <option value="3">Jean Dubois - Informatique</option>
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

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
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
                                <input type="date" id="date_reprise" name="date_reprise" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required readonly>
                            </div>
                        </div>

                        <div>
                            <label for="motif" class="block text-sm font-medium text-gray-700 mb-1">Motif du congé</label>
                            <textarea id="motif" name="motif" rows="3" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-blue-800 mb-2">Calcul automatique</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-blue-600">Durée du congé</p>
                                    <p class="text-lg font-semibold text-blue-900" id="duree_conge">-- jours</p>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-600">Impact sur le solde</p>
                                    <p class="text-lg font-semibold text-blue-900" id="impact_solde">-- exercice(s)</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4">
                            <x-button type="button" class="bg-gray-500 hover:bg-gray-600" onclick="window.history.back()">
                                Annuler
                            </x-button>
                            <x-button type="submit" class="bg-blue-600 hover:bg-blue-700">
                                Attribuer le congé
                            </x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informations sur l'employé -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informations employé</h2>
                <div id="info_employe" class="space-y-4">
                    <div class="text-center text-gray-500 py-8">
                        Sélectionnez un employé pour voir ses informations
                    </div>
                </div>
            </div>

            <!-- Solde de congés -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Solde de congés</h2>
                <div id="solde_conges" class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Congés acquis</span>
                        <span class="font-medium">-- jours</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Congés pris</span>
                        <span class="font-medium">-- jours</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: 0%"></div>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Solde actuel</span>
                        <span class="font-medium">-- jours</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-amber-600 h-2.5 rounded-full" style="width: 0%"></div>
                    </div>

                    <div class="pt-4 mt-4 border-t">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-800">Exercices disponibles</span>
                            <span class="font-medium text-blue-600">-- exercices</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historique récent -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Derniers congés</h2>
                <div id="historique_conges" class="space-y-4">
                    <div class="text-center text-gray-500 py-4">
                        Aucun historique disponible
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Calcul automatique de la date de reprise
    document.getElementById('date_fin').addEventListener('change', function() {
        const dateFin = new Date(this.value);
        const dateReprise = new Date(dateFin);
        dateReprise.setDate(dateReprise.getDate() + 1);

        document.getElementById('date_reprise').value = dateReprise.toISOString().split('T')[0];
        calculateDuration();
    });

    document.getElementById('date_debut').addEventListener('change', calculateDuration);

    // Calcul de la durée du congé
    function calculateDuration() {
        const dateDebut = new Date(document.getElementById('date_debut').value);
        const dateFin = new Date(document.getElementById('date_fin').value);

        if (dateDebut && dateFin) {
            const diffTime = Math.abs(dateFin - dateDebut);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

            document.getElementById('duree_conge').textContent = `${diffDays} jours`;
            document.getElementById('impact_solde').textContent = `${Math.ceil(diffDays / 30)} exercice(s)`;
        }
    }

    // Mise à jour des informations employé
    document.getElementById('employe_id').addEventListener('change', function() {
        const employeId = this.value;
        if (employeId) {
            // Simuler le chargement des données employé
            // Dans un vrai projet, ceci serait une requête AJAX
            const employe = {
                nom: 'Thomas Bernard',
                service: 'Production',
                date_engagement: '12/03/2018',
                anciennete: '5 ans',
                conges_acquis: 150,
                conges_pris: 90,
                solde: 60,
                historique: [
                    {
                        dates: '01/08/2023 - 15/08/2023',
                        type: 'Congé annuel',
                        status: 'Terminé'
                    },
                    {
                        dates: '24/12/2023 - 31/12/2023',
                        type: 'Congé annuel',
                        status: 'À venir'
                    }
                ]
            };

            // Mise à jour des informations
            document.getElementById('info_employe').innerHTML = `
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 h-16 w-16">
                        <img class="h-16 w-16 rounded-full" src="https://randomuser.me/api/portraits/men/1.jpg" alt="">
                    </div>
                    <div class="ml-4">
                        <div class="text-lg font-medium text-gray-900">${employe.nom}</div>
                        <div class="text-sm text-gray-500">${employe.service}</div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Date d'engagement</span>
                        <span class="text-sm font-medium">${employe.date_engagement}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Ancienneté</span>
                        <span class="text-sm font-medium">${employe.anciennete}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Statut</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Actif
                        </span>
                    </div>
                </div>
            `;

            // Mise à jour du solde
            const soldeMax = Math.max(employe.conges_acquis, 150);
            document.getElementById('solde_conges').innerHTML = `
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Congés acquis</span>
                    <span class="font-medium">${employe.conges_acquis} jours</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: ${(employe.conges_acquis / soldeMax) * 100}%"></div>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Congés pris</span>
                    <span class="font-medium">${employe.conges_pris} jours</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-green-600 h-2.5 rounded-full" style="width: ${(employe.conges_pris / soldeMax) * 100}%"></div>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Solde actuel</span>
                    <span class="font-medium">${employe.solde} jours</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-amber-600 h-2.5 rounded-full" style="width: ${(employe.solde / soldeMax) * 100}%"></div>
                </div>

                <div class="pt-4 mt-4 border-t">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-800">Exercices disponibles</span>
                        <span class="font-medium text-blue-600">${Math.floor(employe.solde / 30)} exercices</span>
                    </div>
                </div>
            `;

            // Mise à jour de l'historique
            document.getElementById('historique_conges').innerHTML = `
                <div class="space-y-3">
                    ${employe.historique.map(conge => `
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="text-sm font-medium">${conge.type}</div>
                                <div class="text-xs text-gray-500">${conge.dates}</div>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full ${
                                conge.status === 'Terminé' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'
                            }">
                                ${conge.status}
                            </span>
                        </div>
                    `).join('')}
                </div>
            `;
        } else {
            // Réinitialiser les sections si aucun employé n'est sélectionné
            document.getElementById('info_employe').innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    Sélectionnez un employé pour voir ses informations
                </div>
            `;
            document.getElementById('solde_conges').innerHTML = `
                <div class="text-center text-gray-500 py-4">
                    Aucun solde disponible
                </div>
            `;
            document.getElementById('historique_conges').innerHTML = `
                <div class="text-center text-gray-500 py-4">
                    Aucun historique disponible
                </div>
            `;
        }
    });
</script>
@endsection
