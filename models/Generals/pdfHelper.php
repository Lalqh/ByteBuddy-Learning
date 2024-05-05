<?php

require _DIR_ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Sabre\DAV\Client;

class PdfHelper
{
    private $mpdf;
    private $webdavClient;

    public function __construct()
    {
        $this->mpdf = new Dompdf();
        $this->webdavClient = new Client([
            'baseUri' => 'http://10.0.0.4/',
            'userName' => 'lalo',
            'password' => '1234',
        ]);
    }

    public function testConnection()
    {
        try {
            // Intenta obtener el listado de archivos en el directorio raíz del servidor WebDAV
            $response = $this->webdavClient->propFind('/', ['{DAV:}getcontentlength']);
            
            // Si no hay excepción, la conexión se estableció correctamente
            echo "Conexión al servidor WebDAV establecida correctamente.\n";
            echo "Listado de archivos en el directorio raíz:\n";
            foreach ($response as $name => $properties) {
                echo "- $name\n";
            }
        } catch (\Exception $e) {
            // Si hay una excepción, muestra el mensaje de error
            echo "Error al conectar al servidor WebDAV: " . $e->getMessage() . "\n";
        }
    }

    public function createPdf($html, $userId)
    {
        $this->mpdf->loadHtml($html);
        $this->mpdf->render();
        $pdfContent = $this->mpdf->output();
        
        if (!empty($pdfContent)) {
            $filename = 'recibo_compra_' . uniqid() . '.pdf';
            $webdavPath = '/pdf/' . $userId . '/' . $filename;
            $this->uploadToWebDAV($pdfContent, $webdavPath);
            return $webdavPath;
        }
        
        return false;
    }

    private function uploadToWebDAV($pdfContent, $webdavPath)
    {
        $this->webdavClient->put($webdavPath, $pdfContent);
    }
}
