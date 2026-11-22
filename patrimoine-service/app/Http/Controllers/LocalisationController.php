<?php

namespace App\Http\Controllers;

use App\Models\Localisation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocalisationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Localisation::all());
    }

    public function store(Request $request): JsonResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:255'],
        ]);

        return response()->json(Localisation::create($donnees), 201);
    }

    public function show(Localisation $localisation): JsonResponse
    {
        return response()->json($localisation);
    }

    public function update(Request $request, Localisation $localisation): JsonResponse
    {
        $donnees = $request->validate([
            'nom' => ['sometimes', 'string', 'max:255'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:255'],
        ]);

        $localisation->update($donnees);

        return response()->json($localisation);
    }

    public function destroy(Localisation $localisation): JsonResponse
    {
        $localisation->delete();

        return response()->json(['message' => 'Localisation supprimee.']);
    }
}
