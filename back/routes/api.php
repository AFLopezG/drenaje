<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('login', [App\Http\Controllers\UserController::class, 'login']);

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('me', [App\Http\Controllers\UserController::class, 'me']);
    Route::post('logout', [App\Http\Controllers\UserController::class, 'logout']);
    Route::apiResource('user', App\Http\Controllers\UserController::class);
    Route::put('/updatePassword/{user}',[\App\Http\Controllers\UserController::class,'updatePassword']);
    Route::put('/updatepermisos/{user}',[\App\Http\Controllers\UserController::class,'updatepermisos']);
    Route::resource('/permiso',\App\Http\Controllers\PermisoController::class);
    Route::post('/cambioEstado/{id}',[\App\Http\Controllers\UserController::class,'cambioEstado']);

    Route::apiResource('camara', App\Http\Controllers\CamaraController::class);
    //Route::apiResource('caracteristicas', App\Http\Controllers\InspectionController::class);
    Route::apiResource('tuberias', App\Http\Controllers\TuberiaController::class);
    Route::apiResource('inspection', App\Http\Controllers\InspectionController::class);
    Route::apiResource('detalle', App\Http\Controllers\DetalleController::class);
    Route::get('/listDiamts',[\App\Http\Controllers\InspectionController::class,'listDiamts']);
    Route::get('/listDiamplg',[\App\Http\Controllers\InspectionController::class,'listDiamplg']);
    Route::get('/listDiametro',[\App\Http\Controllers\SewerController::class,'listDiametro']);

    Route::get('/listMaterial',[\App\Http\Controllers\CamaraController::class,'listMaterial']);
    Route::get('/listRasante',[\App\Http\Controllers\CamaraController::class,'listRasante']);
    Route::get('/reporte',[\App\Http\Controllers\CamaraController::class,'reporte']);

    Route::apiResource('sewer', App\Http\Controllers\SewerController::class);
    Route::apiResource('pipeline', App\Http\Controllers\PipelineController::class);
    Route::apiResource('sumidero', App\Http\Controllers\SumideroController::class);
    Route::apiResource('conducto', App\Http\Controllers\ConductoController::class);
    
    Route::get('/reporte',[\App\Http\Controllers\CamaraController::class,'reporte']);
    Route::get('/listSewer',[\App\Http\Controllers\SewerController::class,'listSewer']);

    
    Route::get('/listMatPl',[\App\Http\Controllers\SewerController::class,'listMatPl']);
    Route::get('/listRasPl',[\App\Http\Controllers\SewerController::class,'listRasPl']);
    
});


