<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Bien;
use App\Models\Categorie;
use App\Models\Localisation;
use App\Models\Maintenance;
use Barryvdh\DomPDF\Facade\Pdf;

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
    public function exportPdf()
    {
        $totalBiens = Bien::count();
        $valeurTotale = Bien::sum('valeur');
        $coutMaintenances = Maintenance::sum('cout');
        $totalCategories = Categorie::count();
        $totalLocalisations = Localisation::count();
        $totalAffectations = Affectation::count();

        $repartitionCategories = Categorie::select('categories.nom')
            ->selectRaw('COUNT(biens.id) as total')
            ->selectRaw('COALESCE(SUM(biens.valeur), 0) as valeur')
            ->leftJoin('biens', 'biens.categorie_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.nom')
            ->orderBy('categories.nom')
            ->get();

        $repartitionMaintenances = Maintenance::select('statut')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('COALESCE(SUM(cout), 0) as cout')
            ->groupBy('statut')
            ->orderBy('statut')
            ->get();

        $derniersBiens = Bien::with('categorie')
            ->latest()
            ->take(10)
            ->get();

        $pdf = Pdf::loadView('rapports.pdf', compact(
            'totalBiens',
            'valeurTotale',
            'coutMaintenances',
            'totalCategories',
            'totalLocalisations',
            'totalAffectations',
            'repartitionCategories',
            'repartitionMaintenances',
            'derniersBiens'
        ));

        return $pdf->download('rapport-patrimoine.pdf');
    }
}
