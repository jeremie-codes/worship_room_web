<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Conge;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_employes' => Employe::count(),
            'conges_en_attente' => Conge::where('status', 'en_attente')->count(),
            'conges_en_cours' => Conge::where('status', 'approuve')
                ->whereDate('date_debut', '<=', now())
                ->whereDate('date_fin', '>=', now())
                ->count(),
            'employes_malades' => Conge::where('type_conge', 'maladie')
                ->whereDate('date_debut', '<=', now())
                ->whereDate('date_fin', '>=', now())
                ->count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
