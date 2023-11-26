<?php

require __DIR__ . '/../../vendor/autoload.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtManager
{
    private $secretKey;
    private $expirationTime;
    private $token;

    public function __construct()
    {
        $this->secretKey = "1234";
        $this->expirationTime = time() + (14 * 24 * 60 * 60); // 14 días
    }

    public function createJwt($uuid, $typeUser)
    {
        $tokenData = array(
            "id" => $uuid,
            "tipoUsuario" => $typeUser
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
    public function verifyJwt()
{
    $headers = apache_request_headers();
    if (isset($headers['Authorization'])) {
        $authHeader = $headers['Authorization'];
        if (preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            $token = $matches[1];
            try {
                $decodedToken = JWT::decode($token, new Key($this->secretKey, 'HS256'));
                $tokenData = (array) $decodedToken;
                $this->token = $tokenData;
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }
    return false;
}  
    public function getJwt()
    {
        return $this->token;
    }
}