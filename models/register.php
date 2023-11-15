<?php

require_once './Database/conector.php';
require_once './Database/utils.php';
require_once './Generals/helpers.php';
require_once './Generals/responses.php';
require_once './Generals/objects.php';

$db = Db::getInstance()->getConnection();
$crud = new Crud($db);
$helper = new Helper();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    // Encriptar la contraseña

    $user = new User($name, $password, $email);

    if ($user->exists()) {
        $response = new Response("exist", "Este usuario ya existe, inicia sesión o crea otro usuario");
    } else {

        if ($user->create()) {
            $response = new Response("ok", "Te has registrado de manera correcta");
        } else {
            $response = new Response("error", "Ocurrio un error al registrarte");
        }
    }
} else {
    $response = new Response("error", "Ocurrio un error");

}

$response->send();

// function getExistUser($email, $crud)
// {
//     $email = $crud->getDbConnection()->real_escape_string($email); // Escapar el valor para prevenir SQL injection
//     try {
//         $result = $crud->select('COUNT(*) as count', 'usuarios', "correo = '$email'");

//         if ($result === false) {
//             throw new Exception("Error en la consulta: " . $crud->dbConnection->error);
//         }

//         $row = $result->fetch_assoc();
//         return $row['count'] > 0; // Si count es mayor que 0, el usuario existe
//     } catch (Exception $e) {
//         return $response->send("error", "Ocurrio un error");
//     }
// }

// function registerUser($name, $email, $password, $crud)
// {
//     $dataUser = [
//         'id' => $helper->generateUuidv4(),
//         'correo' => $email,
//         'contrasena' => $password,
//         'nombre' => $name
//     ];
//     $insertData = $crud->insert('usuarios', $dataUser);
//     return $insertData;
//}
?>