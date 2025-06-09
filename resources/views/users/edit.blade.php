@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Modifier l'Utilisateur</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Matricule</label>
                        <input type="text" name="matricule" value="{{ old('matricule', $user->matricule) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nouveau mot de passe (optionnel)</label>
                        <input type="password" name="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
                        <input type="date" name="date_naissance" value="{{ old('date_naissance', $user->date_naissance?->format('Y-m-d')) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lieu de naissance</label>
                        <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance', $user->lieu_naissance) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sexe</label>
                        <select name="sexe" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                            <option value="">Sélectionner</option>
                            <option value="M" {{ old('sexe', $user->sexe) === 'M' ? 'selected' : '' }}>Masculin</option>
                            <option value="F" {{ old('sexe', $user->sexe) === 'F' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date d'engagement</label>
                        <input type="date" name="date_engagement" value="{{ old('date_engagement', $user->date_engagement?->format('Y-m-d')) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                            <option value="actif" {{ old('status', $user->status) === 'actif' ? 'selected' : '' }}>Actif</option>
                            <option value="retraite" {{ old('status', $user->status) === 'retraite' ? 'selected' : '' }}>Retraité</option>
                            <option value="malade" {{ old('status', $user->status) === 'malade' ? 'selected' : '' }}>Malade</option>
                            <option value="demission" {{ old('status', $user->status) === 'demission' ? 'selected' : '' }}>Démission</option>
                            <option value="revoque" {{ old('status', $user->status) === 'revoque' ? 'selected' : '' }}>Révoqué</option>
                            <option value="disponibilite" {{ old('status', $user->status) === 'disponibilite' ? 'selected' : '' }}>Disponibilité</option>
                            <option value="detachement" {{ old('status', $user->status) === 'detachement' ? 'selected' : '' }}>Détachement</option>
                            <option value="mutation" {{ old('status', $user->status) === 'mutation' ? 'selected' : '' }}>Mutation</option>
                            <option value="reintegration" {{ old('status', $user->status) === 'reintegration' ? 'selected' : '' }}>Réintégration</option>
                            <option value="mission" {{ old('status', $user->status) === 'mission' ? 'selected' : '' }}>Mission</option>
                            <option value="decede" {{ old('status', $user->status) === 'decede' ? 'selected' : '' }}>Décédé</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Service</label>
                        <select name="service_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                            <option value="">Sélectionner un service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id', $user->service_id) == $service->id ? 'selected' : '' }}>
                                    {{ $service->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Adresse</label>
                        <input type="text" name="adresse" value="{{ old('adresse', $user->adresse) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Observations</label>
                    <textarea name="observations" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">{{ old('observations', $user->observations) }}</textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('users.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
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
