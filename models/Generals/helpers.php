<?php

/**
 * Summary of Helper
 */
class Helper
{

    /**
     * Summary of __construct
     */
    public function __construct()
    {
    }

    /**
     * Summary of generateUuidv4
     * @return string
     */
    public function generateUuidv4()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
    public function generateNewPassoword($longitud = 10)
    {
        $caracteresPermitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitudCaracteres = strlen($caracteresPermitidos);
        $cadenaAleatoria = '';
        for ($i = 0; $i < $longitud; $i++) {
            $indiceAleatorio = random_int(0, $longitudCaracteres - 1);
            $caracterAleatorio = $caracteresPermitidos[$indiceAleatorio];
            $cadenaAleatoria .= $caracterAleatorio;
        }
        return $cadenaAleatoria;
    }
}