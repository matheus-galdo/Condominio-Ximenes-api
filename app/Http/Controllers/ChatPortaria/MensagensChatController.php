<?php

namespace App\Http\Controllers\ChatPortaria;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatMensagensResource;
use App\Models\Chat\ChatPortaria;
use App\Models\Chat\ChatPortariaMensagens;
use App\Models\User;
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

        if(isset($request->last_message_id) && !empty($request->last_message_id)){
            $userChat = ChatPortaria::with(['mensagens' => function ($builder) use($request){
                return $builder->where('chat_portaria_mensagens.id', '>', $request->last_message_id)->with('autor');
            }])->find($response['chat']->id);

        }else{
            $userChat = ChatPortaria::with('mensagens.autor')->find($response['chat']->id);
        }


        if ((!$user->typeName->is_admin && $userChat->proprietario_id != $user->proprietario->id)) {
            return response()->json(["status" => "You don't have permission to access this resource"], 403);
        }

        if(empty($userChat)){
            return response()->json([]);
        }
        	
        return response()->json(ChatMensagensResource::collection($userChat->mensagens), 201);
    }
    

    public function lookForNewMessages(Request $request, $lastReceivedMessageId)
    {
        $user = User::find(auth()->user()->id);
        
        $lastMessage = ChatPortariaMensagens::findOrFail($lastReceivedMessageId);

        $userChat = ChatPortaria::with(['mensagens' => function ($builder) use($lastReceivedMessageId){
            return $builder->where('chat_portaria_mensagens.id', '>', $lastReceivedMessageId)->with('autor');
        }])->find($lastMessage->chat_portaria_id);

        if ((!$user->typeName->is_admin && $userChat->proprietario_id != $user->proprietario->id)) {
            return response()->json(["status" => "You don't have permission to access this resource"], 403);
        }

        return response()->json($userChat->mensagens);
    }
}
