<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Bien;
use App\Models\Categorie;
use App\Models\Localisation;
use App\Models\Maintenance;

class RapportController extends Controller
{
    public function index()
    {
        $totalBiens = Bien::count();
        $valeurTotale = Bien::sum('valeur');

        $totalCategories = Categorie::count();
        $totalLocalisations = Localisation::count();
        $totalAffectations = Affectation::count();
        $totalMaintenances = Maintenance::count();

        $coutMaintenances = Maintenance::sum('cout');

        $biensParCategorie = Categorie::withCount('biens')
            ->orderBy('nom')
            ->get();

        $maintenancesParStatut = Maintenance::selectRaw('statut, count(*) as total')
            ->groupBy('statut')
            ->pluck('total', 'statut');

        return view('rapports.index', compact(
            'totalBiens',
            'valeurTotale',
            'totalCategories',
            'totalLocalisations',
            'totalAffectations',
            'totalMaintenances',
            'coutMaintenances',
            'biensParCategorie',
            'maintenancesParStatut',
        ));
    }
}
