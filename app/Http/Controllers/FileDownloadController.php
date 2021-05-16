<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boleto;
use App\Models\Documento;
use App\Services\PdfParser;
use App\Services\PdfToStringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller

{
    private const DOWNLOAD_FILENAME_HEADER = ["Access-Control-Expose-Headers" =>"Content-Disposition"];

    /**
     * Download the requested file.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function downloadFile(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'module' => 'required'
        ]);


        if ($request->module == 'documento') {
            return $this->downloadDocumento($request) ;
        }

        if ($request->module == 'boleto') {
            return $this->downloadBoleto($request) ;
        }



        return response()->json(['error' => 'requested file not found'], 400);
    }


    /**
     * Download the document file.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function downloadDocumento($request)
    {
        $documento = Documento::find($request->file);
        return Storage::download($documento->path, $documento->nome_original, self::DOWNLOAD_FILENAME_HEADER);
    }


    /**
     * Download the PDF file for the resource.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */

    public function downloadBoleto($request)
    {
        $user = auth()->user();
        $documento = Boleto::find($request->file);

        if ($user->typeName->is_admin) {
            return Storage::download($documento->path, $documento->nome_original, self::DOWNLOAD_FILENAME_HEADER);
        }

        $proprietarioApartamentosId = $user->proprietario->apartamentos->pluck('id')->toArray();

        if(in_array($documento->apartamento_id,$proprietarioApartamentosId)){
            return Storage::download($documento->path, $documento->nome_original, self::DOWNLOAD_FILENAME_HEADER);
        }
        
        return response()->json(['error' => 'você não pode acessar este arquivo'], 400);
    }
}
