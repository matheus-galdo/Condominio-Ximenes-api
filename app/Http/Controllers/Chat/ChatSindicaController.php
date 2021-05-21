<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatMensagensResource;
use App\Http\Resources\Chat\ChatProprietariosResource;
use App\Http\Resources\Chat\ChatProprietariosResourceWithChat;
use App\Http\Resources\Chat\ChatWithProprietariosResource;
use App\Http\Resources\Proprietarios\UserProprietarioResource;
use App\Models\Chat\ChatSindica;
use App\Models\Proprietario;
use App\Models\User;
use Illuminate\Http\Request;

class ChatSindicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->typeName->is_admin) {
            $proprietarios = ChatProprietariosResourceWithChat::collection(Proprietario::has('chatSindica')
                ->with(['apartamentos', 'user', 'chatSindica'])->whereHas('user', function ($builder) {
                    $builder->where('users.deleted_at', null);
                })->get());

            $proprietariosWithoutChat = ChatProprietariosResource::collection(Proprietario::doesntHave('chatSindica')
                ->with(['apartamentos', 'user'])->whereHas('user', function ($builder) {
                    $builder->where('users.deleted_at', null);
                })->get());

            $proprietarios = $proprietarios->merge($proprietariosWithoutChat);

            return response()->json($proprietarios);
        }

        $user = User::with('proprietario')->find($user->id);
        $chat = ChatSindica::where('proprietario_id', $user->proprietario->id)->first();

        $stdAdmin = new \stdClass();
        $stdAdmin->user_id = $user->id;
        $stdAdmin->id = 0;
        $stdAdmin->name = 'Síndica';
        $stdAdmin->type = 0;

        if (!empty($chat)) {
            $stdAdmin->chat = $chat;
        }

        return response()->json([$stdAdmin]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($chatId)
    {
        $user = auth()->user();
        $userChat = ChatSindica::with('mensagens.autor')->find($chatId);

        if ((!$user->typeName->is_admin && $userChat->proprietario_id != $user->proprietario->id)) {
            return response()->json(["status" => "You don't have permission to access this resource"], 403);
        }

        if (empty($userChat)) {
            return response()->json([]);
        }

        return response()->json(ChatMensagensResource::collection($userChat->mensagens));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
