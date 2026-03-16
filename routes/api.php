<?php

use App\Http\Controllers\Api\v1\DossierMedicalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('v1/dossiers', DossierMedicalController::class)
    ->parameters(['dossiers' => 'dossierMedical']);

Route::get('v1/dossiers/{dossierMedical}/pdf', [DossierMedicalController::class, 'downloadPdf']);

