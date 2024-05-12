<?php

require __DIR__ . '/../../vendor/autoload.php';

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

    public function createPdf($html, $userId)
    {
        $this->mpdf->loadHtml($html);
        $this->mpdf->render();
        $pdfContent = $this->mpdf->output();

        if (!empty($pdfContent)) {
            $filename = 'recibo_compra_' . uniqid() . '.pdf';
            $webdavPath = 'pdf/' . $userId . '/' . $filename;
            $this->uploadToWebDAV($pdfContent, $webdavPath);
            return 'http://10.0.0.4/' . $webdavPath;
        }

        return false;
    }

    private function uploadToWebDAV($pdfContent, $webdavPath)
{
    $directoryPath = dirname($webdavPath);

    $response = $this->webdavClient->request('PROPFIND', $directoryPath);
    
    if ($response['statusCode'] === 404) {
        
        $this->webdavClient->request('MKCOL', $directoryPath);
    }
   

    $response = $this->webdavClient->request('PUT', $webdavPath, $pdfContent);
    
    if ($response['statusCode'] !== 201) {
        throw new Exception('Error al cargar el archivo al servidor WebDAV');
    }
}

public function getRecibos($userId)
{
    $webdavPath = 'pdf/' . $userId . '/';
    $directoryPath = dirname($webdavPath);

    $response = $this->webdavClient->request('PROPFIND', $directoryPath, [
        'headers' => [
            'Depth' => '1',
            'Content-Type' => 'text/xml', // Especifica el tipo de contenido XML
        ],
        'body' => '<?xml version="1.0" encoding="utf-8"?>
                    <D:propfind xmlns:D="DAV:">
                        <D:prop>
                            <D:getcontentlength />
                            <D:getlastmodified />
                            <D:creationdate />
                            <D:resourcetype />
                            <D:getetag />
                        </D:prop>
                    </D:propfind>',
    ]);


    var_dump($webdavPath);
    var_dump($response);
    exit();

    return $archivos;
}



}
