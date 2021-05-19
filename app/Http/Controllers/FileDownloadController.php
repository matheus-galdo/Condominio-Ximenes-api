<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boleto;
use App\Models\Documento;
use App\Models\Ocorrencia\EventoFollowupAnexos;
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
     * @param  \Illuminate\Http\Request  $request
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

        if ($request->module == 'ocorrencia') {
            return $this->downloadAnexoOcorrencia($request) ;
        }



        return response()->json(['error' => 'requested file not found'], 400);
    }


    /**
     * Download the document file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function downloadDocumento(Request $request)
    {
        $documento = Documento::find($request->file);
        return Storage::download($documento->path, $documento->nome_original, self::DOWNLOAD_FILENAME_HEADER);
    }


    /**
     * Download the PDF file for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function downloadBoleto(Request $request)
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


    /**
     * Download the PDF file for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function downloadAnexoOcorrencia(Request $request)
    {
        $user = auth()->user();
        $file = EventoFollowupAnexos::find($request->file);

        if ($user->typeName->is_admin) {
            return Storage::download($file->path, $file->nome_original, self::DOWNLOAD_FILENAME_HEADER);
        }

        $proprietarioApartamentosId = $user->proprietario->apartamentos->pluck('id')->toArray();

        // return $proprietarioApartamentosId;
        return $file->ocorrenciaFollowup->ocorrencia->apartamento;
        if(in_array($file->ocorrenciaFollowup->ocorrencia->apartamento->id,$proprietarioApartamentosId)){
            return Storage::download($file->path, $file->nome_original, self::DOWNLOAD_FILENAME_HEADER);
        }
        
        return response()->json(['error' => 'você não pode acessar este arquivo'], 400);
    }
}
