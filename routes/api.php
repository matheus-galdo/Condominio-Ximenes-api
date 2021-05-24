<?php

use App\Http\Controllers\ApartamentoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvisosController;
use App\Http\Controllers\BoletosController;
use App\Http\Controllers\Chat\ChatSindicaController;
use App\Http\Controllers\Chat\ContatosChatController;
use App\Http\Controllers\Chat\MensagensChatController;
use App\Http\Controllers\ChatPortaria\ChatPortariaController;
use App\Http\Controllers\ChatPortaria\MensagensChatController as ChatPortariaMensagensChatController;
use App\Http\Controllers\Contas\ContasController;
use App\Http\Controllers\ContatosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\EventosFollowupListingController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\HorariosFuncionamentoController;
use App\Http\Controllers\LocatarioController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\OcorrenciaController;
use App\Http\Controllers\OcorrenciaFollowupController;
use App\Http\Controllers\ProprietariosController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegrasNormasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeListingController;
use App\Http\Controllers\UserTypeController;
use App\Mail\LocatarioCadastrado;
use App\Models\Locatario;
use App\Models\LocatarioConvidado;
use App\Services\SearchAndFilter\SearchAndFilter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Base Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return response()->json(['status' => 'ok', 'code' => 200]);
});

Route::get('teste-mail', function () {

    Mail::send(new LocatarioCadastrado(Locatario::get()->first()));

    // return response(dump(SearchAndFilter::teste(new LocatarioConvidado())));

    // $mail = new LocatarioCadastrado();
    // return $mail;
    // Mailer::send($mail);
    // Mail::send(new LocatarioCadastrado());
});

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

Route::group(['middleware' => ['apiJwt', 'permission']], function () {

    //Everyone - interno do sistema
    Route::get('listar-permissoes-admin', [UserTypeListingController::class, 'listarUsersAdmin']);               #ok
    Route::get('listar-permissoes-user', [UserTypeListingController::class, 'listarUsers']);                     #ok
    Route::get('listar-eventos-ocorrencia', [EventosFollowupListingController::class, 'listarEventosFollowup']); #ok
    Route::get('listar-apartamentos', [ApartamentoController::class, 'index']);                                  #ok
    Route::get('download-file', [FileDownloadController::class, 'downloadFile']);                                #ok


    //Admin
    Route::apiResource('usuarios', UserController::class);                 # ok
    Route::apiResource('permissoes', UserTypeController::class);           # ok
    Route::apiResource('modulos', ModulosController::class);               # ok
    Route::apiResource('apartamentos', ApartamentoController::class);      # ok
    Route::apiResource('proprietarios', ProprietariosController::class);   # ok


    //Ambos
    Route::get('dashboard', [DashboardController::class, 'index']);         # ok
    Route::apiResource('locatarios', LocatarioController::class);           # ok
    Route::apiResource('avisos', AvisosController::class);                  # ok
    Route::apiResource('documentos', DocumentosController::class);          # ok
    Route::apiResource('boletos', BoletosController::class);                # ok


    //ocorrencias
    Route::apiResource('ocorrencias', OcorrenciaController::class);         # ok
    Route::apiResource('ocorrencias-followup', OcorrenciaFollowupController::class, ['except' => ['index']]);  # ok

    Route::apiResource('prestacao-contas', ContasController::class);        
    
    
    //Chat
    Route::get('chat-sindica', [ChatSindicaController::class, 'index']);
    Route::get('chat-sindica/{id}', [ChatSindicaController::class, 'show']);
    Route::get('contatos-chat-sindica', [ContatosChatController::class, 'chatSindica']);
    Route::post('chat-sindica-mensagens', [MensagensChatController::class, 'createMessage']);


    Route::get('chat-portaria', [ChatPortariaController::class, 'index']);
    Route::get('chat-portaria/{id}', [ChatPortariaController::class, 'show']);
    Route::get('contatos-chat-portaria', [ContatosChatController::class, 'chatPortaria']);
    Route::post('chat-portaria-mensagens', [ChatPortariaMensagensChatController::class, 'createMessage']);




    //informações básicas
    Route::get('regras-normas', [RegrasNormasController::class, 'index']);              #ok
    Route::patch('regras-normas', [RegrasNormasController::class, 'update']);           #ok

    Route::get('contatos', [ContatosController::class, 'index']);                       #ok
    Route::patch('contatos', [ContatosController::class, 'update']);                    #ok

    Route::get('funcionamento', [HorariosFuncionamentoController::class, 'index']);     #ok
    Route::patch('funcionamento', [HorariosFuncionamentoController::class, 'update']);  #ok 
});
