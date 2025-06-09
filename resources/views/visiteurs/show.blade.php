@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Visiteur : {{ $visiteur->nom_complet }}</h1>
            <div class="flex space-x-3">
                <a href="{{ route('visiteurs.index') }}" class="text-blue-600 hover:text-blue-800">
                    &larr; Retour à la liste
                </a>
                @if($visiteur->estEnVisite())
                    <form action="{{ route('visiteurs.marquer-sortie', $visiteur) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                            Marquer la Sortie
                        </button>
                    </form>
                @endif
                <a href="{{ route('visiteurs.badge', $visiteur) }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    Imprimer Badge
                </a>
                <a href="{{ route('visiteurs.edit', $visiteur) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Modifier
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- En-tête avec badge et statut -->
            <div class="p-6 border-b bg-gray-50">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900">{{ $visiteur->nom_complet }}</h2>
                        <div class="mt-2 flex space-x-4">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full
                                @if($visiteur->type === 'entrepreneur') bg-orange-100 text-orange-800
                                @else bg-purple-100 text-purple-800
                                @endif">
                                {{ ucfirst($visiteur->type) }}
                            </span>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full
                                @if($visiteur->status === 'en_visite') bg-green-100 text-green-800
                                @elseif($visiteur->status === 'parti') bg-gray-100 text-gray-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $visiteur->status)) }}
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-mono font-semibold text-blue-600">{{ $visiteur->badge_numero }}</div>
                        <div class="text-sm text-gray-500">Badge N°</div>
                    </div>
                </div>
            </div>

            <!-- Informations personnelles -->
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold mb-4">Informations Personnelles</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($visiteur->entreprise)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Entreprise/Organisation</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $visiteur->entreprise }}</dd>
                    </div>
                    @endif
                    @if($visiteur->telephone)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $visiteur->telephone }}</dd>
                    </div>
                    @endif
                    @if($visiteur->email)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $visiteur->email }}</dd>
                    </div>
                    @endif
                    @if($visiteur->piece_identite)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Pièce d'Identité</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ strtoupper($visiteur->piece_identite) }}
                            @if($visiteur->numero_piece)
                                : {{ $visiteur->numero_piece }}
                            @endif
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>

            <!-- Motif et destination -->
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold mb-4">Motif et Destination</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($visiteur->service)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Direction/Service</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $visiteur->service->nom }}</dd>
                    </div>
                    @endif
                    @if($visiteur->destination)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Destination</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $visiteur->destination }}</dd>
                    </div>
                    @endif
                </dl>
                <div class="mt-4">
                    <dt class="text-sm font-medium text-gray-500">Motif de la visite</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $visiteur->motif }}</dd>
                </div>
            </div>

            <!-- Informations de visite -->
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold mb-4">Informations de Visite</h3>
                <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Heure d'Arrivée</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $visiteur->heure_arrivee->format('d/m/Y H:i') }}</dd>
                    </div>
                    @if($visiteur->heure_depart)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Heure de Départ</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $visiteur->heure_depart->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Durée de la Visite</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $visiteur->duree_visite }}</dd>
                    </div>
                    @else
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Durée Actuelle</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $visiteur->heure_arrivee->diffForHumans(null, true) }}
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>

            <!-- Véhicule -->
            @if($visiteur->vehicule)
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold mb-4">Informations Véhicule</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Véhicule</dt>
                        <dd class="mt-1 text-sm text-gray-900">Oui</dd>
                    </div>
                    @if($visiteur->immatriculation_vehicule)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Immatriculation</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $visiteur->immatriculation_vehicule }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
            @endif

            <!-- Accompagnants -->
            @if($visiteur->accompagnants && count($visiteur->accompagnants) > 0)
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold mb-4">Accompagnants ({{ count($visiteur->accompagnants) }})</h3>
                <div class="space-y-3">
                    @foreach($visiteur->accompagnants as $accompagnant)
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Nom :</span>
                                <span class="text-sm text-gray-900">{{ $accompagnant['nom'] ?? '' }} {{ $accompagnant['prenom'] ?? '' }}</span>
                            </div>
                            @if(!empty($accompagnant['piece_identite']))
                            <div>
                                <span class="text-sm font-medium text-gray-500">Pièce d'identité :</span>
                                <span class="text-sm text-gray-900">{{ $accompagnant['piece_identite'] }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Observations -->
            @if($visiteur->observations)
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold mb-4">Observations</h3>
                <p class="text-gray-700">{{ $visiteur->observations }}</p>
            </div>
            @endif

            <!-- Informations système -->
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4">Informations Système</h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Enregistré par</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $visiteur->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date d'enregistrement</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $visiteur->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    @if($visiteur->updated_at != $visiteur->created_at)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Dernière modification</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $visiteur->updated_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection