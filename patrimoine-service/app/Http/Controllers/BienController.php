<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BienController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Bien::with(['categorie', 'localisation'])->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'valeur' => ['required', 'numeric', 'min:0'],
            'date_acquisition' => ['nullable', 'date'],
            'etat' => ['required', 'string', 'in:neuf,bon,usage,mauvais'],
            'categorie_id' => ['required', 'integer', 'exists:categories,id'],
            'localisation_id' => ['required', 'integer', 'exists:localisations,id'],
            'utilisateur_id' => ['required', 'integer'],
        ]);

        return response()->json(
            Bien::create($donnees)->load(['categorie', 'localisation']),
            201
        );
    }

    public function show(Bien $bien): JsonResponse
    {
        return response()->json($bien->load(['categorie', 'localisation']));
    }

    public function update(Request $request, Bien $bien): JsonResponse
    {
        $donnees = $request->validate([
            'nom' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'valeur' => ['sometimes', 'numeric', 'min:0'],
            'date_acquisition' => ['nullable', 'date'],
            'etat' => ['sometimes', 'string', 'in:neuf,bon,usage,mauvais'],
            'categorie_id' => ['sometimes', 'integer', 'exists:categories,id'],
            'localisation_id' => ['sometimes', 'integer', 'exists:localisations,id'],
            'utilisateur_id' => ['sometimes', 'integer'],
        ]);

        $bien->update($donnees);

        return response()->json($bien->load(['categorie', 'localisation']));
    }

    public function destroy(Bien $bien): JsonResponse
    {
        $bien->delete();

        return response()->json(['message' => 'Bien supprime.']);
    }
}
