<?php

namespace App\Http\Controllers\ChatPortaria;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\ChatProprietariosResource;
use App\Http\Resources\Chat\ChatWithProprietariosResource;
use App\Http\Resources\ProprietarioResource;
use App\Http\Resources\Proprietarios\UserProprietarioResource;
use App\Models\Chat\ChatSindica;
use App\Models\Proprietario;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class ContatosChatController extends Controller
{
    public function chatSindica()
    {
        $user = auth()->user();

        if ($user->typeName->is_admin) {
            $proprietarios = Proprietario::doesntHave('chatSindica')->with(['apartamentos', 'user'])->get();
            // $proprietarios = UserProprietarioResource::collection(Proprietario::doesntHave('chatSindica')->with(['apartamentos', 'user'])->get());
            // return response()->json(($proprietarios));
            return response()->json(ChatProprietariosResource::collection($proprietarios));
        }

        $stdAdmin = new stdClass();
        $stdAdmin->user_id = 0;
        $stdAdmin->id = 0;
        $stdAdmin->name = 'Síndica';
        $stdAdmin->type = 0;

        return response()->json($stdAdmin);
    }

    public function chatPortaria()
    {
        $user = auth()->user();

        if ($user->typeName->is_admin) {
            $proprietarios = Proprietario::doesntHave('chatPortaria')->with(['apartamentos', 'user'])->get();
            // $proprietarios = UserProprietarioResource::collection(Proprietario::doesntHave('chatSindica')->with(['apartamentos', 'user'])->get());
            // return response()->json(($proprietarios));
            return response()->json(ChatProprietariosResource::collection($proprietarios));
        }

        $stdAdmin = new stdClass();
        $stdAdmin->user_id = 0;
        $stdAdmin->id = 0;
        $stdAdmin->name = 'Portaria';
        $stdAdmin->type = 0;

        return response()->json($stdAdmin);
    }
}
