@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Enregistrement d'un Visiteur</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('visiteurs.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Informations personnelles -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Informations Personnelles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom *</label>
                            <input type="text" name="nom" value="{{ old('nom') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Prénom</label>
                            <input type="text" name="prenom" value="{{ old('prenom') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type *</label>
                            <select name="type" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                                <option value="visiteur" {{ old('type') === 'visiteur' ? 'selected' : '' }}>Visiteur</option>
                                <option value="entrepreneur" {{ old('type') === 'entrepreneur' ? 'selected' : '' }}>Entrepreneur</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Entreprise/Organisation</label>
                            <input type="text" name="entreprise" value="{{ old('entreprise') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="text" name="telephone" value="{{ old('telephone') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type de Pièce d'Identité</label>
                            <select name="piece_identite"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                                <option value="">Sélectionner</option>
                                <option value="cni" {{ old('piece_identite') === 'cni' ? 'selected' : '' }}>CNI</option>
                                <option value="passeport" {{ old('piece_identite') === 'passeport' ? 'selected' : '' }}>Passeport</option>
                                <option value="permis" {{ old('piece_identite') === 'permis' ? 'selected' : '' }}>Permis de conduire</option>
                                <option value="autre" {{ old('piece_identite') === 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Numéro de Pièce</label>
                            <input type="text" name="numero_piece" value="{{ old('numero_piece') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                        </div>
                    </div>
                </div>

                <!-- Motif et destination -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Motif et Destination</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Direction/Service</label>
                            <select name="service_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                                <option value="">Sélectionner un service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Destination (Personne/Bureau)</label>
                            <input type="text" name="destination" value="{{ old('destination') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Motif de la visite *</label>
                        <textarea name="motif" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">{{ old('motif') }}</textarea>
                    </div>
                </div>

                <!-- Heure et véhicule -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Informations de Visite</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Heure d'arrivée *</label>
                            <input type="datetime-local" name="heure_arrivee" value="{{ old('heure_arrivee', now()->format('Y-m-d\TH:i')) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                        </div>
                        <div>
                            <label class="flex items-center mt-6">
                                <input type="checkbox" name="vehicule" value="1" {{ old('vehicule') ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" id="vehicule-checkbox">
                                <span class="ml-2 text-sm text-gray-700">Visiteur avec véhicule</span>
                            </label>
                        </div>
                    </div>

                    <div id="vehicule-info" class="mt-4 {{ old('vehicule') ? '' : 'hidden' }}">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Immatriculation du véhicule</label>
                            <input type="text" name="immatriculation_vehicule" value="{{ old('immatriculation_vehicule') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                        </div>
                    </div>
                </div>

                <!-- Accompagnants -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Accompagnants</h3>
                    <div id="accompagnants-container">
                        @if(old('accompagnants'))
                            @foreach(old('accompagnants') as $index => $accompagnant)
                                <div class="accompagnant-row grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                                        <input type="text" name="accompagnants[{{ $index }}][nom]" value="{{ $accompagnant['nom'] ?? '' }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Prénom</label>
                                        <input type="text" name="accompagnants[{{ $index }}][prenom]" value="{{ $accompagnant['prenom'] ?? '' }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Pièce d'identité</label>
                                        <input type="text" name="accompagnants[{{ $index }}][piece_identite]" value="{{ $accompagnant['piece_identite'] ?? '' }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" onclick="supprimerAccompagnant(this)" class="bg-red-600 text-white px-3 py-2 rounded-md hover:bg-red-700">
                                            Supprimer
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" onclick="ajouterAccompagnant()" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Ajouter un Accompagnant
                    </button>
                </div>

                <!-- Observations -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Observations</label>
                    <textarea name="observations" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">{{ old('observations') }}</textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('visiteurs.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                        Annuler
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let accompagnantIndex = {{ old('accompagnants') ? count(old('accompagnants')) : 0 }};

// Gestion du véhicule
document.getElementById('vehicule-checkbox').addEventListener('change', function() {
    const vehiculeInfo = document.getElementById('vehicule-info');
    if (this.checked) {
        vehiculeInfo.classList.remove('hidden');
    } else {
        vehiculeInfo.classList.add('hidden');
    }
});

// Gestion des accompagnants
function ajouterAccompagnant() {
    const container = document.getElementById('accompagnants-container');
    const html = `
        <div class="accompagnant-row grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="accompagnants[${accompagnantIndex}][nom]"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text" name="accompagnants[${accompagnantIndex}][prenom]"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Pièce d'identité</label>
                <input type="text" name="accompagnants[${accompagnantIndex}][piece_identite]"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 p-4">
            </div>
            <div class="flex items-end">
                <button type="button" onclick="supprimerAccompagnant(this)" class="bg-red-600 text-white px-3 py-2 rounded-md hover:bg-red-700">
                    Supprimer
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    accompagnantIndex++;
}

function supprimerAccompagnant(button) {
    button.closest('.accompagnant-row').remove();
}
</script>
@endsection
