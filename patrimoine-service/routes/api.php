<?php

use Illuminate\Support\Facades\Route;

Route::get('/sante', function () {
    return response()->json([
        'service' => 'patrimoine',
        'statut' => 'ok',
    ]);
});
