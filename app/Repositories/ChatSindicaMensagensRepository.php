<?php

namespace App\Repositories;

use App\Http\Resources\Chat\ChatMensagensResource;
use App\Models\Chat\ChatSindica;
use App\Models\Chat\ChatSindicaMensagens;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ChatSindicaMensagensRepository
{

    /**
     * create
     *
     * @param  mixed $request
     * @return void
     */
    public static function create($request)
    {
        // return ['status' => $user, 'code' => 201];

        try {
            $chat = DB::transaction(function () use ($request) {
                $user = User::findOrFail(auth()->user()->id);

                if (isset($request->proprietario)) {
                    if ((!$user->typeName->is_admin && $request->proprietario != $user->proprietario->id)) {
                        throw new \Exception("You don't have permission to access this resource", 403);
                    }

                    $chat = ChatSindica::where('proprietario_id', $request->proprietario)->first();
                } else {
                    $chat = ChatSindica::where('proprietario_id', $user->proprietario->id)->first();
                }

                if (empty($chat)) {
                    $chat = ChatSindica::create([
                        'proprietario_id' => isset($request->proprietario) ? $request->proprietario : $user->proprietario->id
                    ]);
                }

                if (isset($request->arquivos)) {

                    $fileAnexo = collect();
                    try {
                        foreach ($request->arquivos as $file) {

                            $filePath = $file->store('userFiles/messages');

                            $anexo = ChatSindicaMensagens::create([
                                'autor_mensagem' => $user->id,
                                'chat_sindica_id' => $chat->id,
                                'mensagem' => " ",
                                'mensagem_admin' => $user->typeName->is_admin,
                                'anexo' => $filePath,
                                'tipo_anexo' => $file->getMimeType(),
                                'extensao' => $file->extension(),
                                'nome_original' => $file->getClientOriginalName()
                            ]);

                            $fileAnexo->push($filePath);
                        }
                    } catch (\Throwable $th) {
                        foreach ($fileAnexo as $filePath) {
                            Storage::delete($filePath);
                        }
                        throw $th;
                    }
                } else {
                    ChatSindicaMensagens::create([
                        'autor_mensagem' => $user->id,
                        'chat_sindica_id' => $chat->id,
                        'mensagem' => $request->mensagem,
                        'mensagem_admin' => $user->typeName->is_admin,
                    ]);
                }


                return $chat;
            });

            return ['status' => true, 'chat' => $chat, 'code' => 201];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }

    public static function delete($messageId)
    {
        try {
            $user = auth()->user();
            $message = ChatSindicaMensagens::find($messageId)->firstOrFail();

            if ($message->autor_mensagem != $user->id) {
                throw new \Exception("You don't have permission to access this resource", 403);
            }

            $message->delete();

            return ['status' => true, 'code' => 200];
        } catch (\Throwable $th) {
            return exceptionApi($th, 400);
        }
    }
}
