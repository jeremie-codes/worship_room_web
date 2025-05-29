<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public function index()
    {
        $presences = Presence::with('employe')
            ->whereDate('date', now())
            ->paginate(10);
            
        return view('presences.index', compact('presences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'status' => 'required|in:present,retard,absent,justifie,autorise',
            'heure_arrivee' => 'nullable|date_format:H:i',
            'heure_depart' => 'nullable|date_format:H:i|after:heure_arrivee',
            'commentaire' => 'nullable',
        ]);

        $validated['date'] = now();

        Presence::create($validated);

        return redirect()->route('presences.index')
            ->with('success', 'Présence enregistrée avec succès.');
    }
}