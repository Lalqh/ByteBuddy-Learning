<?php
require_once __DIR__ . '/Database/conector.php';
require_once __DIR__ . '/Database/utils.php';
require_once __DIR__ . '/Generals/responses.php';
require_once __DIR__ . '/Generals/objects.php';
require_once __DIR__ . '/Auth/jwtManager.php';

$db = DB::getInstance()->getConnection();
$jwt = new JwtManager();
$CorrectToken = true;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($jwt->verifyJwt()) {
        if ($_POST["req"] === "get_users") {
            $crud = new Crud($db);
            $result = $crud->select("*", "usuarios");
            if (!$result) {
                $response = new Response("error", "Error al obtener los usuarios");
            } else {
                $response = new Response("ok", "Usuarios obtenidos con existo", DB::setQueryToArray($result));
            }
        }
    } else {
        $CorrectToken = false;
        $response = new Response("error", "Con el token");

    }
}

$response->send($CorrectToken);

?> 