<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function roles()
    {
        $roles = Role::with('users')->get();
        return view('users.roles', compact('roles'));
    }

    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|unique:roles',
            'description' => 'nullable',
            'permissions' => 'required|array',
        ]);

        Role::create($validated);

        return redirect()->route('users.roles')
            ->with('success', 'Rôle créé avec succès.');
    }

    public function updateRole(Request $request, Role $role)
    {
        $validated = $request->validate([
            'nom' => 'required|unique:roles,nom,' . $role->id,
            'description' => 'nullable',
            'permissions' => 'required|array',
        ]);

        $role->update($validated);

        return redirect()->route('users.roles')
            ->with('success', 'Rôle mis à jour avec succès.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,id',
            'password' => 'nullable|min:8',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('users.roles')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }
}