<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index(): View
    {
        $categories = Categorie::orderBy('nom')->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:100', 'unique:categories,nom'],
            'code' => ['required', 'string', 'max:20', 'unique:categories,code'],
            'description' => ['nullable', 'string'],
            'actif' => ['required', 'boolean'],
        ]);

        Categorie::create($donnees);

        return redirect()
            ->route('categories.index')
            ->with('succes', 'La catégorie a été créée avec succès.');
    }

    public function show(Categorie $categorie): View
    {
        return view('categories.show', compact('categorie'));
    }

    public function edit(Categorie $categorie): View
    {
        return view('categories.edit', compact('categorie'));
    }

    public function update(Request $request, Categorie $categorie): RedirectResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:100', 'unique:categories,nom,'.$categorie->id],
            'code' => ['required', 'string', 'max:20', 'unique:categories,code,'.$categorie->id],
            'description' => ['nullable', 'string'],
            'actif' => ['required', 'boolean'],
        ]);

        $categorie->update($donnees);

        return redirect()
            ->route('categories.index')
            ->with('succes', 'La catégorie a été mise à jour avec succès.');
    }

    public function destroy(Categorie $categorie): RedirectResponse
    {
        $categorie->delete();

        return redirect()
            ->route('categories.index')
            ->with('succes', 'La catégorie a été supprimée avec succès.');
    }
}
