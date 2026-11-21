<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $identifiants = $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required|string',
        ]);

        $utilisateur = Utilisateur::where('email', $identifiants['email'])->first();

        if (! $utilisateur || ! $utilisateur->actif) {
            return back()->withErrors([
                'email' => 'Identifiants invalides ou compte inactif.',
            ])->onlyInput('email');
        }

        if (! Hash::check($identifiants['mot_de_passe'], $utilisateur->mot_de_passe)) {
            return back()->withErrors([
                'email' => 'Identifiants invalides.',
            ])->onlyInput('email');
        }

        Auth::login($utilisateur);

        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('succes', 'Connexion réussie.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('succes', 'Déconnexion réussie.');
    }
}
