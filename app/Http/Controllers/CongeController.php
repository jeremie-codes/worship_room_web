<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CongeController extends Controller
{
    public function index()
    {
        $stats = [
            'en_cours' => Conge::where('status', 'en_attente')->count(),
            'valides' => Conge::where('status', 'valide_drh')->count(),
            'eligibles' => User::where('status', 'actif')
                ->whereRaw('DATEDIFF(NOW(), date_engagement) >= 365')
                ->count(),
            'non_eligibles' => User::where('status', 'actif')
                ->whereRaw('DATEDIFF(NOW(), date_engagement) < 365')
                ->count(),
        ];

        $conges = Conge::with(['agent', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('conges.index', compact('conges', 'stats'));
    }

    public function create()
    {
        $agents = User::where('status', 'actif')->orderBy('name')->get();
        return view('conges.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:users,id',
            'date_debut' => 'required|date|after:today',
            'date_fin' => 'required|date|after:date_debut',
            'motif' => 'required|string',
        ]);

        $agent = User::find($validated['agent_id']);

        if (!$agent->isActif()) {
            return back()->with('error', 'Seuls les agents actifs peuvent demander un congé.');
        }

        if (!$agent->anciennete >= 1) {
            return back()->with('error', "L'agent n'est pas encore éligible aux congés.");
        }

        $duree = \Carbon\Carbon::parse($validated['date_debut'])
            ->diffInDays($validated['date_fin']) + 1;

        $conge = Conge::create([
            ...$validated,
            'user_id' => Auth::id(),
            'duree' => $duree,
        ]);

        return redirect()->route('conges.show', $conge)
            ->with('success', 'Demande de congé enregistrée avec succès.');
    }

    public function show(Conge $conge)
    {
        return view('conges.show', compact('conge'));
    }

    public function approuverDirecteur(Request $request, Conge $conge)
    {
        $validated = $request->validate([
            'commentaire_directeur' => 'required|string',
        ]);

        $conge->update([
            'status' => 'approuve_directeur',
            'commentaire_directeur' => $validated['commentaire_directeur'],
        ]);

        return redirect()->route('conges.show', $conge)
            ->with('success', 'Demande de congé approuvée par le directeur.');
    }

    public function traiterRH(Request $request, Conge $conge)
    {
        $validated = $request->validate([
            'commentaire_rh' => 'required|string',
        ]);

        $conge->update([
            'status' => 'traite_rh',
            'commentaire_rh' => $validated['commentaire_rh'],
        ]);

        return redirect()->route('conges.show', $conge)
            ->with('success', 'Demande de congé traitée par les RH.');
    }

    public function validerDRH(Request $request, Conge $conge)
    {
        $validated = $request->validate([
            'commentaire_drh' => 'required|string',
        ]);

        $conge->update([
            'status' => 'valide_drh',
            'commentaire_drh' => $validated['commentaire_drh'],
        ]);

        return redirect()->route('conges.show', $conge)
            ->with('success', 'Demande de congé validée par le DRH.');
    }

    public function refuser(Request $request, Conge $conge)
    {
        $validated = $request->validate([
            'commentaire' => 'required|string',
        ]);

        $conge->update([
            'status' => 'refuse',
            'commentaire_' . strtolower($request->user()->role ?? 'user') => $validated['commentaire'],
        ]);

        return redirect()->route('conges.show', $conge)
            ->with('success', 'Demande de congé refusée.');
    }
}
