<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatMensagensResource;
use App\Models\Chat\ChatSindica;
use App\Repositories\ChatSindicaMensagensRepository;
use App\Repositories\ChatSindicaRepository;
use Illuminate\Http\Request;

class MensagensChatController extends Controller
{
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
    }


    public function createMessage(Request $request)
    {
        $response = ChatSindicaMensagensRepository::create($request);
        $user = auth()->user();
        $userChat = ChatSindica::with('mensagens.autor')->find($response['chat']->id);

        if ((!$user->typeName->is_admin && $userChat->proprietario_id != $user->proprietario->id)) {
            return response()->json(["status" => "You don't have permission to access this resource"], 403);
        }

        if(empty($userChat)){
            return response()->json([]);
        }
        	
        return response()->json(ChatMensagensResource::collection($userChat->mensagens), 201);
    }
    

    public function deleteMessage($messageId)
    {
        $response = ChatSindicaMensagensRepository::delete($messageId);
        return response($response, $response['code']);
    }
}
