<?php

namespace App\Http\Controllers;

use App\Models\DemandeFourniture;
use App\Models\Article;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeFournitureController extends Controller
{
    public function index()
    {
        $stats = [
            'en_attente' => DemandeFourniture::where('status', 'en_attente')->count(),
            'approuvees' => DemandeFourniture::where('status', 'approuve')->count(),
            'refusees' => DemandeFourniture::where('status', 'refuse')->count(),
            'livrees' => DemandeFourniture::where('status', 'livre')->count(),
        ];

        $demandes = DemandeFourniture::with(['service', 'user', 'article'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('logistique.demandes.index', compact('demandes', 'stats'));
    }

    public function create()
    {
        $services = Service::orderBy('nom')->get();
        $articles = Article::orderBy('nom')->get();
        return view('logistique.demandes.create', compact('services', 'articles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'article_id' => 'required|exists:articles,id',
            'quantite' => 'required|integer|min:1',
            'niveau_urgence' => 'required|in:normal,urgent,tres_urgent',
            'motif' => 'required|string',
        ]);

        $demande = DemandeFourniture::create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('demandes.show', $demande)
            ->with('success', 'Demande créée avec succès.');
    }

    public function show(DemandeFourniture $demande)
    {
        return view('logistique.demandes.show', compact('demande'));
    }

    public function approuver(Request $request, DemandeFourniture $demande)
    {
        if ($demande->status !== 'en_attente') {
            return back()->with('error', 'Cette demande ne peut plus être approuvée.');
        }

        $validated = $request->validate([
            'commentaire_validateur' => 'required|string',
        ]);

        $demande->update([
            'status' => 'approuve',
            'commentaire_validateur' => $validated['commentaire_validateur'],
        ]);

        return redirect()->route('demandes.show', $demande)
            ->with('success', 'Demande approuvée avec succès.');
    }

    public function refuser(Request $request, DemandeFourniture $demande)
    {
        if ($demande->status !== 'en_attente') {
            return back()->with('error', 'Cette demande ne peut plus être refusée.');
        }

        $validated = $request->validate([
            'commentaire_validateur' => 'required|string',
        ]);

        $demande->update([
            'status' => 'refuse',
            'commentaire_validateur' => $validated['commentaire_validateur'],
        ]);

        return redirect()->route('demandes.show', $demande)
            ->with('success', 'Demande refusée.');
    }

    public function livrer(DemandeFourniture $demande)
    {
        if (!$demande->estLivrable()) {
            return back()->with('error', 'Cette demande ne peut pas être livrée.');
        }

        $article = $demande->article;
        $article->decrement('quantite', $demande->quantite);

        $demande->update([
            'status' => 'livre',
            'date_livraison' => now(),
        ]);

        return redirect()->route('demandes.show', $demande)
            ->with('success', 'Demande livrée avec succès.');
    }
}