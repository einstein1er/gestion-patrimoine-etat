<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Bien;
use App\Models\Localisation;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    public function index(Request $request)
    {
        $affectations = Affectation::with(['bien', 'localisation'])
            ->when(
                $request->filled('recherche'),
                fn ($query) => $query->whereHas('bien', function ($q) use ($request) {
                    $q->where('nom', 'like', '%' . $request->recherche . '%');
                })
            )
            ->when(
                $request->filled('statut'),
                fn ($query) => $query->where('statut', $request->statut)
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('affectations.index', compact('affectations'));
    }

    public function create()
    {
        $biens = Bien::orderBy('nom')->get();
        $localisations = Localisation::orderBy('nom')->get();

        return view('affectations.create', compact('biens', 'localisations'));
    }

    public function store(Request $request)
    {
        $donnees = $request->validate([
            'bien_id' => 'required|exists:biens,id',
            'localisation_id' => 'required|exists:localisations,id',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'responsable' => 'nullable|string|max:255',
            'observation' => 'nullable|string',
            'actif' => 'nullable|boolean',
        ]);

        $donnees['actif'] = $request->boolean('actif');

        Affectation::create($donnees);

        return redirect()
            ->route('affectations.index')
            ->with('succes', 'Affectation créée avec succès.');
    }

    public function show(Affectation $affectation)
    {
        $affectation->load('bien', 'localisation');

        return view('affectations.show', compact('affectation'));
    }

    public function edit(Affectation $affectation)
    {
        $biens = Bien::orderBy('nom')->get();
        $localisations = Localisation::orderBy('nom')->get();

        return view('affectations.edit', compact('affectation', 'biens', 'localisations'));
    }

    public function update(Request $request, Affectation $affectation)
    {
        $donnees = $request->validate([
            'bien_id' => 'required|exists:biens,id',
            'localisation_id' => 'required|exists:localisations,id',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'responsable' => 'nullable|string|max:255',
            'observation' => 'nullable|string',
            'actif' => 'nullable|boolean',
        ]);

        $donnees['actif'] = $request->boolean('actif');

        $affectation->update($donnees);

        return redirect()
            ->route('affectations.index')
            ->with('succes', 'Affectation modifiée avec succès.');
    }

    public function destroy(Affectation $affectation)
    {
        $affectation->delete();

        return redirect()
            ->route('affectations.index')
            ->with('succes', 'Affectation supprimée avec succès.');
    }
}
