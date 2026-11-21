<?php

namespace App\Http\Controllers;

use App\Models\Localisation;
use Illuminate\Http\Request;

class LocalisationController extends Controller
{
    public function index(Request $request)
    {
        $localisations = Localisation::with('parent')
            ->when(
                $request->filled('recherche'),
                fn ($query) => $query->where('nom', 'like', '%' . $request->recherche . '%')
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('localisations.index', compact('localisations'));
    }

    public function create()
    {
        $parents = Localisation::orderBy('nom')->get();

        return view('localisations.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $donnees = $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:localisations,code',
            'type' => 'required|in:region,province,departement,commune,site',
            'parent_id' => 'nullable|exists:localisations,id',
            'actif' => 'nullable|boolean',
        ]);

        $donnees['actif'] = $request->boolean('actif');

        Localisation::create($donnees);

        return redirect()
            ->route('localisations.index')
            ->with('succes', 'Localisation créée avec succès.');
    }

    public function show(Localisation $localisation)
    {
        $localisation->load('parent', 'enfants');

        return view('localisations.show', compact('localisation'));
    }

    public function edit(Localisation $localisation)
    {
        $parents = Localisation::where('id', '!=', $localisation->id)
            ->orderBy('nom')
            ->get();

        return view('localisations.edit', compact('localisation', 'parents'));
    }

    public function update(Request $request, Localisation $localisation)
    {
        $donnees = $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:localisations,code,' . $localisation->id,
            'type' => 'required|in:region,province,departement,commune,site',
            'parent_id' => 'nullable|exists:localisations,id',
            'actif' => 'nullable|boolean',
        ]);

        $donnees['actif'] = $request->boolean('actif');

        $localisation->update($donnees);

        return redirect()
            ->route('localisations.index')
            ->with('succes', 'Localisation modifiée avec succès.');
    }

    public function destroy(Localisation $localisation)
    {
        $localisation->delete();

        return redirect()
            ->route('localisations.index')
            ->with('succes', 'Localisation supprimée avec succès.');
    }
}
