<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Categorie::all());
    }

    public function store(Request $request): JsonResponse
    {
        $donnees = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:categories,nom'],
            'description' => ['nullable', 'string'],
        ]);

        return response()->json(Categorie::create($donnees), 201);
    }

    public function show(Categorie $categorie): JsonResponse
    {
        return response()->json($categorie);
    }

    public function update(Request $request, Categorie $categorie): JsonResponse
    {
        $donnees = $request->validate([
            'nom' => ['sometimes', 'string', 'max:255', 'unique:categories,nom,' . $categorie->id],
            'description' => ['nullable', 'string'],
        ]);

        $categorie->update($donnees);

        return response()->json($categorie);
    }

    public function destroy(Categorie $categorie): JsonResponse
    {
        $categorie->delete();

        return response()->json(['message' => 'Categorie supprimee.']);
    }
}
