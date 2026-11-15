<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\LocalisationController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\RapportController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', CategorieController::class);

Route::resource('biens', BienController::class);
Route::resource('localisations', LocalisationController::class);
Route::resource('affectations', AffectationController::class);
Route::resource('maintenances', MaintenanceController::class);
Route::get('rapports', [RapportController::class, 'index'])->name('rapports.index');
