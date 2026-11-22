<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Maintenance::with('bien')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $donnees = $request->validate([
            'bien_id' => ['required', 'integer', 'exists:biens,id'],
            'type' => ['required', 'string', 'max:255'],
            'date_maintenance' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'cout' => ['required', 'numeric', 'min:0'],
            'statut' => ['required', 'string', 'in:planifiee,en_cours,terminee'],
        ]);

        return response()->json(Maintenance::create($donnees)->load('bien'), 201);
    }

    public function show(Maintenance $maintenance): JsonResponse
    {
        return response()->json($maintenance->load('bien'));
    }

    public function update(Request $request, Maintenance $maintenance): JsonResponse
    {
        $donnees = $request->validate([
            'bien_id' => ['sometimes', 'integer', 'exists:biens,id'],
            'type' => ['sometimes', 'string', 'max:255'],
            'date_maintenance' => ['sometimes', 'date'],
            'description' => ['nullable', 'string'],
            'cout' => ['sometimes', 'numeric', 'min:0'],
            'statut' => ['sometimes', 'string', 'in:planifiee,en_cours,terminee'],
        ]);

        $maintenance->update($donnees);

        return response()->json($maintenance->load('bien'));
    }

    public function destroy(Maintenance $maintenance): JsonResponse
    {
        $maintenance->delete();

        return response()->json(['message' => 'Maintenance supprimee.']);
    }
}
