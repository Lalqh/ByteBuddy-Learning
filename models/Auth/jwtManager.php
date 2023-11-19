<?php

require __DIR__ . '/../../vendor/autoload.php';

use \Firebase\JWT\JWT;

class JwtManager
{
    private $secretKey;
    private $expirationTime;

    public function __construct()
    {
        $this->secretKey = "1234";
        $this->expirationTime = time() + (14 * 24 * 60 * 60); // 14 días
    }

    public function createJwt($uuid)
    {
        $tokenData = array(
            "id" => $uuid
        );

        try {
            $token = JWT::encode(
                array_merge($tokenData, ["exp" => $this->expirationTime]),
                $this->secretKey,
                'HS256' // Algoritmo de encriptación
            );
            return $token;
        } catch (Error $e) {
            return false;
        }
    }

    public function verifyJwt($token)
    {
        try {
            $decodedToken = JWT::decode($token, $this->secretKey, array('HS256'));
            $tokenData = (array) $decodedToken;
            return ($tokenData);
        } catch (Exception $e) {
            return false;
        }
    }
}