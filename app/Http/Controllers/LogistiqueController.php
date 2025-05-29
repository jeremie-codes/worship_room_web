<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Demande;
use Illuminate\Http\Request;

class LogistiqueController extends Controller
{
    public function index()
    {
        $produits = Produit::paginate(10);
        return view('logistique.index', compact('produits'));
    }

    public function storeDemande(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'service_id' => 'required|exists:services,id',
            'commentaire' => 'nullable',
            'urgence' => 'required|in:basse,normale,haute,critique',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'en_attente';

        Demande::create($validated);

        return redirect()->route('logistique.index')
            ->with('success', 'Demande soumise avec succès.');
    }

    public function updateProduit(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'reference' => 'required|unique:produits,reference,' . $produit->id,
            'categorie_id' => 'required|exists:categories,id',
            'quantite' => 'required|integer|min:0',
            'seuil_alerte' => 'required|integer|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
            'description' => 'nullable',
        ]);

        $produit->update($validated);

        return redirect()->route('logistique.index')
            ->with('success', 'Produit mis à jour avec succès.');
    }
}