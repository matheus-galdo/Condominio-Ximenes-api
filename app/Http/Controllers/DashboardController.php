<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Repositories\AvisoRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Aviso::where('data_expiracao', '>=', Carbon::now())->orWhereNull('data_expiracao')->get();
    }
}
