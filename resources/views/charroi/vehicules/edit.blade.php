@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Modifier le Véhicule</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('charroi.vehicules.update', $vehicule) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Immatriculation</label>
                        <input type="text" name="immatriculation" value="{{ old('immatriculation', $vehicule->immatriculation) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Année</label>
                        <input type="number" name="annee" value="{{ old('annee', $vehicule->annee) }}" min="1900" max="{{ date('Y') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Marque</label>
                        <input type="text" name="marque" value="{{ old('marque', $vehicule->marque) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Modèle</label>
                        <input type="text" name="modele" value="{{ old('modele', $vehicule->modele) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">État</label>
                    <select name="etat" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        <option value="bon_etat" {{ $vehicule->etat === 'bon_etat' ? 'selected' : '' }}>Bon état</option>
                        <option value="en_panne" {{ $vehicule->etat === 'en_panne' ? 'selected' : '' }}>En panne</option>
                        <option value="en_entretien" {{ $vehicule->etat === 'en_entretien' ? 'selected' : '' }}>En entretien</option>
                        <option value="a_declasser" {{ $vehicule->etat === 'a_declasser' ? 'selected' : '' }}>À déclasser</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Observations</label>
                    <textarea name="observations" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">{{ old('observations', $vehicule->observations) }}</textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('charroi.vehicules.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                        Annuler
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection