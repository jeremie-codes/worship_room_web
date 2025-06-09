@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Articles</h1>
        </div>
        <a href="{{ route('articles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Nouvel Article
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">Total Articles</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En Alerte</h3>
            <p class="text-3xl font-bold text-orange-600">{{ $stats['en_alerte'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700">En Rupture</h3>
            <p class="text-3xl font-bold text-red-600">{{ $stats['en_rupture'] }}</p>
        </div>
    </div>

    <!-- Liste des articles -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seuil Alerte</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($articles as $article)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $article->code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $article->nom }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $article->categorie }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $article->quantite }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $article->seuil_alerte }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($article->estEnRupture()) bg-red-100 text-red-800
                            @elseif($article->estEnAlerte()) bg-orange-100 text-orange-800
                            @else bg-green-100 text-green-800
                            @endif">
                            @if($article->estEnRupture()) En rupture
                            @elseif($article->estEnAlerte()) En alerte
                            @else En stock
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('articles.edit', $article) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            Modifier
                        </a>
                        @if(!$article->demandes()->exists())
                            <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                    Supprimer
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection