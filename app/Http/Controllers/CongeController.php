<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use Illuminate\Http\Request;

class CongeController extends Controller
{
    public function index()
    {
        $conges = Conge::with('employe')->paginate(10);
        return view('conges.index', compact('conges'));
    }

    public function planning()
    {
        $conges = Conge::with('employe')->paginate(10);
        return view('conges.planning', compact('conges'));
    }

    public function attribuer()
    {
        $conges = Conge::with('employe')->paginate(10);
        return view('conges.attribuer', compact('conges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_conge' => 'required',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'motif' => 'required',
            'contact' => 'required',
        ]);

        $validated['employe_id'] = auth()->user()->employe_id;
        $validated['status'] = 'en_attente';

        Conge::create($validated);

        return redirect()->route('conges.index')
            ->with('success', 'Demande de congé soumise avec succès.');
    }

    public function approve(Conge $conge)
    {
        $conge->update(['status' => 'approuve']);
        return redirect()->route('conges.index')
            ->with('success', 'Congé approuvé avec succès.');
    }

    public function reject(Conge $conge)
    {
        $conge->update(['status' => 'refuse']);
        return redirect()->route('conges.index')
            ->with('success', 'Congé refusé.');
    }
}
