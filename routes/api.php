<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UbicacionController;

Route::post('/guardar-ubicacion', [UbicacionController::class, 'store']);