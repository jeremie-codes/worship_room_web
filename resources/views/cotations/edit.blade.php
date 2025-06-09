@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Modifier la Cotation</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('cotations.update', $cotation) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Agent</label>
                        <p class="mt-2 text-gray-900">{{ $cotation->agent->nom_complet }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Année</label>
                        <p class="mt-2 text-gray-900">{{ $cotation->annee }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Note Compétence (sur 20)</label>
                        <input type="number" name="note_competence" min="0" max="20" 
                            value="{{ $cotation->note_competence }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Note Performance (sur 20)</label>
                        <input type="number" name="note_performance" min="0" max="20"
                            value="{{ $cotation->note_performance }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Note Comportement (sur 20)</label>
                        <input type="number" name="note_comportement" min="0" max="20"
                            value="{{ $cotation->note_comportement }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Observations</label>
                    <textarea name="observations" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">{{ $cotation->observations }}</textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('cotations.show', $cotation) }}" 
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
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