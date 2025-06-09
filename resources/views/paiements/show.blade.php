@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Paiement : {{ $paiement->reference }}</h1>
            <a href="{{ route('paiements.index') }}" class="text-blue-600 hover:text-blue-800">
                &larr; Retour à la liste
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Informations de base -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Informations Générales</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Agent</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $paiement->agent->nom_complet }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Matricule</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $paiement->agent->matricule }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Service</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $paiement->agent->service->nom }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Période</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $paiement->periode }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($paiement->status === 'paye') bg-green-100 text-green-800
                                @elseif($paiement->status === 'valide') bg-blue-100 text-blue-800
                                @elseif($paiement->status === 'annule') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $paiement->status)) }}
                            </span>
                        </dd>
                    </div>
                    @if($paiement->date_paiement)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date de Paiement</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $paiement->date_paiement->format('d/m/Y') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            <!-- Détail du calcul -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Détail du Calcul</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Gains -->
                    <div>
                        <h3 class="text-lg font-medium text-green-700 mb-3">Gains</h3>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Salaire de Base</dt>
                                <dd class="text-sm font-medium">{{ number_format($paiement->salaire_base, 0, ',', ' ') }} FCFA</dd>
                            </div>
                            @if($paiement->primes > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Primes</dt>
                                <dd class="text-sm font-medium">{{ number_format($paiement->primes, 0, ',', ' ') }} FCFA</dd>
                            </div>
                            @endif
                            @if($paiement->heures_supplementaires > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Heures Supplémentaires</dt>
                                <dd class="text-sm font-medium">{{ number_format($paiement->heures_supplementaires, 0, ',', ' ') }} FCFA</dd>
                            </div>
                            @endif
                            @if($paiement->indemnites > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Indemnités</dt>
                                <dd class="text-sm font-medium">{{ number_format($paiement->indemnites, 0, ',', ' ') }} FCFA</dd>
                            </div>
                            @endif
                            <div class="flex justify-between border-t pt-2">
                                <dt class="text-sm font-semibold text-gray-900">Total Brut</dt>
                                <dd class="text-sm font-semibold text-green-600">{{ number_format($paiement->brut, 0, ',', ' ') }} FCFA</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Déductions -->
                    <div>
                        <h3 class="text-lg font-medium text-red-700 mb-3">Déductions</h3>
                        <dl class="space-y-2">
                            @if($paiement->deductions > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Déductions Diverses</dt>
                                <dd class="text-sm font-medium">{{ number_format($paiement->deductions, 0, ',', ' ') }} FCFA</dd>
                            </div>
                            @endif
                            @if($paiement->retenues_fiscales > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Retenues Fiscales</dt>
                                <dd class="text-sm font-medium">{{ number_format($paiement->retenues_fiscales, 0, ',', ' ') }} FCFA</dd>
                            </div>
                            @endif
                            @if($paiement->cotisations_sociales > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Cotisations Sociales</dt>
                                <dd class="text-sm font-medium">{{ number_format($paiement->cotisations_sociales, 0, ',', ' ') }} FCFA</dd>
                            </div>
                            @endif
                            @if($paiement->avances > 0)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Avances</dt>
                                <dd class="text-sm font-medium">{{ number_format($paiement->avances, 0, ',', ' ') }} FCFA</dd>
                            </div>
                            @endif
                            <div class="flex justify-between border-t pt-2">
                                <dt class="text-sm font-semibold text-gray-900">Total Déductions</dt>
                                <dd class="text-sm font-semibold text-red-600">{{ number_format($paiement->total_deductions, 0, ',', ' ') }} FCFA</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Net à payer -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">Net à Payer</span>
                        <span class="text-2xl font-bold text-blue-600">{{ number_format($paiement->net_a_payer, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            @if($paiement->observations)
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Observations</h2>
                <p class="text-gray-700">{{ $paiement->observations }}</p>
            </div>
            @endif

            <!-- Actions -->
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Actions</h2>
                <div class="flex space-x-4">
                    @if($paiement->status === 'en_preparation')
                        <a href="{{ route('paiements.edit', $paiement) }}" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Modifier
                        </a>
                        <form action="{{ route('paiements.valider', $paiement) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                Valider
                            </button>
                        </form>
                        <form action="{{ route('paiements.annuler', $paiement) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700"
                                onclick="return confirm('Êtes-vous sûr de vouloir annuler ce paiement ?')">
                                Annuler
                            </button>
                        </form>
                    @endif

                    @if($paiement->status === 'valide')
                        <button type="button" onclick="document.getElementById('paiement-modal').classList.remove('hidden')"
                            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Effectuer le Paiement
                        </button>
                        <form action="{{ route('paiements.annuler', $paiement) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700"
                                onclick="return confirm('Êtes-vous sûr de vouloir annuler ce paiement ?')">
                                Annuler
                            </button>
                        </form>
                    @endif

                    @if($paiement->status === 'paye')
                        <a href="{{ route('paiements.bulletin', $paiement) }}" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Bulletin de Paie
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Paiement -->
    <div id="paiement-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Effectuer le Paiement</h3>
                <form action="{{ route('paiements.payer', $paiement) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Mode de Paiement</label>
                        <select name="mode_paiement" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            <option value="virement">Virement bancaire</option>
                            <option value="especes">Espèces</option>
                            <option value="cheque">Chèque</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Date de Paiement</label>
                        <input type="date" name="date_paiement" value="{{ date('Y-m-d') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('paiement-modal').classList.add('hidden')"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                            Annuler
                        </button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Confirmer le Paiement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection