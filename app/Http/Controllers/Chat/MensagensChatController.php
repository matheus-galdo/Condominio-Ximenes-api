<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatMensagensResource;
use App\Models\Chat\ChatSindica;
use App\Models\Chat\ChatSindicaMensagens;
use App\Models\User;
use App\Repositories\ChatSindicaMensagensRepository;
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


        if(isset($request->last_message_id) && !empty($request->last_message_id)){
            $userChat = ChatSindica::with(['mensagens' => function ($builder) use($request){
                return $builder->where('chat_sindica_mensagens.id', '>', $request->last_message_id)->with('autor', 'chatSindica');
            }])->find($response['chat']->id);

        }else{
            $userChat = ChatSindica::with('mensagens.autor', 'mensagens.chatSindica')->find($response['chat']->id);
        }

        if ((!$user->typeName->is_admin && $userChat->proprietario_id != $user->proprietario->id)) {
            return response()->json(["status" => "You don't have permission to access this resource"], 403);
        }

        if(empty($userChat)){
            return response()->json([]);
        }
        	
        return response()->json(($userChat->mensagens), 201);
        return response()->json(ChatMensagensResource::collection($userChat->mensagens), 201);
    }
    

    public function lookForNewMessages(Request $request, $lastReceivedMessageId)
    {
        $user = User::find(auth()->user()->id);
        
        $lastMessage = ChatSindicaMensagens::findOrFail($lastReceivedMessageId);

        $userChat = ChatSindica::with(['mensagens' => function ($builder) use($lastReceivedMessageId){
            return $builder->where('chat_sindica_mensagens.id', '>', $lastReceivedMessageId)->with('autor');
        }])->find($lastMessage->chat_sindica_id);

        if ((!$user->typeName->is_admin && $userChat->proprietario_id != $user->proprietario->id)) {
            return response()->json(["status" => "You don't have permission to access this resource"], 403);
        }

        return response()->json($userChat->mensagens);
    }
}
