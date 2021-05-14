<?php

namespace App\Http\Controllers;

use App\Models\Sistema\Modulo;
use App\Models\Sistema\Modulos;
use Illuminate\Http\Request;

class ModulosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Modulos::acessableModulos()->get());
    }
}
