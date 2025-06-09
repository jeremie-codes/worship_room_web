<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => User::count(),
            'actifs' => User::where('status', 'actif')->count(),
            'retraites' => User::where('status', 'retraite')->count(),
            'autres' => User::whereNotIn('status', ['actif', 'retraite'])->count(),
        ];

        $agents = User::with('service')
            ->orderBy('nom')
            ->paginate(20);

        return view('agents.index', compact('agents', 'stats'));
    }

    public function retraites()
    {
        $agents = User::with('service')
            ->where('status', 'retraite')
            ->orderBy('nom')
            ->paginate(20);

        return view('agents.retraites', compact('agents'));
    }

    public function malades()
    {
        $agents = User::with('service')
            ->where('status', 'malade')
            ->orderBy('nom')
            ->paginate(20);

        return view('agents.malades', compact('agents'));
    }

    public function demissions()
    {
        $agents = User::with('service')
            ->where('status', 'demission')
            ->orderBy('nom')
            ->paginate(20);

        return view('agents.demissions', compact('agents'));
    }

    public function revoques()
    {
        $agents = User::with('service')
            ->where('status', 'revoque')
            ->orderBy('nom')
            ->paginate(20);

        return view('agents.revoques', compact('agents'));
    }

    public function disponibilites()
    {
        $agents = User::with('service')
            ->where('status', 'disponibilite')
            ->orderBy('nom')
            ->paginate(20);

        return view('agents.disponibilites', compact('agents'));
    }

    public function detachements()
    {
        $agents = User::with('service')
            ->where('status', 'detachement')
            ->orderBy('nom')
            ->paginate(20);

        return view('agents.detachements', compact('agents'));
    }

    public function mutations()
    {
        $agents = User::with('service')
            ->where('status', 'mutation')
            ->orderBy('nom')
            ->paginate(20);

        return view('agents.mutations', compact('agents'));
    }

    public function reintegrations()
    {
        $agents = User::with('service')
            ->where('status', 'reintegration')
            ->orderBy('nom')
            ->paginate(20);

        return view('agents.reintegrations', compact('agents'));
    }

    public function missions()
    {
        $agents = User::with('service')
            ->where('status', 'mission')
            ->orderBy('nom')
            ->paginate(20);

        return view('agents.missions', compact('agents'));
    }

    public function decedes()
    {
        $agents = User::with('service')
            ->where('status', 'decede')
            ->orderBy('nom')
            ->paginate(20);

        return view('agents.decedes', compact('agents'));
    }

    public function create()
    {
        $services = Service::orderBy('nom')->get();
        return view('agents.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|unique:agents',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|unique:agents',
            'date_engagement' => 'required|date',
            'service_id' => 'required|exists:services,id',
            'observations' => 'nullable|string',
        ]);

        User::create($validated);

        return redirect()->route('agents.index')
            ->with('success', 'Agent enregistré avec succès');
    }

    public function edit(Agent $agent)
    {
        $services = Service::orderBy('nom')->get();
        return view('agents.edit', compact('agent', 'services'));
    }

    public function update(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'matricule' => 'required|unique:agents,matricule,' . $agent->id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
            'date_engagement' => 'required|date',
            'status' => 'required|in:actif,retraite,malade,demission,revoque,disponibilite,detachement,mutation,reintegration,mission,decede',
            'service_id' => 'required|exists:services,id',
            'observations' => 'nullable|string',
        ]);

        $agent->update($validated);

        return redirect()->route('agents.index')
            ->with('success', 'Agent mis à jour avec succès');
    }

    public function show(Agent $agent)
    {
        return view('agents.show', compact('agent'));
    }
}
