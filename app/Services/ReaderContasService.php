<?php

namespace App\Services;

use Carbon\Carbon;

class ReaderContasService{

    public static function parseFile($filePath)
    {
        $pdfText = PdfToStringService::parseFile($filePath);

        return $pdfText;
        $reCodigoDeBarras = "/07790.[0-9]+.*[0-9]{14}/";
        preg_match_all($reCodigoDeBarras, $pdfText, $codigoDeBarrasMatchs , PREG_SET_ORDER, 0);



        $reVencimento = "/Vencimento ([0-9]{2}\/[0-9]{2}\/[0-9]{4})/";
        preg_match_all($reVencimento, $pdfText, $vencimentoMatchs , PREG_SET_ORDER, 0);
        
        
        $reValor = "/Valor do Documento ([0-9]+,[0-9]{2})/";
        preg_match_all($reValor, $pdfText, $valorMatchs , PREG_SET_ORDER, 0);

        $vencimento = $vencimentoMatchs[0][1];
        $valor = $valorMatchs[0][1];
        $codigoDeBarras = $codigoDeBarrasMatchs[0][0];
        $codigoDeBarras = str_replace('  ',' ', $codigoDeBarras);

        return [Carbon::createFromFormat('d/m/Y', $vencimento), (float) $valor, $codigoDeBarras];

    }
}

