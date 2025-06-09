<?php

namespace App\Http\Controllers;

use App\Models\Courrier;
use App\Models\User;
use App\Models\Service;
use App\Models\DocumentCourrier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourrierController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type');
        $status = $request->get('status');
        $priorite = $request->get('priorite');
        $service_id = $request->get('service_id');

        $stats = [
            'total' => Courrier::count(),
            'en_attente' => Courrier::where('status', 'en_attente')->count(),
            'en_cours' => Courrier::where('status', 'en_cours_traitement')->count(),
            'traites' => Courrier::where('status', 'traite')->count(),
            'en_retard' => Courrier::whereNotNull('date_limite_reponse')
                ->where('date_limite_reponse', '<', now())
                ->whereNotIn('status', ['traite', 'clos', 'archive'])
                ->count(),
            'urgents' => Courrier::whereIn('priorite', ['urgente', 'tres_urgente'])
                ->whereNotIn('status', ['traite', 'clos', 'archive'])
                ->count(),
        ];

        $query = Courrier::with(['user', 'agentResponsable', 'serviceExpediteur', 'serviceDestinataire']);

        if ($type) {
            $query->where('type', $type);
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($priorite) {
            $query->where('priorite', $priorite);
        }
        if ($service_id) {
            $query->where(function($q) use ($service_id) {
                $q->where('service_expediteur_id', $service_id)
                  ->orWhere('service_destinataire_id', $service_id);
            });
        }

        $courriers = $query->orderBy('created_at', 'desc')->paginate(20);
        $services = Service::orderBy('nom')->get();

        return view('courriers.index', compact('courriers', 'stats', 'services', 'type', 'status', 'priorite', 'service_id'));
    }

    public function create()
    {
        $agents = User::where('status', 'actif')->orderBy('name')->get();
        $services = Service::orderBy('nom')->get();
        return view('courriers.create', compact('agents', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:entrant,sortant,interne',
            'motif' => 'required|in:demande,reponse,notification,convocation,rapport,facture,contrat,correspondance,autre',
            'objet' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expediteur' => 'nullable|string|max:255',
            'destinataire' => 'nullable|string|max:255',
            'service_expediteur_id' => 'nullable|exists:services,id',
            'service_destinataire_id' => 'nullable|exists:services,id',
            'date_courrier' => 'required|date',
            'date_reception' => 'nullable|date',
            'date_envoi' => 'nullable|date',
            'date_limite_reponse' => 'nullable|date|after:date_courrier',
            'priorite' => 'required|in:normale,urgente,tres_urgente',
            'agent_responsable_id' => 'nullable|exists:users,id',
            'repertoire' => 'nullable|string|max:255',
            'numero_chrono' => 'nullable|string|max:255',
            'confidentiel' => 'boolean',
            'observations' => 'nullable|string',
            'documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $courrier = new Courrier($validated);
        $courrier->user_id = Auth::id();
        $courrier->reference = Courrier::genererReference($validated['type']);
        $courrier->save();

        // Traitement des documents
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $file) {
                $nomOriginal = $file->getClientOriginalName();
                $nomFichier = time() . '_' . $index . '_' . $nomOriginal;
                $chemin = $file->storeAs('courriers/' . $courrier->id, $nomFichier, 'public');

                DocumentCourrier::create([
                    'courrier_id' => $courrier->id,
                    'nom_document' => $nomOriginal,
                    'nom_fichier' => $nomFichier,
                    'chemin_fichier' => $chemin,
                    'type_mime' => $file->getMimeType(),
                    'taille_fichier' => $file->getSize(),
                    'type_document' => 'courrier_principal',
                ]);
            }
        }

        // Ajouter le suivi
        $courrier->ajouterSuivi('creation', 'Courrier créé');

        return redirect()->route('courriers.show', $courrier)
            ->with('success', 'Courrier enregistré avec succès.');
    }

    public function show(Courrier $courrier)
    {
        $courrier->load(['documents', 'suivis.user', 'agentResponsable', 'serviceExpediteur', 'serviceDestinataire']);
        return view('courriers.show', compact('courrier'));
    }

    public function edit(Courrier $courrier)
    {
        $agents = User::where('status', 'actif')->orderBy('name')->get();
        $services = Service::orderBy('nom')->get();
        return view('courriers.edit', compact('courrier', 'agents', 'services'));
    }

    public function update(Request $request, Courrier $courrier)
    {
        $donneesAvant = $courrier->toArray();

        $validated = $request->validate([
            'motif' => 'required|in:demande,reponse,notification,convocation,rapport,facture,contrat,correspondance,autre',
            'objet' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expediteur' => 'nullable|string|max:255',
            'destinataire' => 'nullable|string|max:255',
            'service_expediteur_id' => 'nullable|exists:services,id',
            'service_destinataire_id' => 'nullable|exists:services,id',
            'date_courrier' => 'required|date',
            'date_reception' => 'nullable|date',
            'date_envoi' => 'nullable|date',
            'date_limite_reponse' => 'nullable|date|after:date_courrier',
            'priorite' => 'required|in:normale,urgente,tres_urgente',
            'status' => 'required|in:en_attente,en_cours_traitement,traite,archive,en_attente_reponse,clos',
            'agent_responsable_id' => 'nullable|exists:users,id',
            'repertoire' => 'nullable|string|max:255',
            'numero_chrono' => 'nullable|string|max:255',
            'confidentiel' => 'boolean',
            'observations' => 'nullable|string',
        ]);

        $courrier->update($validated);

        // Ajouter le suivi
        $courrier->ajouterSuivi(
            'modification',
            'Courrier modifié',
            $donneesAvant,
            $courrier->fresh()->toArray()
        );

        return redirect()->route('courriers.show', $courrier)
            ->with('success', 'Courrier mis à jour avec succès.');
    }

    public function destroy(Courrier $courrier)
    {
        // Supprimer les documents associés
        foreach ($courrier->documents as $document) {
            Storage::disk('public')->delete($document->chemin_fichier);
        }

        $courrier->delete();

        return redirect()->route('courriers.index')
            ->with('success', 'Courrier supprimé avec succès.');
    }

    public function changerStatus(Request $request, Courrier $courrier)
    {
        $validated = $request->validate([
            'status' => 'required|in:en_attente,en_cours_traitement,traite,archive,en_attente_reponse,clos',
            'commentaire' => 'nullable|string',
        ]);

        $courrier->changerStatus($validated['status'], $validated['commentaire']);

        return redirect()->route('courriers.show', $courrier)
            ->with('success', 'Statut mis à jour avec succès.');
    }

    public function transmettre(Request $request, Courrier $courrier)
    {
        $validated = $request->validate([
            'service_destinataire_id' => 'required|exists:services,id',
            'agent_responsable_id' => 'nullable|exists:users,id',
            'commentaire' => 'required|string',
        ]);

        $courrier->update([
            'service_destinataire_id' => $validated['service_destinataire_id'],
            'agent_responsable_id' => $validated['agent_responsable_id'],
            'status' => 'en_cours_traitement',
        ]);

        $courrier->ajouterSuivi('transmission', $validated['commentaire']);

        return redirect()->route('courriers.show', $courrier)
            ->with('success', 'Courrier transmis avec succès.');
    }

    public function ajouterDocument(Request $request, Courrier $courrier)
    {
        $validated = $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'type_document' => 'required|in:courrier_principal,piece_jointe,reponse,accusé_reception,autre',
            'description' => 'nullable|string',
        ]);

        $file = $request->file('document');
        $nomOriginal = $file->getClientOriginalName();
        $nomFichier = time() . '_' . $nomOriginal;
        $chemin = $file->storeAs('courriers/' . $courrier->id, $nomFichier, 'public');

        DocumentCourrier::create([
            'courrier_id' => $courrier->id,
            'nom_document' => $nomOriginal,
            'nom_fichier' => $nomFichier,
            'chemin_fichier' => $chemin,
            'type_mime' => $file->getMimeType(),
            'taille_fichier' => $file->getSize(),
            'type_document' => $validated['type_document'],
            'description' => $validated['description'],
        ]);

        $courrier->ajouterSuivi('modification', 'Document ajouté: ' . $nomOriginal);

        return redirect()->route('courriers.show', $courrier)
            ->with('success', 'Document ajouté avec succès.');
    }

    public function telechargerDocument(DocumentCourrier $document)
    {
        if (!Storage::disk('public')->exists($document->chemin_fichier)) {
            abort(404, 'Fichier non trouvé');
        }

        return Storage::disk('public')->download(
            $document->chemin_fichier,
            $document->nom_document
        );
    }

    public function supprimerDocument(DocumentCourrier $document)
    {
        Storage::disk('public')->delete($document->chemin_fichier);
        $document->delete();

        return redirect()->route('courriers.show', $document->courrier)
            ->with('success', 'Document supprimé avec succès.');
    }

    public function recherche(Request $request)
    {
        $query = $request->get('q');
        $dateDebut = $request->get('date_debut');
        $dateFin = $request->get('date_fin');

        $courriers = Courrier::with(['user', 'agentResponsable', 'serviceExpediteur', 'serviceDestinataire'])
            ->where(function($q) use ($query) {
                $q->where('reference', 'like', "%{$query}%")
                  ->orWhere('objet', 'like', "%{$query}%")
                  ->orWhere('expediteur', 'like', "%{$query}%")
                  ->orWhere('destinataire', 'like', "%{$query}%")
                  ->orWhere('numero_chrono', 'like', "%{$query}%");
            });

        if ($dateDebut) {
            $courriers->whereDate('date_courrier', '>=', $dateDebut);
        }
        if ($dateFin) {
            $courriers->whereDate('date_courrier', '<=', $dateFin);
        }

        $courriers = $courriers->orderBy('created_at', 'desc')->paginate(20);

        return view('courriers.recherche', compact('courriers', 'query', 'dateDebut', 'dateFin'));
    }

    public function tableau_bord()
    {
        $stats = [
            'total' => Courrier::count(),
            'entrants' => Courrier::where('type', 'entrant')->count(),
            'sortants' => Courrier::where('type', 'sortant')->count(),
            'internes' => Courrier::where('type', 'interne')->count(),
            'en_retard' => Courrier::whereNotNull('date_limite_reponse')
                ->where('date_limite_reponse', '<', now())
                ->whereNotIn('status', ['traite', 'clos', 'archive'])
                ->count(),
            'urgents' => Courrier::whereIn('priorite', ['urgente', 'tres_urgente'])
                ->whereNotIn('status', ['traite', 'clos', 'archive'])
                ->count(),
        ];

        // Courriers récents
        $courriersRecents = Courrier::with(['user', 'agentResponsable'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Courriers en retard
        $courriersEnRetard = Courrier::with(['agentResponsable'])
            ->whereNotNull('date_limite_reponse')
            ->where('date_limite_reponse', '<', now())
            ->whereNotIn('status', ['traite', 'clos', 'archive'])
            ->orderBy('date_limite_reponse')
            ->limit(10)
            ->get();

        // Statistiques par service
        // $statsByService = Service::withCount([
        //     'serviceExpediteur',
        //     'serviceDestinataire'
        // ])->orderBy('nom')->get();
        $statsByService = Service::orderBy('nom')->get();

        return view('courriers.tableau_bord', compact(
            'stats',
            'courriersRecents',
            'courriersEnRetard',
            'statsByService'
        ));
    }
}
