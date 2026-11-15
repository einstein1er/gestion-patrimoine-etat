<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\LocalisationController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', CategorieController::class);

Route::resource('biens', BienController::class);
Route::resource('localisations', LocalisationController::class);
