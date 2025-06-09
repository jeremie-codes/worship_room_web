<?php

namespace App\Http\Controllers;

use App\Models\Chauffeur;
use Illuminate\Http\Request;

class ChauffeurController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Chauffeur::count(),
            'disponibles' => Chauffeur::where('status', 'disponible')->count(),
            'en_mission' => Chauffeur::where('status', 'en_mission')->count(),
            'indisponibles' => Chauffeur::where('status', 'indisponible')->count(),
            'permis_expires' => Chauffeur::whereDate('date_expiration_permis', '<', now())->count(),
        ];

        $chauffeurs = Chauffeur::orderBy('nom')->paginate(20);

        return view('charroi.chauffeurs.index', compact('chauffeurs', 'stats'));
    }

    public function create()
    {
        return view('charroi.chauffeurs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|string|max:255|unique:chauffeurs',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'numero_permis' => 'required|string|max:255|unique:chauffeurs',
            'date_expiration_permis' => 'required|date|after:today',
            'status' => 'required|in:disponible,en_mission,indisponible',
            'observations' => 'nullable|string',
        ]);

        Chauffeur::create($validated);

        return redirect()->route('charroi.chauffeurs.index')
            ->with('success', 'Chauffeur ajouté avec succès.');
    }

    public function edit(Chauffeur $chauffeur)
    {
        return view('charroi.chauffeurs.edit', compact('chauffeur'));
    }

    public function update(Request $request, Chauffeur $chauffeur)
    {
        $validated = $request->validate([
            'matricule' => 'required|string|max:255|unique:chauffeurs,matricule,' . $chauffeur->id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'numero_permis' => 'required|string|max:255|unique:chauffeurs,numero_permis,' . $chauffeur->id,
            'date_expiration_permis' => 'required|date',
            'status' => 'required|in:disponible,en_mission,indisponible',
            'observations' => 'nullable|string',
        ]);

        $chauffeur->update($validated);

        return redirect()->route('charroi.chauffeurs.index')
            ->with('success', 'Chauffeur mis à jour avec succès.');
    }

    public function destroy(Chauffeur $chauffeur)
    {
        if ($chauffeur->missions()->exists()) {
            return back()->with('error', 'Ce chauffeur ne peut pas être supprimé car il est lié à des missions.');
        }

        $chauffeur->delete();

        return redirect()->route('charroi.chauffeurs.index')
            ->with('success', 'Chauffeur supprimé avec succès.');
    }
}