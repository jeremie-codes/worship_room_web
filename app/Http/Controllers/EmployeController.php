<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    public function index()
    {
        $employes = Employe::paginate(10);
        return view('employes.index', compact('employes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:employes',
            'telephone' => 'nullable',
            'grade' => 'required',
            'service' => 'required',
            'fonction' => 'required',
            'date_engagement' => 'required|date',
        ]);

        Employe::create($validated);

        return redirect()->route('employes.index')
            ->with('success', 'Employé ajouté avec succès.');
    }

    public function update(Request $request, Employe $employe)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:employes,email,' . $employe->id,
            'telephone' => 'nullable',
            'grade' => 'required',
            'service' => 'required',
            'fonction' => 'required',
            'date_engagement' => 'required|date',
        ]);

        $employe->update($validated);

        return redirect()->route('employes.index')
            ->with('success', 'Employé mis à jour avec succès.');
    }

    public function destroy(Employe $employe)
    {
        $employe->delete();

        return redirect()->route('employes.index')
            ->with('success', 'Employé supprimé avec succès.');
    }
}