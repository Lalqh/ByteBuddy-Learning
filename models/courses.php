<?php
require_once __DIR__ . '/Database/conector.php';
require_once __DIR__ . '/Database/utils.php';
require_once __DIR__ . '/Generals/responses.php';
require_once __DIR__ . '/Generals/objects.php';
require_once __DIR__ . '/Auth/jwtManager.php';
require_once __DIR__ . '/Generals/pdfHelper.php';
require_once __DIR__ . '/Generals/plantillas.php';

//use Course;

$db = DB::getInstance()->getConnection();
$jwt = new JwtManager();
$pdf = new PdfHelper();
$plantilla = new plantillas();
$CorrectToken = true;


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($jwt->verifyJwt()) {
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
        } else if ($_POST["req"] === "buy") {
            $crud = new Crud($db);
            $infoUser = $jwt->getJwt();
            $idUser = $infoUser["id"];

            $array = json_decode($_POST['cursos'], true);

            if ($array != null) {
                foreach ($array as $curso) {
                    $data = ["idUsuario" => $idUser, "idCurso" => $curso["id"]];
                    $result = $crud->insert("RelCursosUsuarios", $data);
                    if (!$result) {
                        $response = new Response('error', 'Ocurrio un error a el obtener el curso');
                    }
                }
                $html = $plantilla->getPlantillaGeneral();
                foreach ($array as $curso) {
    $html .= '<div class="item" style="margin-bottom: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <div class="name" style="font-weight: bold; color: #007bff; font-size: 18px;">Curso:</div>
                <div style="margin-top: 5px; font-size: 16px;">' . $curso['nombre'] . '</div>
            </div>
            <div class="item" style="margin-bottom: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <div class="name" style="font-weight: bold; color: #007bff; font-size: 18px;">Descripción:</div>
                <div style="margin-top: 5px; font-size: 16px;">' . $curso['descripcion'] . '</div>
            </div>
            <div class="item" style="margin-bottom: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <div class="name" style="font-weight: bold; color: #007bff; font-size: 18px;">Precio:</div>
                <div style="margin-top: 5px; font-size: 16px;">' . $curso['precio'] . '</div>
            </div>
            <hr style="border-color: #ccc; margin: 30px 0;">';
}

                // Generar el PDF
                $userData = $crud->select('correo', 'usuarios', "id = '$idUser'");
                $info = DB::setQueryToArray($userData);

                $url = $pdf->createPdf($html, $idUser, $info[0]['correo']);

                if($url == false){
                    $response = new Response('error', 'Error a el generar el pdf');
                }else{
                    $response = new Response('ok', 'Acabas de adquirir el curso', $url);
                }

            } else {
                $response = new Response('error', 'No hay cursos en el carrito');
            }
        } else if ($_POST["req"] === "my_courses") {
            $crud = new Crud($db);
            $infoUser = $jwt->getJwt();
            $data = $infoUser["id"];
            $result = $crud->select('c.id, c.nombre, c.descripcion, c.img_src', 'Cursos as c INNER JOIN RelCursosUsuarios  as r ON c.id = r.idCurso', "idUsuario = '$data'");
            if (!$result) {
                $response = new Response('error', 'Error al obtener tus cursos');
            } else {
                $response = new Response('ok', 'Cursos obtenidos con exito', DB::setQueryToArray($result));
            }
        }else if($_POST["req"] === "recibos"){
            $infoUser = $jwt->getJwt();
            $id = $infoUser["id"];
            $typeUser = $infoUser["tipoUsuario"];
            
            $info = [];

            if($typeUser == 3){
                $info = $pdf->getAllRecibos();
            }else{
                $info = $pdf->getRecibos($id);
            }
            
            $response = new Response('ok', 'Cursos obtenidos con exito', $info);
        }
    } else {
        $CorrectToken = false;
        $response = new Response("error", "Con el token");
    }
}

$response->send($CorrectToken);
