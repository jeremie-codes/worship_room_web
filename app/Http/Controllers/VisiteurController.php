<?php

namespace App\Http\Controllers;

use App\Models\Visiteur;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisiteurController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', today());
        $type = $request->get('type');
        $service_id = $request->get('service_id');
        $status = $request->get('status');

        $stats = [
            'total_jour' => Visiteur::whereDate('heure_arrivee', $date)->count(),
            'en_visite' => Visiteur::whereDate('heure_arrivee', $date)->where('status', 'en_visite')->count(),
            'entrepreneurs' => Visiteur::whereDate('heure_arrivee', $date)->where('type', 'entrepreneur')->count(),
            'visiteurs' => Visiteur::whereDate('heure_arrivee', $date)->where('type', 'visiteur')->count(),
            'avec_vehicule' => Visiteur::whereDate('heure_arrivee', $date)->where('vehicule', true)->count(),
        ];

        $query = Visiteur::with(['service', 'user'])
            ->whereDate('heure_arrivee', $date);

        if ($type) {
            $query->where('type', $type);
        }
        if ($service_id) {
            $query->where('service_id', $service_id);
        }
        if ($status) {
            $query->where('status', $status);
        }

        $visiteurs = $query->orderBy('heure_arrivee', 'desc')->paginate(20);
        $services = Service::orderBy('nom')->get();

        // Visiteurs actuellement en visite
        $visiteursEnCours = Visiteur::with(['service'])
            ->where('status', 'en_visite')
            ->whereNull('heure_depart')
            ->orderBy('heure_arrivee')
            ->get();

        return view('visiteurs.index', compact(
            'visiteurs', 
            'stats', 
            'services', 
            'visiteursEnCours',
            'date', 
            'type', 
            'service_id', 
            'status'
        ));
    }

    public function create()
    {
        $services = Service::orderBy('nom')->get();
        return view('visiteurs.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'type' => 'required|in:entrepreneur,visiteur',
            'entreprise' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'piece_identite' => 'nullable|string|max:255',
            'numero_piece' => 'nullable|string|max:255',
            'motif' => 'required|string',
            'service_id' => 'nullable|exists:services,id',
            'destination' => 'nullable|string|max:255',
            'heure_arrivee' => 'required|date',
            'observations' => 'nullable|string',
            'vehicule' => 'boolean',
            'immatriculation_vehicule' => 'nullable|string|max:255',
            'accompagnants' => 'nullable|array',
            'accompagnants.*.nom' => 'required|string|max:255',
            'accompagnants.*.prenom' => 'nullable|string|max:255',
            'accompagnants.*.piece_identite' => 'nullable|string|max:255',
        ]);

        // Nettoyer les accompagnants vides
        if (isset($validated['accompagnants'])) {
            $validated['accompagnants'] = array_filter($validated['accompagnants'], function($accompagnant) {
                return !empty($accompagnant['nom']);
            });
        }

        $visiteur = new Visiteur($validated);
        $visiteur->user_id = Auth::id();
        $visiteur->badge_numero = Visiteur::genererNumeroBadge();
        $visiteur->save();

        return redirect()->route('visiteurs.show', $visiteur)
            ->with('success', 'Visiteur enregistré avec succès. Badge N° ' . $visiteur->badge_numero);
    }

    public function show(Visiteur $visiteur)
    {
        return view('visiteurs.show', compact('visiteur'));
    }

    public function edit(Visiteur $visiteur)
    {
        $services = Service::orderBy('nom')->get();
        return view('visiteurs.edit', compact('visiteur', 'services'));
    }

    public function update(Request $request, Visiteur $visiteur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'type' => 'required|in:entrepreneur,visiteur',
            'entreprise' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'piece_identite' => 'nullable|string|max:255',
            'numero_piece' => 'nullable|string|max:255',
            'motif' => 'required|string',
            'service_id' => 'nullable|exists:services,id',
            'destination' => 'nullable|string|max:255',
            'heure_arrivee' => 'required|date',
            'heure_depart' => 'nullable|date|after:heure_arrivee',
            'observations' => 'nullable|string',
            'status' => 'required|in:en_visite,parti,refuse',
            'vehicule' => 'boolean',
            'immatriculation_vehicule' => 'nullable|string|max:255',
            'accompagnants' => 'nullable|array',
            'accompagnants.*.nom' => 'required|string|max:255',
            'accompagnants.*.prenom' => 'nullable|string|max:255',
            'accompagnants.*.piece_identite' => 'nullable|string|max:255',
        ]);

        // Nettoyer les accompagnants vides
        if (isset($validated['accompagnants'])) {
            $validated['accompagnants'] = array_filter($validated['accompagnants'], function($accompagnant) {
                return !empty($accompagnant['nom']);
            });
        }

        $visiteur->update($validated);

        return redirect()->route('visiteurs.show', $visiteur)
            ->with('success', 'Visiteur mis à jour avec succès.');
    }

    public function marquerSortie(Visiteur $visiteur)
    {
        if ($visiteur->status !== 'en_visite') {
            return back()->with('error', 'Ce visiteur n\'est plus en visite.');
        }

        $visiteur->marquerSortie();

        return redirect()->route('visiteurs.show', $visiteur)
            ->with('success', 'Sortie enregistrée avec succès.');
    }

    public function destroy(Visiteur $visiteur)
    {
        $visiteur->delete();

        return redirect()->route('visiteurs.index')
            ->with('success', 'Visiteur supprimé avec succès.');
    }

    public function recherche(Request $request)
    {
        $query = $request->get('q');
        $dateDebut = $request->get('date_debut');
        $dateFin = $request->get('date_fin');

        $visiteurs = Visiteur::with(['service', 'user'])
            ->where(function($q) use ($query) {
                $q->where('nom', 'like', "%{$query}%")
                  ->orWhere('prenom', 'like', "%{$query}%")
                  ->orWhere('entreprise', 'like', "%{$query}%")
                  ->orWhere('telephone', 'like', "%{$query}%")
                  ->orWhere('badge_numero', 'like', "%{$query}%")
                  ->orWhere('numero_piece', 'like', "%{$query}%");
            });

        if ($dateDebut) {
            $visiteurs->whereDate('heure_arrivee', '>=', $dateDebut);
        }
        if ($dateFin) {
            $visiteurs->whereDate('heure_arrivee', '<=', $dateFin);
        }

        $visiteurs = $visiteurs->orderBy('heure_arrivee', 'desc')->paginate(20);

        return view('visiteurs.recherche', compact('visiteurs', 'query', 'dateDebut', 'dateFin'));
    }

    public function rapport(Request $request)
    {
        $dateDebut = $request->get('date_debut', today()->startOfMonth());
        $dateFin = $request->get('date_fin', today());

        $stats = [
            'total' => Visiteur::whereBetween('heure_arrivee', [$dateDebut, $dateFin])->count(),
            'entrepreneurs' => Visiteur::whereBetween('heure_arrivee', [$dateDebut, $dateFin])
                ->where('type', 'entrepreneur')->count(),
            'visiteurs' => Visiteur::whereBetween('heure_arrivee', [$dateDebut, $dateFin])
                ->where('type', 'visiteur')->count(),
            'avec_vehicule' => Visiteur::whereBetween('heure_arrivee', [$dateDebut, $dateFin])
                ->where('vehicule', true)->count(),
            'duree_moyenne' => $this->calculerDureeMoyenne($dateDebut, $dateFin),
        ];

        // Statistiques par service
        $statsByService = Service::withCount([
            'visiteurs' => function($query) use ($dateDebut, $dateFin) {
                $query->whereBetween('heure_arrivee', [$dateDebut, $dateFin]);
            }
        ])->having('visiteurs_count', '>', 0)
          ->orderBy('visiteurs_count', 'desc')
          ->get();

        // Statistiques par jour
        $statsByDay = Visiteur::whereBetween('heure_arrivee', [$dateDebut, $dateFin])
            ->selectRaw('DATE(heure_arrivee) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('visiteurs.rapport', compact(
            'stats', 
            'statsByService', 
            'statsByDay',
            'dateDebut', 
            'dateFin'
        ));
    }

    private function calculerDureeMoyenne($dateDebut, $dateFin): ?string
    {
        $visiteurs = Visiteur::whereBetween('heure_arrivee', [$dateDebut, $dateFin])
            ->whereNotNull('heure_depart')
            ->get();

        if ($visiteurs->isEmpty()) {
            return null;
        }

        $totalMinutes = 0;
        foreach ($visiteurs as $visiteur) {
            $totalMinutes += $visiteur->heure_arrivee->diffInMinutes($visiteur->heure_depart);
        }

        $moyenneMinutes = $totalMinutes / $visiteurs->count();
        $heures = floor($moyenneMinutes / 60);
        $minutes = $moyenneMinutes % 60;

        return $heures > 0 ? $heures . 'h ' . round($minutes) . 'min' : round($minutes) . 'min';
    }

    public function badge(Visiteur $visiteur)
    {
        return view('visiteurs.badge', compact('visiteur'));
    }
}