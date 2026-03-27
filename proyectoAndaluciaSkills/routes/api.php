<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\PlantController;
// use App\Http\Controllers\Api\TruckController;
// use App\Http\Controllers\Api\ShipmentController;
// use App\Http\Controllers\Api\WasteController;
// use App\Http\Controllers\Api\UserController;
use App\Models\User;

// CRUDs principales
// Route::apiResource('plants', PlantController::class);
// Route::apiResource('trucks', TruckController::class);
// Route::apiResource('shipments', ShipmentController::class);
// Route::apiResource('wastes', WasteController::class);
// Route::apiResource('conductores', UserController::class);


// Ruta para cargar los selects de conductores en el formulario de camiones
Route::get('available-drivers', function() {
    return response()->json(User::all()); 
});