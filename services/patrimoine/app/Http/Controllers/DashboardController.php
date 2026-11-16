<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Bien;
use App\Models\Categorie;
use App\Models\Localisation;
use App\Models\Maintenance;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBiens = Bien::count();
        $valeurTotale = Bien::sum('valeur');
        $coutMaintenances = Maintenance::sum('cout');
        $totalCategories = Categorie::count();
        $totalLocalisations = Localisation::count();
        $totalAffectations = Affectation::count();

        $derniersBiens = Bien::with('categorie')
            ->latest()
            ->take(5)
            ->get();

        $dernieresMaintenances = Maintenance::with('bien')
            ->latest()
            ->take(5)
            ->get();

        $affectationsActives = Affectation::with(['bien', 'localisation'])
            ->whereNull('date_fin')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalBiens',
            'valeurTotale',
            'coutMaintenances',
            'totalCategories',
            'totalLocalisations',
            'totalAffectations',
            'derniersBiens',
            'dernieresMaintenances',
            'affectationsActives'
        ));
    }
}
