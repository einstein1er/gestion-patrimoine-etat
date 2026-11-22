<?php

use App\Http\Controllers\AffectationController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\LocalisationController;
use App\Http\Controllers\MaintenanceController;
use Illuminate\Support\Facades\Route;

Route::get('/sante', function () {
    return response()->json([
        'service' => 'patrimoine',
        'statut' => 'ok',
    ]);
});

Route::middleware('verifier.token')->group(function () {
    Route::apiResource('categories', CategorieController::class);
    Route::apiResource('localisations', LocalisationController::class);
    Route::apiResource('biens', BienController::class);
    Route::apiResource('affectations', AffectationController::class);
    Route::apiResource('maintenances', MaintenanceController::class);
});
