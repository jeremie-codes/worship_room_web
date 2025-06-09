<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Vehicule::count(),
            'bon_etat' => Vehicule::where('etat', 'bon_etat')->count(),
            'en_panne' => Vehicule::where('etat', 'en_panne')->count(),
            'en_entretien' => Vehicule::where('etat', 'en_entretien')->count(),
            'a_declasser' => Vehicule::where('etat', 'a_declasser')->count(),
        ];

        $vehicules = Vehicule::orderBy('immatriculation')->paginate(20);

        return view('charroi.vehicules.index', compact('vehicules', 'stats'));
    }

    public function create()
    {
        return view('charroi.vehicules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'immatriculation' => 'required|string|max:255|unique:vehicules',
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'annee' => 'required|integer|min:1900|max:' . date('Y'),
            'etat' => 'required|in:bon_etat,en_panne,en_entretien,a_declasser',
            'observations' => 'nullable|string',
        ]);

        Vehicule::create($validated);

        return redirect()->route('charroi.vehicules.index')
            ->with('success', 'Véhicule ajouté avec succès.');
    }

    public function edit(Vehicule $vehicule)
    {
        return view('charroi.vehicules.edit', compact('vehicule'));
    }

    public function update(Request $request, Vehicule $vehicule)
    {
        $validated = $request->validate([
            'immatriculation' => 'required|string|max:255|unique:vehicules,immatriculation,' . $vehicule->id,
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'annee' => 'required|integer|min:1900|max:' . date('Y'),
            'etat' => 'required|in:bon_etat,en_panne,en_entretien,a_declasser',
            'observations' => 'nullable|string',
        ]);

        $vehicule->update($validated);

        return redirect()->route('charroi.vehicules.index')
            ->with('success', 'Véhicule mis à jour avec succès.');
    }

    public function destroy(Vehicule $vehicule)
    {
        if ($vehicule->missions()->exists()) {
            return back()->with('error', 'Ce véhicule ne peut pas être supprimé car il est lié à des missions.');
        }

        $vehicule->delete();

        return redirect()->route('charroi.vehicules.index')
            ->with('success', 'Véhicule supprimé avec succès.');
    }
}