@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
            <div class="flex space-x-3">
                <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-800">
                    &larr; Retour à la liste
                </a>
                <a href="{{ route('users.edit', $user) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Modifier
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Informations personnelles -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Informations Personnelles</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Matricule</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->matricule }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date de naissance</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->date_naissance?->format('d/m/Y') ?? 'Non renseigné' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Lieu de naissance</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->lieu_naissance ?? 'Non renseigné' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Sexe</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $user->sexe === 'M' ? 'Masculin' : ($user->sexe === 'F' ? 'Féminin' : 'Non renseigné') }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->telephone ?? 'Non renseigné' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Adresse</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->adresse ?? 'Non renseigné' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date d'engagement</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->date_engagement?->format('d/m/Y') ?? 'Non renseigné' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Informations professionnelles -->
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold mb-4">Informations Professionnelles</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Service</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->service?->nom ?? 'Non assigné' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($user->status === 'actif') bg-green-100 text-green-800
                                @elseif($user->status === 'retraite') bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($user->status) }}
                            </span>
                        </dd>
                    </div>
                    @if($user->date_engagement)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Ancienneté</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $user->date_engagement->diffInYears(now()) }} ans
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>

            <!-- Observations -->
            @if($user->observations)
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Observations</h2>
                <p class="text-gray-700">{{ $user->observations }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
