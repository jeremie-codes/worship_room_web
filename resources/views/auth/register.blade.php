@extends('layouts.app')

@section('title', 'Inscription - Worship Room')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-video text-white text-2xl'></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-white">Rejoindre Worship Room</h2>
            <p class="mt-2 text-gray-400">Créez votre compte pour commencer votre voyage de culte</p>
        </div>

        <div class="bg-gray-800 rounded-xl shadow-xl p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nom Complet</label>
                    <input id="name" name="name" type="text" required
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                           placeholder="Entrez votre nom complet" value="{{ old('name') }}">
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Adresse Email</label>
                    <input id="email" name="email" type="email" required
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                           placeholder="Entrez votre email" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Numéro de Téléphone (Optionnel)</label>
                    <input id="phone" name="phone" type="text"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                           placeholder="Entrez votre numéro de téléphone" value="{{ old('phone') }}">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-300 mb-2">Je veux rejoindre en tant que</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative">
                            <input type="radio" name="role" value="spectator" checked
                                   class="peer sr-only">
                            <div class="bg-gray-700 border-2 border-gray-600 rounded-lg p-4 cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-all">
                                <div class="text-center">
                                    <i class='bx bx-user text-2xl text-gray-400 peer-checked:text-primary-400 mb-2'></i>
                                    <div class="text-sm font-medium text-gray-300">Spectateur</div>
                                    <div class="text-xs text-gray-500">Regarder et interagir</div>
                                </div>
                            </div>
                        </label>

                        <label class="relative">
                            <input type="radio" name="role" value="broadcaster"
                                   class="peer sr-only">
                            <div class="bg-gray-700 border-2 border-gray-600 rounded-lg p-4 cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-all">
                                <div class="text-center">
                                    <i class='bx bx-broadcast text-2xl text-gray-400 peer-checked:text-primary-400 mb-2'></i>
                                    <div class="text-sm font-medium text-gray-300">Diffuseur</div>
                                    <div class="text-xs text-gray-500">Diffuser du contenu</div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('role')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Mot de Passe</label>
                    <input id="password" name="password" type="password" required
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                           placeholder="Créez un mot de passe fort">
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirmer le Mot de Passe</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                           placeholder="Confirmez votre mot de passe">
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold py-3 px-6 rounded-lg transition-all transform hover:scale-105 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                    <i class='bx bx-user-plus mr-2'></i>Créer un Compte
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-400">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}" class="text-primary-400 hover:text-primary-300 font-semibold">
                        Connectez-vous ici
                    </a>
                </p>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">
                <i class='bx bx-arrow-back mr-1'></i>Retour à l'Accueil
            </a>
        </div>
    </div>
</div>
@endsection
