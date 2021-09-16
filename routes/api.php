<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntrevistadorController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\SedeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cita/createHorarios', [CitaController::class, 'createHorarios']);
Route::get('/cita/getCitasDiponibles', [CitaController::class, 'getCitasDiponibles']);
Route::get('/cita/getCitasDisponiblesByFecha', [CitaController::class, 'getCitasDisponiblesByFecha']);
Route::get('/cita/getCitasDisponiblesByEstatus', [CitaController::class, 'getCitasDisponiblesByEstatus']);
Route::get('/cita/getCitasDisponiblesByFechaEstatus', [CitaController::class, 'getCitasDisponiblesByFechaEstatus']);

Route::post('/institucion/create', [InstitucionController::class, 'create']);

Route::post('/sede/create', [SedeController::class, 'create']);

Route::post('/entrevistador/create', [EntrevistadorController::class, 'create']);
