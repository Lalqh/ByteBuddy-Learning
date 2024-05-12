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
    $response = $this->webdavClient->request('PROPFIND', $webdavPath);

    var_dump($response);
    exit();


    $pdfPaths = [];

    if ($response['statusCode'] === 207) {
        $xml = $response['body'];
        $dom = new DOMDocument();
        $dom->loadXML($xml);

        $files = $dom->getElementsByTagName('d:href');
        foreach ($files as $file) {
            $filePath = urldecode($file->nodeValue);
            if (substr($filePath, -1) !== '/') {
                if (strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) === 'pdf') {
                    $pdfPaths[] = 'http://10.0.0.4/' . $filePath;
                }
            }
        }
    }

    return $pdfPaths;
}


}
