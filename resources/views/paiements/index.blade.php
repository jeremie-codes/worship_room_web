@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Paiements</h1>
            <p class="text-gray-600">{{ $mois }}/{{ $annee }}</p>
        </div>
        
        <!-- Filtres -->
        <div>
            <form action="{{ route('paiements.index') }}" method="GET" class="flex space-x-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Année</label>
                    <select name="annee" onchange="this.form.submit()"
                        class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        @for($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ $annee == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mois</label>
                    <select name="mois" onchange="this.form.submit()"
                        class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $mois == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En préparation</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ $stats['en_preparation'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Validés</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['valides'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Payés</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['payes'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Montant Total</h3>
            <p class="text-2xl font-bold text-green-600">{{ number_format($stats['montant_total'], 0, ',', ' ') }} FCFA</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="mb-8 flex space-x-4">
        <a href="{{ route('paiements.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Nouveau Paiement
        </a>
        <button type="button" onclick="document.getElementById('masse-modal').classList.remove('hidden')"
            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
            Génération en Masse
        </button>
    </div>

    <!-- Liste des paiements -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salaire Base</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net à Payer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($paiements as $paiement)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $paiement->reference }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $paiement->agent->nom_complet }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $paiement->agent->service->nom }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($paiement->salaire_base, 0, ',', ' ') }} FCFA</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($paiement->net_a_payer, 0, ',', ' ') }} FCFA</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($paiement->status === 'paye') bg-green-100 text-green-800
                            @elseif($paiement->status === 'valide') bg-blue-100 text-blue-800
                            @elseif($paiement->status === 'annule') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $paiement->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('paiements.show', $paiement) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            Voir
                        </a>
                        @if($paiement->status === 'en_preparation')
                            <a href="{{ route('paiements.edit', $paiement) }}" class="text-green-600 hover:text-green-900">
                                Modifier
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $paiements->links() }}
        </div>
    </div>

    <!-- Modal Génération en Masse -->
    <div id="masse-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Génération en Masse</h3>
                <form action="{{ route('paiements.generer-masse') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Année</label>
                        <select name="annee" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            @for($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ $annee == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Mois</label>
                        <select name="mois" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $mois == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Service (optionnel)</label>
                        <select name="service_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            <option value="">Tous les services</option>
                            @foreach(\App\Models\Service::orderBy('nom')->get() as $service)
                                <option value="{{ $service->id }}">{{ $service->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('masse-modal').classList.add('hidden')"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Générer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection