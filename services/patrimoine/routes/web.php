<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\BienController;



Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', CategorieController::class);

Route::resource('biens', BienController::class);
