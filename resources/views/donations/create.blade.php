@extends('layouts.app')

@section('title', 'Faire un Don - Worship Room')
@section('page-title', 'Faire un Don')
@section('page-subtitle', 'Soutenez ' . $broadcaster->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-gray-800 rounded-xl p-8">
        <!-- Broadcaster Info -->
        <div class="flex items-center gap-4 mb-8 p-6 bg-gray-700/50 rounded-lg">
            <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center">
                @if($broadcaster->avatar)
                    <img src="{{ Storage::url($broadcaster->avatar) }}" alt="{{ $broadcaster->name }}" class="w-full h-full rounded-full object-cover">
                @else
                    <i class='bx bx-user text-white text-2xl'></i>
                @endif
            </div>
            <div>
                <h3 class="text-xl font-semibold text-white">{{ $broadcaster->name }}</h3>
                <p class="text-gray-400">{{ number_format($broadcaster->subscribers_count) }} abonnés</p>
                @if($stream)
                    <p class="text-primary-400 text-sm">
                        <i class='bx bx-broadcast mr-1'></i>{{ $stream->title }}
                    </p>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('donations.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="broadcaster_id" value="{{ $broadcaster->id }}">
            @if($stream)
                <input type="hidden" name="stream_id" value="{{ $stream->id }}">
            @endif

            <!-- Amount Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-4">Montant du Don</label>
                <div class="grid grid-cols-3 gap-3 mb-4">
                    @foreach([5, 10, 25, 50, 100, 200] as $amount)
                        <label class="relative">
                            <input type="radio" name="amount" value="{{ $amount }}" class="peer sr-only" {{ $amount == 25 ? 'checked' : '' }}>
                            <div class="bg-gray-700 border-2 border-gray-600 rounded-lg p-4 cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-all text-center">
                                <span class="text-white font-semibold">${{ $amount }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                
                <!-- Custom Amount -->
                <div>
                    <label class="relative">
                        <input type="radio" name="amount" value="custom" class="peer sr-only">
                        <div class="bg-gray-700 border-2 border-gray-600 rounded-lg p-4 cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-all">
                            <div class="flex items-center gap-3">
                                <span class="text-white font-semibold">Montant personnalisé:</span>
                                <input type="number" id="custom_amount" min="1" max="10000" step="0.01" 
                                       class="flex-1 px-3 py-2 bg-gray-600 border border-gray-500 rounded text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="0.00">
                            </div>
                        </div>
                    </label>
                </div>
                @error('amount')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Payment Method -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-4">Méthode de Paiement</label>
                <div class="space-y-3">
                    <label class="relative">
                        <input type="radio" name="payment_method" value="card" checked class="peer sr-only">
                        <div class="bg-gray-700 border-2 border-gray-600 rounded-lg p-4 cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-all">
                            <div class="flex items-center gap-3">
                                <i class='bx bx-credit-card text-2xl text-gray-400 peer-checked:text-primary-400'></i>
                                <div>
                                    <h4 class="text-white font-semibold">Carte Bancaire</h4>
                                    <p class="text-gray-400 text-sm">Visa, Mastercard, American Express</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="relative">
                        <input type="radio" name="payment_method" value="mobile_money" class="peer sr-only">
                        <div class="bg-gray-700 border-2 border-gray-600 rounded-lg p-4 cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-all">
                            <div class="flex items-center gap-3">
                                <i class='bx bx-mobile text-2xl text-gray-400 peer-checked:text-primary-400'></i>
                                <div>
                                    <h4 class="text-white font-semibold">Mobile Money</h4>
                                    <p class="text-gray-400 text-sm">Orange Money, MTN Money, Moov Money</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                @error('payment_method')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Message -->
            <div>
                <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Message (Optionnel)</label>
                <textarea id="message" name="message" rows="3"
                          class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                          placeholder="Laissez un message d'encouragement...">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Anonymous Option -->
            <div class="flex items-center">
                <input id="is_anonymous" name="is_anonymous" type="checkbox" value="1"
                       class="h-4 w-4 text-primary-500 bg-gray-700 border-gray-600 rounded focus:ring-primary-500 focus:ring-2">
                <label for="is_anonymous" class="ml-2 text-sm text-gray-300">
                    Faire un don anonyme
                </label>
            </div>

            <!-- Summary -->
            <div class="bg-gray-700/50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Résumé du Don</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Bénéficiaire:</span>
                        <span class="text-white">{{ $broadcaster->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Montant:</span>
                        <span class="text-white font-semibold" id="amount-display">$25.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Frais de traitement:</span>
                        <span class="text-white">$0.00</span>
                    </div>
                    <hr class="border-gray-600">
                    <div class="flex justify-between text-lg">
                        <span class="text-white font-semibold">Total:</span>
                        <span class="text-primary-400 font-bold" id="total-display">$25.00</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-700">
                <a href="{{ url()->previous() }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-semibold transition-colors">
                    <i class='bx bx-arrow-back mr-2'></i>Retour
                </a>
                
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-accent-500 to-accent-600 hover:from-accent-600 hover:to-accent-700 text-white rounded-lg font-semibold transition-all transform hover:scale-105">
                    <i class='bx bx-heart mr-2'></i>Faire le Don
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Update amount display
    function updateAmountDisplay() {
        const selectedAmount = document.querySelector('input[name="amount"]:checked');
        const customAmount = document.getElementById('custom_amount');
        const amountDisplay = document.getElementById('amount-display');
        const totalDisplay = document.getElementById('total-display');
        
        let amount = 0;
        
        if (selectedAmount.value === 'custom') {
            amount = parseFloat(customAmount.value) || 0;
        } else {
            amount = parseFloat(selectedAmount.value);
        }
        
        amountDisplay.textContent = '$' + amount.toFixed(2);
        totalDisplay.textContent = '$' + amount.toFixed(2);
    }

    // Add event listeners
    document.querySelectorAll('input[name="amount"]').forEach(radio => {
        radio.addEventListener('change', updateAmountDisplay);
    });

    document.getElementById('custom_amount').addEventListener('input', function() {
        document.querySelector('input[name="amount"][value="custom"]').checked = true;
        updateAmountDisplay();
    });

    // Handle form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        const selectedAmount = document.querySelector('input[name="amount"]:checked');
        const customAmount = document.getElementById('custom_amount');
        
        if (selectedAmount.value === 'custom') {
            const customValue = parseFloat(customAmount.value);
            if (!customValue || customValue < 1) {
                e.preventDefault();
                alert('Veuillez entrer un montant valide');
                return;
            }
            // Create hidden input for custom amount
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'amount';
            hiddenInput.value = customValue;
            this.appendChild(hiddenInput);
        }
    });
</script>
@endpush
@endsection