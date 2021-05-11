<?php

use App\Http\Controllers\ApartamentoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvisosController;
use App\Http\Controllers\BoletosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\LocatarioController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\OcorrenciaController;
use App\Http\Controllers\ProprietariosController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Base Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function (){ return 'homepage'; });


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
// Route::post('change-password', [AuthController::class, 'logout']);



/*
|--------------------------------------------------------------------------
| APP Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['apiJwt', 'permission']], function() {

    Route::get('dashboard', [DashboardController::class, 'index']);
    
    //Admin
    Route::apiResource('usuarios', UserTypeController::class);
    Route::apiResource('permissoes', UserTypeController::class);
    Route::apiResource('modulos', ModulosController::class);
    Route::apiResource('apartamentos', ApartamentoController::class);

    
    //Ambos
    Route::apiResource('locatarios', LocatarioController::class);
    Route::apiResource('ocorrencias', OcorrenciaController::class);
    
    Route::apiResource('avisos', AvisosController::class);
    
    Route::apiResource('proprietarios', ProprietariosController::class);
    Route::apiResource('documentos', DocumentosController::class);
    Route::apiResource('boletos', BoletosController::class);

});