<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', today());
        $service_id = $request->get('service_id');

        $query = Presence::with(['user.service'])
            ->whereDate('date', $date);

        if ($service_id) {
            $query->whereHas('user', function ($q) use ($service_id) {
                $q->where('service_id', $service_id);
            });
        }

        $presences = $query->orderBy('heure_arrivee')->get();

        // Statistiques globales
        $stats = [
            'total' => User::where('status', 'actif')->count(),
            'presents' => $presences->where('status', 'present')->count(),
            'retards' => $presences->where('status', 'retard')->count(),
            'absents' => $presences->where('status', 'absent')->count(),
        ];

        // Statistiques par direction
        $statsByService = Service::with(['users.presences' => function ($query) use ($date) {
            $query->whereDate('date', $date);
        }])->get()->map(function ($service) {
            $presences = $service->users->flatMap->presences;
            return [
                'nom' => $service->nom,
                'total' => $service->users->count(),
                'presents' => $presences->where('status', 'present')->count(),
                'retards' => $presences->where('status', 'retard')->count(),
                'absents' => $presences->where('status', 'absent')->count(),
            ];
        });

        $services = Service::orderBy('nom')->get();

        $users = User::all();

        return view('dashboard', compact('presences', 'stats', 'statsByService', 'services', 'date', 'service_id', 'users'));
    }


}
