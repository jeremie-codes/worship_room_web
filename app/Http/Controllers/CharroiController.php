```php
<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Chauffeur;
use App\Models\MissionVehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharroiController extends Controller
{
    public function index()
    {
        $stats = [
            'vehicules_total' => Vehicule::count(),
            'vehicules_disponibles' => Vehicule::where('etat', 'bon_etat')->count(),
            'chauffeurs_total' => Chauffeur::count(),
            'chauffeurs_disponibles' => Chauffeur::where('status', 'disponible')->count(),
            'missions_en_cours' => MissionVehicule::whereIn('status', ['en_attente', 'approuve', 'en_cours'])->count(),
            'missions_terminees' => MissionVehicule::where('status', 'termine')->count(),
        ];

        $missions = MissionVehicule::with(['user', 'chauffeur', 'vehicule'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('charroi.index', compact('missions', 'stats'));
    }

    public function create()
    {
        $vehicules = Vehicule::where('etat', 'bon_etat')->get();
        $chauffeurs = Chauffeur::where('status', 'disponible')->get();
        return view('charroi.create', compact('vehicules', 'chauffeurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'chauffeur_id' => 'required|exists:chauffeurs,id',
            'vehicule_id' => 'required|exists:vehicules,id',
            'motif' => 'required|string',
            'itineraire' => 'required|string',
            'date_heure_depart' => 'required|date|after:now',
            'kilometrage_depart' => 'required|integer|min:0',
        ]);

        $chauffeur = Chauffeur::find($validated['chauffeur_id']);
        $vehicule = Vehicule::find($validated['vehicule_id']);

        if (!$chauffeur->estDisponible()) {
            return back()->with('error', 'Ce chauffeur n\'est pas disponible.');
        }

        if (!$vehicule->estDisponible()) {
            return back()->with('error', 'Ce véhicule n\'est pas disponible.');
        }

        if (!$chauffeur->permisEstValide()) {
            return back()->with('error', 'Le permis de ce chauffeur est expiré.');
        }

        $mission = MissionVehicule::create([
            ...$validated,
            'reference' => MissionVehicule::genererReference(),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('charroi.show', $mission)
            ->with('success', 'Mission créée avec succès.');
    }

    public function show(MissionVehicule $mission)
    {
        return view('charroi.show', compact('mission'));
    }

    public function approuver(MissionVehicule $mission)
    {
        if ($mission->status !== 'en_attente') {
            return back()->with('error', 'Cette mission ne peut plus être approuvée.');
        }

        $mission->update(['status' => 'approuve']);

        return redirect()->route('charroi.show', $mission)
            ->with('success', 'Mission approuvée avec succès.');
    }

    public function demarrer(MissionVehicule $mission)
    {
        if ($mission->status !== 'approuve') {
            return back()->with('error', 'Cette mission ne peut pas être démarrée.');
        }

        $mission->update(['status' => 'en_cours']);
        $mission->chauffeur->update(['status' => 'en_mission']);

        return redirect()->route('charroi.show', $mission)
            ->with('success', 'Mission démarrée.');
    }

    public function terminer(Request $request, MissionVehicule $mission)
    {
        if (!$mission->estTerminable()) {
            return back()->with('error', 'Cette mission ne peut pas être terminée.');
        }

        $validated = $request->validate([
            'kilometrage_retour' => 'required|integer|min:' . $mission->kilometrage_depart,
            'observations' => 'nullable|string',
        ]);

        $mission->update([
            ...$validated,
            'status' => 'termine',
            'date_heure_retour' => now(),
        ]);

        $mission->chauffeur->update(['status' => 'disponible']);

        return redirect()->route('charroi.show', $mission)
            ->with('success', 'Mission terminée.');
    }

    public function annuler(Request $request, MissionVehicule $mission)
    {
        if (!$mission->estAnnulable()) {
            return back()->with('error', 'Cette mission ne peut pas être annulée.');
        }

        $validated = $request->validate([
            'observations' => 'required|string',
        ]);

        $mission->update([
            'status' => 'annule',
            'observations' => $validated['observations'],
        ]);

        if ($mission->status === 'en_cours') {
            $mission->chauffeur->update(['status' => 'disponible']);
        }

        return redirect()->route('charroi.show', $mission)
            ->with('success', 'Mission annulée.');
    }
}
```