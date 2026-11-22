<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    public function index()
    {
        return response()->json(Intervention::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bien_id' => ['required', 'integer'],
            'technicien_id' => ['nullable', 'integer'],
            'type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date_intervention' => ['nullable', 'date'],
            'statut' => ['nullable', 'string', 'max:255'],
            'cout' => ['nullable', 'numeric'],
        ]);

        $intervention = Intervention::create($data);

        return response()->json($intervention, 201);
    }

    public function show($id)
    {
        $intervention = Intervention::find($id);

        if (!$intervention) {
            return response()->json([
                'message' => 'Intervention introuvable'
            ], 404);
        }

        return response()->json($intervention);
    }

    public function update(Request $request, $id)
    {
        $intervention = Intervention::find($id);

        if (!$intervention) {
            return response()->json([
                'message' => 'Intervention introuvable'
            ], 404);
        }

        $data = $request->validate([
            'bien_id' => ['sometimes', 'integer'],
            'technicien_id' => ['nullable', 'integer'],
            'type' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date_intervention' => ['nullable', 'date'],
            'statut' => ['nullable', 'string', 'max:255'],
            'cout' => ['nullable', 'numeric'],
        ]);

        $intervention->update($data);

        return response()->json($intervention);
    }

    public function destroy($id)
    {
        $intervention = Intervention::find($id);

        if (!$intervention) {
            return response()->json([
                'message' => 'Intervention introuvable'
            ], 404);
        }

        $intervention->delete();

        return response()->json([
            'message' => 'Intervention supprimée'
        ]);
    }
}
