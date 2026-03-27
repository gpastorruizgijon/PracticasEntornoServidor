<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OfferController;

// Importamos los controladores NORMALES (Asegúrate de que existan en App\Http\Controllers)
// Si no existen ahí y solo los tienes en Api, cámbialos aquí abajo, pero lo ideal es que no sean de la carpeta Api.
use App\Http\Controllers\Api\PlantController;
use App\Http\Controllers\Api\ShipmentController;
use App\Http\Controllers\Api\TruckController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WasteController;

Route::get('/', function () {
    return view('welcome');
});

// 1. Ruta de Ofertas (la dejamos fuera o dentro según prefieras, mejor dentro si requiere login)
Route::get('/ofertas', [OfferController::class, 'index'])->name('offers.index');

// 2. Grupo Protegido por Breeze (AUTH)
// Todo lo que esté aquí dentro sabrá QUIÉN es el usuario logueado
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas de Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- TUS RECURSOS AHORA DENTRO DE AUTH  Gracias Gemini, pero sigue roto :) ES TOCHO, NO ME ESPERBA TANTO MIRA MIRA---
    Route::resource('plantas', PlantController::class);
    Route::resource('envios', ShipmentController::class);
    Route::resource('camiones', TruckController::class);
    Route::resource('conductores', UserController::class);
    Route::resource('usuarios', UserController::class);
    Route::resource('residuos', WasteController::class);
});

require __DIR__.'/auth.php';