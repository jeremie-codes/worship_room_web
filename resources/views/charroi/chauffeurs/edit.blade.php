@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Modifier le Chauffeur</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('charroi.chauffeurs.update', $chauffeur) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Matricule</label>
                        <input type="text" name="matricule" value="{{ old('matricule', $chauffeur->matricule) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone', $chauffeur->telephone) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" name="nom" value="{{ old('nom', $chauffeur->nom) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom', $chauffeur->prenom) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Numéro de permis</label>
                        <input type="text" name="numero_permis" value="{{ old('numero_permis', $chauffeur->numero_permis) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date d'expiration du permis</label>
                        <input type="date" name="date_expiration_permis" 
                            value="{{ old('date_expiration_permis', $chauffeur->date_expiration_permis->format('Y-m-d')) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        <option value="disponible" {{ $chauffeur->status === 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="en_mission" {{ $chauffeur->status === 'en_mission' ? 'selected' : '' }}>En mission</option>
                        <option value="indisponible" {{ $chauffeur->status === 'indisponible' ? 'selected' : '' }}>Indisponible</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Observations</label>
                    <textarea name="observations" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">{{ old('observations', $chauffeur->observations) }}</textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('charroi.chauffeurs.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
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