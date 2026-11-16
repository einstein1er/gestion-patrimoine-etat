<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\LocalisationController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('profil/informations', [ProfilController::class, 'updateInformations'])->name('profil.informations');
    Route::put('profil/mot-de-passe', [ProfilController::class, 'updateMotDePasse'])->name('profil.mot-de-passe');
    Route::middleware('role:administrateur')->group(function () {
    Route::resource('utilisateurs', UtilisateurController::class);
   
    });

    Route::middleware('role:administrateur,gestionnaire')->group(function () {
        Route::resource('categories', CategorieController::class);
        Route::resource('biens', BienController::class);
        Route::resource('localisations', LocalisationController::class);
        Route::resource('affectations', AffectationController::class);
        Route::resource('maintenances', MaintenanceController::class);
    });

    Route::get('rapports', [RapportController::class, 'index'])->name('rapports.index');
    Route::get('rapports/pdf', [RapportController::class, 'exportPdf'])->name('rapports.pdf');
    
});
Route::get('connexion', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('connexion', [AuthController::class, 'login'])->name('login.store');
Route::post('deconnexion', [AuthController::class, 'logout'])->name('logout');
