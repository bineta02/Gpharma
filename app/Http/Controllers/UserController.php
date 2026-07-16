<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // 1. LISTE DES UTILISATEURS
    public function index()
    {
        // Pas besoin de charger de relation factice, on prend juste les utilisateurs !
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // 2. FORMULAIRE DE CRÉATION
    public function create()
    {
        // Tes rôles sont gérés par de simples chaînes de caractères
        $roles = ['admin', 'manager', 'vendeur'];
        return view('users.create', compact('roles'));
    }

    // 3. ENREGISTRER L'UTILISATEUR
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'statut' => 'actif',
        ]);
        // Enregistrement de l'action dans le journal d'activité
ActivityLog::create([
    'action' => 'Modification Utilisateur',
'description' => 'A modifié les informations de ' . $user->name,
    'user_id' => auth()->id(),
    'ip_address' => request()->ip(),
]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès !');
    }

    // 4. FORMULAIRE DE MODIFICATION
    public function edit(User $user)
    {
        $roles = ['admin', 'manager', 'vendeur'];
        return view('users.edit', compact('user', 'roles'));
    }

    // 5. METTRE À JOUR L'UTILISATEUR
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        // Enregistrement de l'action dans le journal d'activité
ActivityLog::create([
    'action' => 'Création Utilisateur',
'description' => 'A créé le compte de ' . $user->name,
    'user_id' => auth()->id(),
    'ip_address' => request()->ip(),
]);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès !');
    }

    // 6. ACTIVER / DÉSACTIVER LE COMPTE
    public function toggleStatus(User $user)
    {
        $user->statut = ($user->statut === 'actif') ? 'inactif' : 'actif';
        $user->save();

        return redirect()->back()->with('success', 'Statut du compte mis à jour !');
    }
}