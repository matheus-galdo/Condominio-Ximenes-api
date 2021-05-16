<?php

namespace App\Services;
use \Smalot\PdfParser\Parser;

class PdfToStringService{

    public static function parseFile($filePath)
    {
        // Parse pdf file and build necessary objects.
        $parser = new Parser();
        $pdf    = $parser->parseFile($filePath);
        
        $text = $pdf->getText();
        
        $regex = ["/\\t/m", "/\\n/m", "/\\s/m"];
        $sub = ["\t", PHP_EOL, " "];

        for ($i=0; $i <= 2; $i++) { 
            $text = preg_replace($regex[$i], $sub[$i], $text);
        }

        $text = str_replace("\/", "/", $text);
        
        return $text;
    }
}

