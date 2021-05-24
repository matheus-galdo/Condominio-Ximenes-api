<?php

namespace App\Http\Controllers\ChatPortaria;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatMensagensResource;
use App\Models\Chat\ChatPortaria;
use App\Repositories\ChatPortariaMensagensRepository;
use Illuminate\Http\Request;

class MensagensChatController extends Controller
{
    public function loadMessages(Request $request, $chatId)
    {
        $user = auth()->user();
        $userChat = ChatPortaria::with('mensagens')->find($chatId);

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
        $response = ChatPortariaMensagensRepository::create($request);
        $user = auth()->user();
        $userChat = ChatPortaria::with('mensagens.autor')->find($response['chat']->id);

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
        $response = ChatPortariaMensagensRepository::delete($messageId);
        return response($response, $response['code']);
    }
}
