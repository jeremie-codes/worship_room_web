@extends('layouts.app')

@section('title', 'Connexion - Worship Room')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 rounded-2xl flex items-center justify-center">
                    <i class='bx bx-video text-white text-2xl'></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-white">Bon Retour</h2>
            <p class="mt-2 text-gray-400">Connectez-vous pour continuer votre voyage de culte</p>
        </div>

        <div class="bg-gray-800 rounded-xl shadow-xl p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

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
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Mot de Passe</label>
                    <input id="password" name="password" type="password" required
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                           placeholder="Entrez votre mot de passe">
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                               class="h-4 w-4 text-primary-500 bg-gray-700 border-gray-600 rounded focus:ring-primary-500 focus:ring-2">
                        <label for="remember" class="ml-2 text-sm text-gray-300">Se souvenir de moi</label>
                    </div>

                    <a href="#" class="text-sm text-primary-400 hover:text-primary-300">
                        Mot de passe oublié ?
                    </a>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold py-3 px-6 rounded-lg transition-all transform hover:scale-105 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                    <i class='bx bx-log-in mr-2'></i>Se Connecter
                </button>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-gray-800 text-gray-400">Ou continuer avec</span>
                    </div>
                </div>

                <div class="mt-6 space-y-3">
                    <button class="w-full flex items-center justify-center px-4 py-3 border border-gray-600 rounded-lg text-gray-300 bg-gray-700 hover:bg-gray-600 transition-colors">
                        <i class='bx bxl-google mr-2 text-lg'></i>
                        Continuer avec Google
                    </button>

                    <button class="w-full flex items-center justify-center px-4 py-3 border border-gray-600 rounded-lg text-gray-300 bg-gray-700 hover:bg-gray-600 transition-colors">
                        <i class='bx bxl-facebook mr-2 text-lg'></i>
                        Continuer avec Facebook
                    </button>
                </div>
            </div>

            <div class="mt-6 text-center">
                <p class="text-gray-400">
                    Vous n'avez pas de compte ?
                    <a href="{{ route('register') }}" class="text-primary-400 hover:text-primary-300 font-semibold">
                        Inscrivez-vous ici
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
