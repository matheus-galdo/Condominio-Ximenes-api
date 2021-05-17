<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatProprietariosResource;
use App\Http\Resources\Chat\ChatWithProprietariosResource;
use App\Http\Resources\Proprietarios\UserProprietarioResource;
use App\Models\Chat\ChatSindica;
use App\Models\Proprietario;
use App\Repositories\ChatSindicaMensagensRepository;
use App\Repositories\ChatSindicaRepository;
use Illuminate\Http\Request;
use stdClass;

class ChatSindicaControllere extends Controller
{
    
    public function index(Request $request, $chatId)
    {
        $user = auth()->user();

        if ($user->typeName->is_admin) {
            $proprietarios = UserProprietarioResource::collection(Proprietario::has('chatSindica')->with(['apartamentos', 'user'])->get());
            $proprietariosWithoutChat = ChatProprietariosResource::collection(Proprietario::doesntHave('chatSindica')->with(['apartamentos', 'user'])->get());
            
            
            return response()->json(ChatWithProprietariosResource::collection($proprietarios));
        }

        $stdAdmin = new stdClass();
        $stdAdmin->user_id = 0;
        $stdAdmin->id = 0;
        $stdAdmin->name = 'Síndica';
        $stdAdmin->type = 0;

        return response()->json($stdAdmin);

        // $user = auth()->user();

        // if ($user->typeName->is_admin) {
        //     // $proprietarios = UserProprietarioResource::collection(Proprietario::doesntHave('chatSindica')->with(['apartamentos', 'user'])->get());
        //     // return response()->json(($proprietarios));
        //     return response()->json(ChatProprietariosResource::collection($proprietarios));
        // }

        // $stdAdmin = new stdClass();
        // $stdAdmin->user_id = 0;
        // $stdAdmin->id = 0;
        // $stdAdmin->name = 'Síndica';
        // $stdAdmin->type = 0;

        // return response()->json($stdAdmin);
    }

    public function loadMessages(Request $request, $chatId)
    {
        $user = auth()->user();
        $userChat = ChatSindica::with('mensagens')->find($chatId);

        if ((!$user->typeName->is_admin && $userChat->proprietario_id != $user->proprietario->id)) {
            return response()->json(["status" => "You don't have permission to access this resource"], 403);
        }

        if(empty($userChat)){
            return response()->json([]);
        }
        	
        return response()->json($userChat);

        // if ($userChat->proprietario_id == $user->proprietario->id) {
        //     return response()->json($userChat->mensagens());
        // }


        return response()->json('aee boa', 200);


        // $mensagens = $chat->mensagens();
        // return response()->json($mensagens);
    }

    public function deleteChat(Request $request, $chatId)
    {
        
    }
}
