<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function edit(): View
    {
        return view('profil.edit', [
            'utilisateur' => auth()->user(),
        ]);
    }

    public function updateInformations(Request $request): RedirectResponse
    {
        $utilisateur = auth()->user();

        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:utilisateurs,email,' . $utilisateur->id],
        ]);

        $utilisateur->update($donnees);

        return redirect()
            ->route('profil.edit')
            ->with('succes', 'Vos informations ont été mises à jour.');
    }

    public function updateMotDePasse(Request $request): RedirectResponse
    {
        $utilisateur = auth()->user();

        $donnees = $request->validate([
            'mot_de_passe_actuel' => ['required', 'string'],
            'mot_de_passe' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($donnees['mot_de_passe_actuel'], $utilisateur->mot_de_passe)) {
            return back()->withErrors([
                'mot_de_passe_actuel' => 'Le mot de passe actuel est incorrect.',
            ]);
        }

        $utilisateur->update([
            'mot_de_passe' => $donnees['mot_de_passe'],
        ]);

        return redirect()
            ->route('profil.edit')
            ->with('succes', 'Votre mot de passe a été modifié avec succès.');
    }
}
