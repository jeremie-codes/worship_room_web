<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Article::count(),
            'en_alerte' => Article::whereRaw('quantite <= seuil_alerte')->count(),
            'en_rupture' => Article::where('quantite', 0)->count(),
        ];

        $articles = Article::orderBy('nom')->paginate(20);

        return view('logistique.articles.index', compact('articles', 'stats'));
    }

    public function create()
    {
        return view('logistique.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:articles',
            'categorie' => 'required|string|max:255',
            'quantite' => 'required|integer|min:0',
            'seuil_alerte' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Article::create($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function edit(Article $article)
    {
        return view('logistique.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:articles,code,' . $article->id,
            'categorie' => 'required|string|max:255',
            'quantite' => 'required|integer|min:0',
            'seuil_alerte' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $article->update($validated);

        return redirect()->route('articles.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Article $article)
    {
        if ($article->demandes()->exists()) {
            return back()->with('error', 'Cet article ne peut pas être supprimé car il est lié à des demandes.');
        }

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article supprimé avec succès.');
    }
}