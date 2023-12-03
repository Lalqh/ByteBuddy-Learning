<?php
require_once __DIR__ . '/Database/conector.php';
require_once __DIR__ . '/Database/utils.php';
require_once __DIR__ . '/Generals/responses.php';
require_once __DIR__ . '/Generals/objects.php';
//use Course;

$db = DB::getInstance()->getConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["req"] === "create") {
        $crud = new Crud($db);
        $image = $_FILES["imgCourse"]["name"] ?? '';
        $imageType = $_POST["imgType"];
        $tmpPath = $_FILES["imgCourse"]["tmp_name"];
        $imgData = '';
        if (!empty($tmpPath)) {
            $imgData = file_get_contents($tmpPath);
        }
        $imgData = base64_encode($imgData);
        $course = new Course([
            "name" => $_POST["nombreCurso"],
            "price" => $_POST["precioCurso"],
            "description" => $_POST["descripcionCurso"],
            "img_src" => $imageType . $imgData
        ]);
        $result = $crud->insert('Cursos', $course->getData());
        if (!$result) {
            $response = new Response("error", "Error al crear el curso");
        } else {
            $result = DB::setQueryToArray($crud->getMaxId('Cursos'));
            $response = new Response("ok", "Curso creado exitosamente!", $result);
        }
    } else if ($_POST["req"] === "get_courses") {
        $crud = new Crud($db);
        $result = $crud->select("*", "Cursos", "_status = 'post'");
        if (!$result) {
            $response = new Response("error", "Error al obtener los cursos");
        } else {
            $response = new Response("ok", "Cursos obtenidos con éxito", DB::setQueryToArray($result));
        }
    } else if ($_POST["req"] === "edit_course") {
        $crud = new Crud($db);
        $result = $crud->update("Cursos", $_POST["column"], $_POST["value"], $_POST["id"]);
        if (!$result) {
            $response = new Response("error", "Error al actualizar el curso: " . $result);
        } else {
            $response = new Response("ok", "Curso actualizado con éxito");
        }
    } else if ($_POST["req"] === "delete_course") {
        $crud = new Crud($db);
        $result = $crud->delete("Cursos", $_POST["id"]);
        if (!$result) {
            $response = new Response("error", "Error al eliminar el curso: " . $result);
        } else {
            $response = new Response("ok", "Curso eliminado con éxito");
        }
    } else if ($_POST["req"] === "edit_file") {
        $crud = new Crud($db);
        $image = $_FILES["imgCourse"]["name"] ?? '';
        $imageType = $_POST["imgType"];
        $tmpPath = $_FILES["imgCourse"]["tmp_name"];
        $imgData = '';
        if (!empty($tmpPath)) {
            $imgData = file_get_contents($tmpPath);
        }
        $imgData = base64_encode($imgData);
        $result = $crud->update('Cursos', 'img_src', $imageType . $imgData, $_POST["id"]);
        if (!$result) {
            $response = new Response("error", "Error al editar la imagen" . $result);
        } else {
            $response = new Response("ok", "Imagen actualizada con éxito");
        }
    } else if ($_POST["req"] === "get_course") {
        $crud = new Crud($db);
        $result = $crud->select("*", "Cursos", "id =" . $_POST['course_id']);
        if (!$result) {
            $response = new Response('error', 'Error al obtener el curso' . $result);
        } else {
            $response = new Response('ok', 'Curso obtenido con éxito', DB::setQueryToArray($result));
        }
    }
}

$response->send();
?>