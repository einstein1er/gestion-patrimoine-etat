<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('bien')
            ->orderByDesc('date_maintenance')
            ->paginate(10);

        return view('maintenances.index', compact('maintenances'));
    }

    public function create()
    {
        $biens = Bien::orderBy('nom')->get();

        return view('maintenances.create', compact('biens'));
    }

    public function store(Request $request)
    {
        $donnees = $request->validate([
            'bien_id' => 'required|exists:biens,id',
            'type' => 'required|in:preventive,corrective,reparation,inspection',
            'date_maintenance' => 'required|date',
            'cout' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'prestataire' => 'nullable|string|max:255',
            'statut' => 'required|in:planifiee,en_cours,terminee,annulee',
            'actif' => 'nullable|boolean',
        ]);

        $donnees['cout'] = $donnees['cout'] ?? 0;
        $donnees['actif'] = $request->boolean('actif');

        Maintenance::create($donnees);

        return redirect()
            ->route('maintenances.index')
            ->with('succes', 'Maintenance créée avec succès.');
    }

    public function show(Maintenance $maintenance)
    {
        $maintenance->load('bien');

        return view('maintenances.show', compact('maintenance'));
    }

    public function edit(Maintenance $maintenance)
    {
        $biens = Bien::orderBy('nom')->get();

        return view('maintenances.edit', compact('maintenance', 'biens'));
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $donnees = $request->validate([
            'bien_id' => 'required|exists:biens,id',
            'type' => 'required|in:preventive,corrective,reparation,inspection',
            'date_maintenance' => 'required|date',
            'cout' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'prestataire' => 'nullable|string|max:255',
            'statut' => 'required|in:planifiee,en_cours,terminee,annulee',
            'actif' => 'nullable|boolean',
        ]);

        $donnees['cout'] = $donnees['cout'] ?? 0;
        $donnees['actif'] = $request->boolean('actif');

        $maintenance->update($donnees);

        return redirect()
            ->route('maintenances.index')
            ->with('succes', 'Maintenance modifiée avec succès.');
    }

    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();

        return redirect()
            ->route('maintenances.index')
            ->with('succes', 'Maintenance supprimée avec succès.');
    }
}
