<?php

require __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;

class PdfHelper
{
    private $mpdf;

    public function __construct()
    {
        $this->mpdf =  new Dompdf();
    }

    public function createPdf($html)
    {
        $this->mpdf->loadHtml($html);
        $this->mpdf->render();
        $filename = 'recibo_compra_' . uniqid() . '.pdf';
        $pdfPath = __DIR__ . '/../../pdf/' . $filename;
        file_put_contents($pdfPath, $this->mpdf->output());
        return $pdfPath;
        
    }
}
