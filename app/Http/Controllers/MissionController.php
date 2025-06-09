<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    public function index()
    {
        $stats = [
            'en_preparation' => Mission::where('status', 'en_preparation')->count(),
            'en_cours' => Mission::where('status', 'en_cours')->count(),
            'terminees' => Mission::where('status', 'terminee')->count(),
            'annulees' => Mission::where('status', 'annulee')->count(),
        ];

        $missions = Mission::with(['agent', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('missions.index', compact('missions', 'stats'));
    }

    public function create()
    {
        $agents = User::where('status', 'actif')->orderBy('name')->get();
        return view('missions.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:users,id',
            'lieu' => 'required|string|max:255',
            'objet' => 'required|string',
            'date_debut' => 'required|date|after:today',
            'date_fin' => 'required|date|after:date_debut',
            'frais_mission' => 'required|numeric|min:0',
            'observations' => 'nullable|string',
        ]);

        $duree = \Carbon\Carbon::parse($validated['date_debut'])
            ->diffInDays($validated['date_fin']) + 1;

        $mission = Mission::create([
            ...$validated,
            'reference' => Mission::genererReference(),
            'user_id' => Auth::id(),
            'duree' => $duree,
        ]);

        return redirect()->route('missions.show', $mission)
            ->with('success', 'Mission créée avec succès.');
    }

    public function show(Mission $mission)
    {
        return view('missions.show', compact('mission'));
    }

    public function edit(Mission $mission)
    {
        if ($mission->status !== 'en_preparation') {
            return back()->with('error', 'Seules les missions en préparation peuvent être modifiées.');
        }

        $agents = User::where('status', 'actif')->orderBy('name')->get();
        return view('missions.edit', compact('mission', 'agents'));
    }

    public function update(Request $request, Mission $mission)
    {
        if ($mission->status !== 'en_preparation') {
            return back()->with('error', 'Seules les missions en préparation peuvent être modifiées.');
        }

        $validated = $request->validate([
            'agent_id' => 'required|exists:users,id',
            'lieu' => 'required|string|max:255',
            'objet' => 'required|string',
            'date_debut' => 'required|date|after:today',
            'date_fin' => 'required|date|after:date_debut',
            'frais_mission' => 'required|numeric|min:0',
            'observations' => 'nullable|string',
        ]);

        $duree = \Carbon\Carbon::parse($validated['date_debut'])
            ->diffInDays($validated['date_fin']) + 1;

        $mission->update([
            ...$validated,
            'duree' => $duree,
        ]);

        return redirect()->route('missions.show', $mission)
            ->with('success', 'Mission mise à jour avec succès.');
    }

    public function demarrer(Mission $mission)
    {
        if ($mission->status !== 'en_preparation') {
            return back()->with('error', 'Cette mission ne peut pas être démarrée.');
        }

        $mission->update(['status' => 'en_cours']);

        return redirect()->route('missions.show', $mission)
            ->with('success', 'Mission démarrée.');
    }

    public function terminer(Request $request, Mission $mission)
    {
        if ($mission->status !== 'en_cours') {
            return back()->with('error', 'Cette mission ne peut pas être terminée.');
        }

        $validated = $request->validate([
            'rapport' => 'required|string',
        ]);

        $mission->update([
            'status' => 'terminee',
            'rapport' => $validated['rapport'],
        ]);

        return redirect()->route('missions.show', $mission)
            ->with('success', 'Mission terminée.');
    }

    public function annuler(Request $request, Mission $mission)
    {
        if (!in_array($mission->status, ['en_preparation', 'en_cours'])) {
            return back()->with('error', 'Cette mission ne peut pas être annulée.');
        }

        $validated = $request->validate([
            'motif_annulation' => 'required|string',
        ]);

        $mission->update([
            'status' => 'annulee',
            'observations' => $validated['motif_annulation'],
        ]);

        return redirect()->route('missions.show', $mission)
            ->with('success', 'Mission annulée.');
    }
}
