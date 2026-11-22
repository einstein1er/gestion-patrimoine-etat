<?php

use App\Http\Controllers\InterventionController;
use Illuminate\Support\Facades\Route;

Route::middleware('verifier.token')->group(function () {
    Route::get('/interventions', [InterventionController::class, 'index']);
    Route::post('/interventions', [InterventionController::class, 'store']);
    Route::get('/interventions/{id}', [InterventionController::class, 'show']);
    Route::put('/interventions/{id}', [InterventionController::class, 'update']);
    Route::delete('/interventions/{id}', [InterventionController::class, 'destroy']);
});
