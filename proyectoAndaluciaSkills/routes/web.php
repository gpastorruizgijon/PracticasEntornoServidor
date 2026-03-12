<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlantController;
use App\Http\Controllers\Api\ShipmentController;
use App\Http\Controllers\Api\TruckController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WasteController;

Route::get('/', function () { return view('welcome'); });

// Registramos todos los recursos para las vistas Blade
Route::resource('plantas', PlantController::class);
Route::resource('envios', ShipmentController::class);
Route::resource('camiones', TruckController::class);
Route::resource('conductores', UserController::class);
Route::resource('residuos', WasteController::class);