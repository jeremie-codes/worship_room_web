@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Nouvelle Demande de Fournitures</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('demandes.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Service</label>
                    <select name="service_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Article</label>
                    <select name="article_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        @foreach($articles as $article)
                            <option value="{{ $article->id }}">
                                {{ $article->nom }} (Stock: {{ $article->quantite }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantité</label>
                    <input type="number" name="quantite" value="{{ old('quantite') }}" min="1" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Niveau d'urgence</label>
                    <select name="niveau_urgence" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        <option value="normal">Normal</option>
                        <option value="urgent">Urgent</option>
                        <option value="tres_urgent">Très Urgent</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Motif</label>
                    <textarea name="motif" rows="3" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">{{ old('motif') }}</textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('demandes.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                        Annuler
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Soumettre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection