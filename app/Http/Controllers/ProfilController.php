<?php

namespace App\Http\Controllers;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class ProfilController extends Controller
{
    // Afficher la page du profil
    public function show()
    {
        $user = Auth::user();
        return view('profil.show', compact('user'));
    }

    // Mettre à jour les informations générales et la photo
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('profile_photos', 'public');
            $data['photo'] = $path;
        }

        $user->update($data);
        // Enregistrement de l'action dans le journal d'activité
ActivityLog::create([
    'user_id' => auth()->id(),
    'action' => 'Mise à jour Profil', 
    'description' => auth()->user()->name . ' a mis à jour ses informations personnelles.',
    'ip_address' => request()->ip(),
]);

        return redirect()->back()->with('success', 'Profil mis à jour avec succès !');
    }

    // Changer le mot de passe
    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);
        // Enregistrement de l'action dans le journal d'activité
ActivityLog::create([
    'user_id' => auth()->id(),
    'action' => 'Sécurité',
    'description' => auth()->user()->name . ' a modifié son mot de passe.',
    'ip_address' => request()->ip(),
]);

        return redirect()->back()->with('success_password', 'Mot de passe modifié avec succès !');
    }
}