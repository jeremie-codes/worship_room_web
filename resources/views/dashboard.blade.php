@extends('layouts.app')

@section('page-title', 'Tableau de Bord')
@section('page-description', 'Vue d\'ensemble du système de gestion RH')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Statistiques Rapides -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Présences du jour -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Présences Aujourd'hui</h3>
                    <p class="text-2xl font-bold text-green-600">85%</p>
                    <p class="text-sm text-gray-500">170/200 agents</p>
                </div>
            </div>
        </div>

        <!-- Visiteurs en cours -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-user-friends text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Visiteurs en Cours</h3>
                    <p class="text-2xl font-bold text-blue-600">12</p>
                    <p class="text-sm text-gray-500">Actuellement dans les locaux</p>
                </div>
            </div>
        </div>

        <!-- Missions en cours -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-plane text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Missions en Cours</h3>
                    <p class="text-2xl font-bold text-orange-600">8</p>
                    <p class="text-sm text-gray-500">Agents en déplacement</p>
                </div>
            </div>
        </div>

        <!-- Courriers en attente -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-envelope text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">Courriers en Attente</h3>
                    <p class="text-2xl font-bold text-red-600">15</p>
                    <p class="text-sm text-gray-500">À traiter</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Rapides -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Actions Fréquentes -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions Rapides</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('visiteurs.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <i class="fas fa-user-plus text-blue-600 text-xl mr-3"></i>
                    <div>
                        <p class="font-medium text-gray-800">Nouveau Visiteur</p>
                        <p class="text-sm text-gray-600">Enregistrer un visiteur</p>
                    </div>
                </a>

                <a href="{{ route('presences.index') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <i class="fas fa-clock text-green-600 text-xl mr-3"></i>
                    <div>
                        <p class="font-medium text-gray-800">Présences</p>
                        <p class="text-sm text-gray-600">Gestion quotidienne</p>
                    </div>
                </a>

                <a href="{{ route('courriers.create') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <i class="fas fa-envelope-open text-purple-600 text-xl mr-3"></i>
                    <div>
                        <p class="font-medium text-gray-800">Nouveau Courrier</p>
                        <p class="text-sm text-gray-600">Enregistrer un courrier</p>
                    </div>
                </a>

                <a href="{{ route('charroi.create') }}" class="flex items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <i class="fas fa-car text-orange-600 text-xl mr-3"></i>
                    <div>
                        <p class="font-medium text-gray-800">Mission Transport</p>
                        <p class="text-sm text-gray-600">Demande de véhicule</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Alertes et Notifications -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Alertes et Notifications</h3>
            <div class="space-y-3">
                <div class="flex items-center p-3 bg-red-50 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                    <div>
                        <p class="font-medium text-red-800">5 courriers en retard</p>
                        <p class="text-sm text-red-600">Délai de réponse dépassé</p>
                    </div>
                </div>

                <div class="flex items-center p-3 bg-orange-50 rounded-lg">
                    <i class="fas fa-box text-orange-600 mr-3"></i>
                    <div>
                        <p class="font-medium text-orange-800">3 articles en rupture</p>
                        <p class="text-sm text-orange-600">Stock épuisé</p>
                    </div>
                </div>

                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                    <i class="fas fa-calendar text-blue-600 mr-3"></i>
                    <div>
                        <p class="font-medium text-blue-800">8 demandes de congés</p>
                        <p class="text-sm text-blue-600">En attente de validation</p>
                    </div>
                </div>

                <div class="flex items-center p-3 bg-yellow-50 rounded-lg">
                    <i class="fas fa-id-card text-yellow-600 mr-3"></i>
                    <div>
                        <p class="font-medium text-yellow-800">2 permis expirent bientôt</p>
                        <p class="text-sm text-yellow-600">Chauffeurs à renouveler</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et Statistiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Évolution des présences -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Évolution des Présences (7 derniers jours)</h3>
            <div class="h-64 flex items-end justify-between space-x-2">
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-green-500 rounded-t" style="height: 80%"></div>
                    <span class="text-xs text-gray-600 mt-2">Lun</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-green-500 rounded-t" style="height: 85%"></div>
                    <span class="text-xs text-gray-600 mt-2">Mar</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-green-500 rounded-t" style="height: 90%"></div>
                    <span class="text-xs text-gray-600 mt-2">Mer</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-green-500 rounded-t" style="height: 75%"></div>
                    <span class="text-xs text-gray-600 mt-2">Jeu</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-green-500 rounded-t" style="height: 88%"></div>
                    <span class="text-xs text-gray-600 mt-2">Ven</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-500 rounded-t" style="height: 60%"></div>
                    <span class="text-xs text-gray-600 mt-2">Sam</span>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-8 bg-blue-500 rounded-t" style="height: 40%"></div>
                    <span class="text-xs text-gray-600 mt-2">Dim</span>
                </div>
            </div>
        </div>

        <!-- Répartition des visiteurs -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Visiteurs par Type (Ce mois)</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-orange-500 rounded mr-3"></div>
                        <span class="text-gray-700">Entrepreneurs</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-900 font-medium mr-2">65%</span>
                        <span class="text-gray-600">(156)</span>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-purple-500 rounded mr-3"></div>
                        <span class="text-gray-700">Visiteurs</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-900 font-medium mr-2">35%</span>
                        <span class="text-gray-600">(84)</span>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-orange-500 h-2 rounded-full" style="width: 65%"></div>
                    </div>
                </div>

                <div class="text-center text-sm text-gray-600 mt-4">
                    Total: 240 visiteurs ce mois
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
