@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Nouvelle Mission de Transport</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('charroi.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Chauffeur</label>
                        <select name="chauffeur_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            <option value="">Sélectionner un chauffeur</option>
                            @foreach($chauffeurs as $chauffeur)
                                <option value="{{ $chauffeur->id }}">
                                    {{ $chauffeur->nom_complet }} ({{ $chauffeur->matricule }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Véhicule</label>
                        <select name="vehicule_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            <option value="">Sélectionner un véhicule</option>
                            @foreach($vehicules as $vehicule)
                                <option value="{{ $vehicule->id }}">
                                    {{ $vehicule->marque }} {{ $vehicule->modele }} ({{ $vehicule->immatriculation }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Motif</label>
                    <textarea name="motif" rows="3" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Itinéraire</label>
                    <textarea name="itineraire" rows="2" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date et heure de départ</label>
                        <input type="datetime-local" name="date_heure_depart" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kilométrage de départ</label>
                        <input type="number" name="kilometrage_depart" min="0" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('charroi.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                        Annuler
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Créer la mission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection