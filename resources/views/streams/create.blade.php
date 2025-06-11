@extends('layouts.app')

@section('title', 'Créer un Live - Worship Room')
@section('page-title', 'Créer un Nouveau Live')
@section('page-subtitle', 'Partagez votre message avec votre communauté')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-gray-800 rounded-xl p-8">
        <form method="POST" action="{{ route('broadcaster.streams.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Titre du Live *</label>
                <input type="text" id="title" name="title" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                       placeholder="Ex: Service de Culte du Dimanche Matin" value="{{ old('title') }}">
                @error('title')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                          placeholder="Décrivez votre session de culte...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cover Image -->
            <div>
                <label for="cover_image" class="block text-sm font-medium text-gray-300 mb-2">Image de Couverture</label>
                <div class="flex items-center justify-center w-full">
                    <label for="cover_image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-600 border-dashed rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-600 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class='bx bx-cloud-upload text-gray-400 text-3xl mb-2'></i>
                            <p class="mb-2 text-sm text-gray-400">
                                <span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez
                            </p>
                            <p class="text-xs text-gray-500">PNG, JPG ou JPEG (MAX. 2MB)</p>
                        </div>
                        <input id="cover_image" name="cover_image" type="file" class="hidden" accept="image/*">
                    </label>
                </div>
                @error('cover_image')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stream Type -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-4">Type de Diffusion</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="relative">
                        <input type="radio" name="is_immediate" value="1" checked class="peer sr-only">
                        <div class="bg-gray-700 border-2 border-gray-600 rounded-lg p-6 cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-all">
                            <div class="text-center">
                                <i class='bx bx-broadcast text-3xl text-gray-400 peer-checked:text-primary-400 mb-3'></i>
                                <h3 class="text-lg font-semibold text-white mb-2">Démarrer Maintenant</h3>
                                <p class="text-sm text-gray-400">Commencer la diffusion immédiatement</p>
                            </div>
                        </div>
                    </label>
                    
                    <label class="relative">
                        <input type="radio" name="is_immediate" value="0" class="peer sr-only">
                        <div class="bg-gray-700 border-2 border-gray-600 rounded-lg p-6 cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-all">
                            <div class="text-center">
                                <i class='bx bx-calendar text-3xl text-gray-400 peer-checked:text-primary-400 mb-3'></i>
                                <h3 class="text-lg font-semibold text-white mb-2">Programmer</h3>
                                <p class="text-sm text-gray-400">Planifier pour plus tard</p>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Scheduled Date/Time -->
            <div id="scheduled-section" class="hidden">
                <label for="scheduled_at" class="block text-sm font-medium text-gray-300 mb-2">Date et Heure Programmées</label>
                <input type="datetime-local" id="scheduled_at" name="scheduled_at"
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                       min="{{ now()->format('Y-m-d\TH:i') }}" value="{{ old('scheduled_at') }}">
                @error('scheduled_at')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stream Settings -->
            <div class="bg-gray-700/50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Paramètres de Diffusion</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-white font-medium">Commentaires en Direct</h4>
                            <p class="text-gray-400 text-sm">Permettre aux spectateurs de commenter pendant le live</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="allow_comments" value="1" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-500"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-white font-medium">Dons Activés</h4>
                            <p class="text-gray-400 text-sm">Permettre aux spectateurs de faire des dons pendant le live</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="allow_donations" value="1" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-500"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-700">
                <a href="{{ route('broadcaster.streams') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-semibold transition-colors">
                    <i class='bx bx-arrow-back mr-2'></i>Annuler
                </a>
                
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white rounded-lg font-semibold transition-all transform hover:scale-105">
                    <i class='bx bx-broadcast mr-2'></i>Créer le Live
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Toggle scheduled section based on stream type
    document.querySelectorAll('input[name="is_immediate"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const scheduledSection = document.getElementById('scheduled-section');
            const scheduledInput = document.getElementById('scheduled_at');
            
            if (this.value === '0') {
                scheduledSection.classList.remove('hidden');
                scheduledInput.required = true;
            } else {
                scheduledSection.classList.add('hidden');
                scheduledInput.required = false;
                scheduledInput.value = '';
            }
        });
    });

    // Preview cover image
    document.getElementById('cover_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // You can add image preview functionality here
                console.log('Image selected:', file.name);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection