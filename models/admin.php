<?php
require_once __DIR__ . '/Database/conector.php';
require_once __DIR__ . '/Database/utils.php';
require_once __DIR__ . '/Generals/responses.php';
require_once __DIR__ . '/Generals/objects.php';
require_once __DIR__ . '/Auth/jwtManager.php';
require_once __DIR__ . '/Generals/email.php';
require_once __DIR__ . '/Generals/helpers.php';

$db = DB::getInstance()->getConnection();
$email = new Email();
$helper = new Helper();
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
        } else if ($_POST["req"] === "send_mail") {
            $crud = new Crud($db);
            $newPassword = $helper->generateNewPassoword(5);
            $user = new User("", $newPassword);
            if ($user->updatePassowrd($_POST['id'])) {
                $ok = $email->sendEmail($_POST['email'], "Tu contraseña a sido reiniciada", $newPassword);
                if ($ok) {
                    $response = new Response("ok", "La contraseña se restablecio con exito");
                } else {
                    $response = new Response("error", "La conntraseña de restablecio correctamente, pero no se pudo enviar el correo");
                }
            } else {
                $response = new Response("error", "Ocurrio un error a el restablecer la contraseña");
            }
        } else if ($_POST["req"] === "change_type") {
            $newType = $_POST["type"] === "1" ? "2" : "1";
            $crud = new Crud($db);
            $result = $crud->update("usuarios", "idTipoUsuario", $newType, $_POST["id"]);
            if ($result) {
                $response = new Response("ok", "El tipo de usuario se actualizo de manera correcta");
            } else {
                $response = new Response("error", "Ocurrio un error a el actualizar el tipo de usuario");
            }
        } else if ($_POST["req"] === "change_password") {
            $dataUser = $jwt->getJwt();
            $user = new User("", $_POST["password"]);
            if ($user->updatePassowrd($dataUser["id"])) {
                $response = new Response("ok", "La contraseña se actualizo con exito");
            } else {
                $response = new Response("error", "Ocurrio un error a el actualiazr la contraseña");
            }
        }
    } else {
        $CorrectToken = false;
        $response = new Response("error", "Con el token");

    }
}

$response->send($CorrectToken);

?>