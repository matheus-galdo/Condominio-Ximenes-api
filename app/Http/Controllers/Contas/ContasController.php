<?php

namespace App\Http\Controllers\Contas;

use App\Http\Controllers\Controller;
use App\Repositories\ContasRepository;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class ContasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //listas todas as contas existentes
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $parser = new Parser();
        $filePath = $request->arquivos->store('userFiles/pretacao_contas');
        $pdf    = $parser->parseFile(storage_path('app/' . $filePath));
        
        $text = $pdf->getText();
        return response()->json(['content' => $text]);

        return $text;

        
        $response = ContasRepository::create($request);
        return response()->json(['content' => $response]);
        // return response($response, $response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
