<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class DomPDFService
{
    public function generatePDF(string $htmlContent): string
    {
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        
        $dompdf->loadHtml($htmlContent);
        $dompdf->render();

        
        $pdfOutput = $dompdf->output();
        $tempPdfPath = sys_get_temp_dir() . '/documento_' . uniqid() . '.pdf';
        file_put_contents($tempPdfPath, $pdfOutput);

        return $tempPdfPath;
    }
}
