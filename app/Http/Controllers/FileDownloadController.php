<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boleto;
use App\Models\Documento;
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
        // return response(['a' => $documentoId]);

        $documento = Boleto::find($request->file);

        return Storage::download($documento->path);

        $user = auth()->user();
        return response(['a' => $documento]);

        if (!$user->tipeName->is_admin) {
            //baixar
        }

        return response('alo');
    }
}
