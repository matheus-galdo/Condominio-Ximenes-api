<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Repositories\AvisoRepository;
use App\Services\SearchAndFilter\SearchAndFilter;
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

        $avisosBuilder = (new Aviso)->newQuery();
        $avisosBuilder = $avisosBuilder->where('data_expiracao', '>=', Carbon::now())->orWhereNull('data_expiracao');

        if ($request->page) return response($avisosBuilder->paginate(15));
        return $avisosBuilder->get();

    }
}
