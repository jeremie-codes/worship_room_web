<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\User;
use App\Models\ElementSalaire;
use App\Models\GrilleSalaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        $annee = $request->get('annee', date('Y'));
        $mois = $request->get('mois', date('n'));

        $stats = [
            'total' => Paiement::where('annee', $annee)->where('mois', $mois)->count(),
            'en_preparation' => Paiement::where('annee', $annee)->where('mois', $mois)->where('status', 'en_preparation')->count(),
            'valides' => Paiement::where('annee', $annee)->where('mois', $mois)->where('status', 'valide')->count(),
            'payes' => Paiement::where('annee', $annee)->where('mois', $mois)->where('status', 'paye')->count(),
            'montant_total' => Paiement::where('annee', $annee)->where('mois', $mois)->where('status', 'paye')->sum('net_a_payer'),
        ];

        $paiements = Paiement::with(['agent', 'user'])
            ->where('annee', $annee)
            ->where('mois', $mois)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('paiements.index', compact('paiements', 'stats', 'annee', 'mois'));
    }

    public function create()
    {
        $agents = User::where('status', 'actif')->orderBy('name')->get();
        $elements = ElementSalaire::orderBy('type')->orderBy('nom')->get();
        $grilles = GrilleSalaire::where('actif', true)->orderBy('grade')->orderBy('echelon')->get();

        return view('paiements.create', compact('agents', 'elements', 'grilles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:users,id',
            'annee' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'mois' => 'required|integer|min:1|max:12',
            'salaire_base' => 'required|numeric|min:0',
            'primes' => 'nullable|numeric|min:0',
            'heures_supplementaires' => 'nullable|numeric|min:0',
            'indemnites' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'retenues_fiscales' => 'nullable|numeric|min:0',
            'cotisations_sociales' => 'nullable|numeric|min:0',
            'avances' => 'nullable|numeric|min:0',
            'observations' => 'nullable|string',
        ]);

        // Vérifier si un paiement existe déjà pour cet agent ce mois
        if (Paiement::where('agent_id', $validated['agent_id'])
            ->where('annee', $validated['annee'])
            ->where('mois', $validated['mois'])
            ->exists()) {
            return back()->with('error', 'Un paiement existe déjà pour cet agent ce mois.');
        }

        $paiement = new Paiement($validated);
        $paiement->user_id = Auth::id();
        $paiement->reference = Paiement::genererReference();
        $paiement->net_a_payer = $paiement->calculerNetAPayer();
        $paiement->save();

        return redirect()->route('paiements.show', $paiement)
            ->with('success', 'Paiement créé avec succès.');
    }

    public function show(Paiement $paiement)
    {
        return view('paiements.show', compact('paiement'));
    }

    public function edit(Paiement $paiement)
    {
        if ($paiement->status !== 'en_preparation') {
            return back()->with('error', 'Seuls les paiements en préparation peuvent être modifiés.');
        }

        $agents = User::where('status', 'actif')->orderBy('name')->get();
        $elements = ElementSalaire::orderBy('type')->orderBy('nom')->get();

        return view('paiements.edit', compact('paiement', 'agents', 'elements'));
    }

    public function update(Request $request, Paiement $paiement)
    {
        if ($paiement->status !== 'en_preparation') {
            return back()->with('error', 'Seuls les paiements en préparation peuvent être modifiés.');
        }

        $validated = $request->validate([
            'salaire_base' => 'required|numeric|min:0',
            'primes' => 'nullable|numeric|min:0',
            'heures_supplementaires' => 'nullable|numeric|min:0',
            'indemnites' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'retenues_fiscales' => 'nullable|numeric|min:0',
            'cotisations_sociales' => 'nullable|numeric|min:0',
            'avances' => 'nullable|numeric|min:0',
            'observations' => 'nullable|string',
        ]);

        $paiement->update($validated);
        $paiement->net_a_payer = $paiement->calculerNetAPayer();
        $paiement->save();

        return redirect()->route('paiements.show', $paiement)
            ->with('success', 'Paiement mis à jour avec succès.');
    }

    public function valider(Paiement $paiement)
    {
        if ($paiement->status !== 'en_preparation') {
            return back()->with('error', 'Ce paiement ne peut pas être validé.');
        }

        $paiement->update(['status' => 'valide']);

        return redirect()->route('paiements.show', $paiement)
            ->with('success', 'Paiement validé avec succès.');
    }

    public function payer(Request $request, Paiement $paiement)
    {
        if ($paiement->status !== 'valide') {
            return back()->with('error', 'Seuls les paiements validés peuvent être payés.');
        }

        $validated = $request->validate([
            'mode_paiement' => 'required|in:virement,especes,cheque',
            'date_paiement' => 'required|date',
        ]);

        $paiement->update([
            'status' => 'paye',
            'mode_paiement' => $validated['mode_paiement'],
            'date_paiement' => $validated['date_paiement'],
        ]);

        return redirect()->route('paiements.show', $paiement)
            ->with('success', 'Paiement effectué avec succès.');
    }

    public function annuler(Paiement $paiement)
    {
        if (!in_array($paiement->status, ['en_preparation', 'valide'])) {
            return back()->with('error', 'Ce paiement ne peut pas être annulé.');
        }

        $paiement->update(['status' => 'annule']);

        return redirect()->route('paiements.show', $paiement)
            ->with('success', 'Paiement annulé.');
    }

    public function bulletinPaie(Paiement $paiement)
    {
        if ($paiement->status !== 'paye') {
            return back()->with('error', 'Le bulletin de paie ne peut être généré que pour les paiements effectués.');
        }

        return view('paiements.bulletin', compact('paiement'));
    }

    public function genererPaiementsMasse(Request $request)
    {
        $validated = $request->validate([
            'annee' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'mois' => 'required|integer|min:1|max:12',
            'service_id' => 'nullable|exists:services,id',
        ]);

        $query = User::where('status', 'actif');

        if ($validated['service_id']) {
            $query->where('service_id', $validated['service_id']);
        }

        $agents = $query->get();
        $paiementsCreated = 0;

        foreach ($agents as $agent) {
            // Vérifier si un paiement existe déjà
            if (Paiement::where('agent_id', $agent->id)
                ->where('annee', $validated['annee'])
                ->where('mois', $validated['mois'])
                ->exists()) {
                continue;
            }

            // Récupérer le salaire de base depuis la grille (si disponible)
            $salaireBase = GrilleSalaire::getSalaireBase($agent->grade ?? '', $agent->echelon ?? '') ?? 0;

            // Créer le paiement
            Paiement::create([
                'agent_id' => $agent->id,
                'user_id' => Auth::id(),
                'reference' => Paiement::genererReference(),
                'annee' => $validated['annee'],
                'mois' => $validated['mois'],
                'salaire_base' => $salaireBase,
                'net_a_payer' => $salaireBase,
            ]);

            $paiementsCreated++;
        }

        return redirect()->route('paiements.index', [
            'annee' => $validated['annee'],
            'mois' => $validated['mois']
        ])->with('success', "$paiementsCreated paiements créés avec succès.");
    }
}
