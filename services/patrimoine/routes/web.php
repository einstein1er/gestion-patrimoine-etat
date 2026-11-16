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


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
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
});
Route::get('connexion', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('connexion', [AuthController::class, 'login'])->name('login.store');
Route::post('deconnexion', [AuthController::class, 'logout'])->name('logout');
