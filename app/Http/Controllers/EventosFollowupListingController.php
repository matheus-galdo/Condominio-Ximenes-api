<?php

namespace App\Http\Controllers;

use App\Models\Ocorrencia\EventoFollowup;
use Illuminate\Http\Request;

class EventosFollowupListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarEventosFollowup(Request $request)
    {
        if (auth()->user()->typeName->is_admin) {
            return response(EventoFollowup::all());
        }
    }

}
