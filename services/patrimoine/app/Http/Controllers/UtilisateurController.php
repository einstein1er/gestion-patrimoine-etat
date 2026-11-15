<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    public function index()
    {
        $utilisateurs = Utilisateur::orderBy('nom')->paginate(10);

        return view('utilisateurs.index', compact('utilisateurs'));
    }

    public function create()
    {
        return view('utilisateurs.create');
    }

    public function store(Request $request)
    {
        $donnees = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:utilisateurs,email',
            'mot_de_passe' => 'required|string|min:8|confirmed',
            'role' => 'required|in:administrateur,gestionnaire,consultant',
            'actif' => 'nullable|boolean',
        ]);

        $donnees['actif'] = $request->boolean('actif');

        Utilisateur::create($donnees);

        return redirect()
            ->route('utilisateurs.index')
            ->with('succes', 'Utilisateur créé avec succès.');
    }

    public function show(Utilisateur $utilisateur)
    {
        return view('utilisateurs.show', compact('utilisateur'));
    }

    public function edit(Utilisateur $utilisateur)
    {
        return view('utilisateurs.edit', compact('utilisateur'));
    }

    public function update(Request $request, Utilisateur $utilisateur)
    {
        $donnees = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:utilisateurs,email,' . $utilisateur->id,
            'mot_de_passe' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:administrateur,gestionnaire,consultant',
            'actif' => 'nullable|boolean',
        ]);

        if (empty($donnees['mot_de_passe'])) {
            unset($donnees['mot_de_passe']);
        }

        $donnees['actif'] = $request->boolean('actif');

        $utilisateur->update($donnees);

        return redirect()
            ->route('utilisateurs.index')
            ->with('succes', 'Utilisateur modifié avec succès.');
    }

    public function destroy(Utilisateur $utilisateur)
    {
        $utilisateur->delete();

        return redirect()
            ->route('utilisateurs.index')
            ->with('succes', 'Utilisateur supprimé avec succès.');
    }
}
