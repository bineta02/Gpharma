<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Authcontroller extends Controller
{
    public function verification()
    {
        if (Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    public function login(Request $request){
        //valider les donnees du formulaire
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ],[
            'email.required'      => 'L\'email est obligatoire.',
            'email.email'         => 'L\'email doit être une adresse valide.',
            'password.required'   => 'Le mot de passe est obligatoire.', 
            'password.min'        => 'Le mot de passe doit contenir au moins 6 caractères.',   

        ]);
        // Recuperer les identfiant
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        //Tentative de connxion
        if (Auth::attempt($credentials, $remember )){
            // Regenerer la session pour la securite
            $request->session()->regenerate();
            // Rediriger vers le dashboard
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Bienvenue' . Auth::user()->name . '!');
        }
        //Echec dela connexion 
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email'=> 'Ces identifiants ne correspondent à aucun compte.',
            ]);
    } 
    public function logout(Request $request)
    {
        Auth::logout();
        // Invalider la session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté avec succes.');
}

}
