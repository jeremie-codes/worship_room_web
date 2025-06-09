<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::withCount(['users'])
            ->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $services = Service::orderBy('nom')->get();
        $users = User::orderBy('name')->get();
        return view('admin.services.create', compact('services', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:services',
            'code' => 'required|string|max:255|unique:services',
            'description' => 'nullable|string',
            'responsable_id' => 'nullable|exists:users,id',
            'service_parent_id' => 'nullable|exists:services,id'
        ]);

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service créé avec succès.');
    }

    public function edit(Service $service)
    {
        $services = Service::where('id', '!=', $service->id)->orderBy('nom')->get();
        $users = User::orderBy('name')->get();
        return view('admin.services.edit', compact('service', 'services', 'users'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:services,nom,' . $service->id,
            'code' => 'required|string|max:255|unique:services,code,' . $service->id,
            'description' => 'nullable|string',
            'responsable_id' => 'nullable|exists:users,id',
            'service_parent_id' => 'nullable|exists:services,id'
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service mis à jour avec succès.');
    }

    public function destroy(Service $service)
    {
        if ($service->agents()->exists()) {
            return back()->with('error', 'Ce service ne peut pas être supprimé car il contient des agents.');
        }

        if ($service->users()->exists()) {
            return back()->with('error', 'Ce service ne peut pas être supprimé car il contient des utilisateurs.');
        }

        if ($service->sousServices()->exists()) {
            return back()->with('error', 'Ce service ne peut pas être supprimé car il contient des sous-services.');
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service supprimé avec succès.');
    }
}
