<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/inscription', [AuthController::class, 'register']);
Route::post('/connexion', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profil', [AuthController::class, 'profil']);
    Route::post('/deconnexion', [AuthController::class, 'logout']);

    Route::get('/verifier-token', function (Request $request) {
        return response()->json([
            'utilisateur_id' => $request->user()->id,
            'nom' => $request->user()->nom,
            'prenom' => $request->user()->prenom,
            'email' => $request->user()->email,
            'role' => $request->user()->role,
        ]);
    });
});
