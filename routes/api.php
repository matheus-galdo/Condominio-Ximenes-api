<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocatarioController;
use App\Http\Controllers\OcorrenciaController;
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
Route::group(['middleware' => ['apiJwt']], function() {

    Route::get('users', function () { return auth()->user(); });

    Route::apiResource('locatario', LocatarioController::class);
    Route::apiResource('ocorrencia', OcorrenciaController::class);

});