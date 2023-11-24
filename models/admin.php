<?php
require_once __DIR__ . '/Database/conector.php';
require_once __DIR__ . '/Database/utils.php';
require_once __DIR__ . '/Generals/responses.php';
require_once __DIR__ . '/Generals/objects.php';

$db = DB::getInstance()->getConnection();

if($_SERVER["REQUEST_METHOD"] === "POST"){
    if ($_POST["req"] === "get_users") {
        $crud = new Crud($db);
        $result = $crud->select("*", "usuarios");
        if (!$result) {
            $response = new Response("error", "Error al obtener los cursos");
        } else {
            $response = new Response("ok", "Cursos obtenidos con éxito", DB::setQueryToArray($result));
        }
    }
}

$response->send();

?>