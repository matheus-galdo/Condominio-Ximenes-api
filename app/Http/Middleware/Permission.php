<?php

namespace App\Http\Middleware;

use App\Models\Sistema\Modulos;
use Closure;
use Illuminate\Http\Request;

class Permission
{

    public const RESOURCE_OPERATIONS = [
        'GET' => 'visualizar',
        'PUT' => 'gerenciar',
        'POST' => 'criar',
        'PATCH' => 'editar',
        'DELETE' => 'excluir'
    ];


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $user = auth()->userOrFail();
        $operation = self::RESOURCE_OPERATIONS[strtoupper($request->method())];


        $requestedURI = collect(explode('/', $request->path()));
        $requestedResource = ($requestedURI->pop());

        if ((int) $requestedResource > 0) {
            $requestedResource = $requestedURI->pop();
        }


        $modulo = Modulos::with(['permissoes'])->where('nome', $requestedResource)->first();
        
        // return response($requestedResource);
        
        $moduloPermissoes = $modulo->permissoes->firstWhere('user_type_id', $user->type);

        if (!$moduloPermissoes->$operation) {
            return response()->json(['status' => "You don't have permission to access this resource"], 403);
        }

        return $next($request);
    }
}
