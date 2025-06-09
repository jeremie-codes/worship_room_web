<?php

namespace App\Http\Controllers;

use App\Models\Cotation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CotationController extends Controller
{
    public function index()
    {
        $annee = request('annee', date('Y'));

        $stats = [
            'total' => Cotation::where('annee', $annee)->count(),
            'en_cours' => Cotation::where('annee', $annee)->where('status', 'en_cours')->count(),
            'valides' => Cotation::where('annee', $annee)->where('status', 'valide')->count(),
            'refuses' => Cotation::where('annee', $annee)->where('status', 'refuse')->count(),
        ];

        $cotations = Cotation::with(['agent', 'user'])
            ->where('annee', $annee)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('cotations.index', compact('cotations', 'stats', 'annee'));
    }

    public function create()
    {
        $agents = User::where('status', 'actif')->orderBy('name')->get();
        return view('cotations.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:users,id',
            'annee' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'note_competence' => 'required|integer|min:0|max:20',
            'note_performance' => 'required|integer|min:0|max:20',
            'note_comportement' => 'required|integer|min:0|max:20',
            'observations' => 'nullable|string',
        ]);

        // Vérifier si une cotation existe déjà pour cet agent cette année
        if (Cotation::where('agent_id', $validated['agent_id'])
            ->where('annee', $validated['annee'])
            ->exists()) {
            return back()->with('error', 'Une cotation existe déjà pour cet agent cette année.');
        }

        $cotation = new Cotation($validated);
        $cotation->user_id = Auth::id();
        $cotation->note_finale = $cotation->calculerNoteFinal();
        $cotation->save();

        return redirect()->route('cotations.show', $cotation)
            ->with('success', 'Cotation enregistrée avec succès.');
    }

    public function show(Cotation $cotation)
    {
        return view('cotations.show', compact('cotation'));
    }

    public function edit(Cotation $cotation)
    {
        if ($cotation->status !== 'en_cours') {
            return back()->with('error', 'Cette cotation ne peut plus être modifiée.');
        }

        $agents = User::where('status', 'actif')->orderBy('name')->get();
        return view('cotations.edit', compact('cotation', 'agents'));
    }

    public function update(Request $request, Cotation $cotation)
    {
        if ($cotation->status !== 'en_cours') {
            return back()->with('error', 'Cette cotation ne peut plus être modifiée.');
        }

        $validated = $request->validate([
            'note_competence' => 'required|integer|min:0|max:20',
            'note_performance' => 'required|integer|min:0|max:20',
            'note_comportement' => 'required|integer|min:0|max:20',
            'observations' => 'nullable|string',
        ]);

        $cotation->update($validated);
        $cotation->note_finale = $cotation->calculerNoteFinal();
        $cotation->save();

        return redirect()->route('cotations.show', $cotation)
            ->with('success', 'Cotation mise à jour avec succès.');
    }

    public function valider(Request $request, Cotation $cotation)
    {
        if ($cotation->status !== 'en_cours') {
            return back()->with('error', 'Cette cotation ne peut pas être validée.');
        }

        $validated = $request->validate([
            'commentaire_validateur' => 'required|string',
        ]);

        $cotation->update([
            'status' => 'valide',
            'commentaire_validateur' => $validated['commentaire_validateur'],
        ]);

        return redirect()->route('cotations.show', $cotation)
            ->with('success', 'Cotation validée avec succès.');
    }

    public function refuser(Request $request, Cotation $cotation)
    {
        if ($cotation->status !== 'en_cours') {
            return back()->with('error', 'Cette cotation ne peut pas être refusée.');
        }

        $validated = $request->validate([
            'commentaire_validateur' => 'required|string',
        ]);

        $cotation->update([
            'status' => 'refuse',
            'commentaire_validateur' => $validated['commentaire_validateur'],
        ]);

        return redirect()->route('cotations.show', $cotation)
            ->with('success', 'Cotation refusée.');
    }
}
