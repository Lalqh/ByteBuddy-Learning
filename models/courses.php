<?php
require_once __DIR__ . '/Database/conector.php';
require_once __DIR__ . '/Database/utils.php';
require_once __DIR__ . '/Generals/responses.php';
require_once __DIR__ . '/Generals/objects.php';
//use Course;

$db = DB::getInstance()->getConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["req"] === "create") {
        $course = new Course([
            "name" => $_POST["nombreCurso"],
            "price" => $_POST["precioCurso"],
            "description" => $_POST["descripcionCurso"]
        ]);
        $crud = new Crud($db);
        $result = $crud->insert('Cursos', $course->getData());
        if (!$result) {
            $response = new Response("error", "Error al crear el curso");
        } else {
            $response = new Response("ok", "Curso creado exitosamente!");
        }
    }
}

$response->send();
?>