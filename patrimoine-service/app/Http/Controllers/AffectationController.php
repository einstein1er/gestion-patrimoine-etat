<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Affectation::with('bien')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $donnees = $request->validate([
            'bien_id' => ['required', 'integer', 'exists:biens,id'],
            'utilisateur_id' => ['required', 'integer'],
            'date_affectation' => ['required', 'date'],
            'date_fin' => ['nullable', 'date', 'after_or_equal:date_affectation'],
            'observations' => ['nullable', 'string'],
        ]);

        return response()->json(Affectation::create($donnees)->load('bien'), 201);
    }

    public function show(Affectation $affectation): JsonResponse
    {
        return response()->json($affectation->load('bien'));
    }

    public function update(Request $request, Affectation $affectation): JsonResponse
    {
        $donnees = $request->validate([
            'bien_id' => ['sometimes', 'integer', 'exists:biens,id'],
            'utilisateur_id' => ['sometimes', 'integer'],
            'date_affectation' => ['sometimes', 'date'],
            'date_fin' => ['nullable', 'date', 'after_or_equal:date_affectation'],
            'observations' => ['nullable', 'string'],
        ]);

        $affectation->update($donnees);

        return response()->json($affectation->load('bien'));
    }

    public function destroy(Affectation $affectation): JsonResponse
    {
        $affectation->delete();

        return response()->json(['message' => 'Affectation supprimee.']);
    }
}
