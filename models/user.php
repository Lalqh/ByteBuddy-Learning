<?php
require_once __DIR__ . '/Database/conector.php';
require_once __DIR__ . '/Database/utils.php';
require_once __DIR__ . '/Generals/responses.php';
require_once __DIR__ . '/Generals/objects.php';
require_once __DIR__ . '/Auth/jwtManager.php';
//use Course;

$db = DB::getInstance()->getConnection();
$jwt = new JwtManager();
$CorrectToken = true;


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($jwt->verifyJwt()) {
        if ($_POST["req"] === "getInfoUser") {
            $crud = new Crud($db);
            $infoUser = $jwt->getJwt();
            $data = $infoUser["id"];
            $result = $crud->select("nombre", "usuarios", "id = '$data'");
            if (!$result) {
                $response = new Response("error", "Error al obtener el usuario");
            } else {
                $response = new Response("ok", "Usuario obtenido", DB::setQueryToArray($result));
            }
        }
    } else {
        $CorrectToken = false;
        $response = new Response("error", "Con el token");
    }
    $response->send($CorrectToken);
}
