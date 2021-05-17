<?php

use App\Http\Controllers\ApartamentoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvisosController;
use App\Http\Controllers\BoletosController;
use App\Http\Controllers\Chat\ChatSindicaController;
use App\Http\Controllers\Chat\ContatosChatController;
use App\Http\Controllers\Chat\MensagensChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\LocatarioController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\OcorrenciaController;
use App\Http\Controllers\ProprietariosController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeListingController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
Route::post('novo-proprietario', [RegisterController::class, 'register']);
// Route::post('change-password', [AuthController::class, 'logout']);



/*
|--------------------------------------------------------------------------
| APP Routes
|--------------------------------------------------------------------------
*/

Route::get('file-teste', function () {

    return Storage::download('userFiles/bear.png');
    return response(['ta la' => Storage::exists('userFiles/bear.png')]);
    
    return response(url('/salame'));
});

Route::group(['middleware' => ['apiJwt', 'permission']], function() {

    //Everyone
    Route::get('listar-permissoes-admin', [UserTypeListingController::class, 'listarUsersAdmin']);
    Route::get('listar-permissoes-user', [UserTypeListingController::class, 'listarUsers']);

    Route::get('download-file', [FileDownloadController::class, 'downloadFile']);

    
    //Admin
    Route::apiResource('usuarios', UserController::class);
    Route::apiResource('permissoes', UserTypeController::class);
    Route::apiResource('modulos', ModulosController::class);
    Route::apiResource('apartamentos', ApartamentoController::class);
    Route::apiResource('proprietarios', ProprietariosController::class);

    
    //Ambos
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::apiResource('locatarios', LocatarioController::class);
    Route::apiResource('ocorrencias', OcorrenciaController::class);
    
    Route::apiResource('avisos', AvisosController::class);
    
    Route::apiResource('documentos', DocumentosController::class);


    Route::apiResource('boletos', BoletosController::class);


    //Chat
    
    
    Route::get('chat-sindica', [ChatSindicaController::class, 'index']);
    Route::get('chat-sindica/{id}', [ChatSindicaController::class, 'show']);
    
    Route::get('contatos-chat-sindica', [ContatosChatController::class, 'chatSindica']);
    
    Route::post('chat-sindica-mensagens', [MensagensChatController::class, 'createMessage']);

});