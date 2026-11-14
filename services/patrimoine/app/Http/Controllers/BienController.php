<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Categorie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BienController extends Controller
{
    public function index(): View
    {
        $biens = Bien::with('categorie')
            ->orderBy('nom')
            ->paginate(10);

        return view('biens.index', compact('biens'));
    }

    public function create(): View
    {
        $categories = Categorie::where('actif', true)
            ->orderBy('nom')
            ->get();

        return view('biens.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'categorie_id' => ['required', 'exists:categories,id'],
            'nom' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:biens,code'],
            'description' => ['nullable', 'string'],
            'valeur' => ['required', 'numeric', 'min:0'],
            'date_acquisition' => ['nullable', 'date'],
            'etat' => ['required', 'in:neuf,bon,moyen,mauvais'],
            'localisation' => ['nullable', 'string', 'max:255'],
            'actif' => ['nullable', 'boolean'],
        ]);

        $donnees['actif'] = $request->boolean('actif');

        Bien::create($donnees);

        return redirect()
            ->route('biens.index')
            ->with('succes', 'Bien créé avec succès.');
    }

    public function show(Bien $bien): View
    {
        $bien->load('categorie');

        return view('biens.show', compact('bien'));
    }

    public function edit(Bien $bien): View
    {
        $categories = Categorie::where('actif', true)
            ->orderBy('nom')
            ->get();

        return view('biens.edit', compact('bien', 'categories'));
    }

    public function update(Request $request, Bien $bien): RedirectResponse
    {
        $donnees = $request->validate([
            'categorie_id' => ['required', 'exists:categories,id'],
            'nom' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:biens,code,' . $bien->id],
            'description' => ['nullable', 'string'],
            'valeur' => ['required', 'numeric', 'min:0'],
            'date_acquisition' => ['nullable', 'date'],
            'etat' => ['required', 'in:neuf,bon,moyen,mauvais'],
            'localisation' => ['nullable', 'string', 'max:255'],
            'actif' => ['nullable', 'boolean'],
        ]);

        $donnees['actif'] = $request->boolean('actif');

        $bien->update($donnees);

        return redirect()
            ->route('biens.index')
            ->with('succes', 'Bien mis à jour avec succès.');
    }

    public function destroy(Bien $bien): RedirectResponse
    {
        $bien->delete();

        return redirect()
            ->route('biens.index')
            ->with('succes', 'Bien supprimé avec succès.');
    }
}
