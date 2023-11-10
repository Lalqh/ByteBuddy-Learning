<?php

require_once './Database/conector.php';
require_once './Database/utils.php';
require_once './Generals/helpers.php';
require_once './Generals/responses.php';

$db = Db::getInstance();
$conexion = $db->getConnection();
$crud = new Crud($conexion);
$helper = new Helpers();
$response = new Responses();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    $options = array(
        'cost' => 10
    );

    // Encriptar la contraseña
    $encrypt = password_hash($password, PASSWORD_BCRYPT, $options);

    if (getExistUser($email, $crud)) {
        $response->sendResponse("exist", "Este usuario ya existe, inicia sesión o crea otro usuario");
    } else {
        $registerOk = registerUser($name, $email, $encrypt, $crud);
        if ($registerOk) {
            $response->sendResponse("ok", "Te has registrado de manera correcta");
        } else {
            $response->sendResponse("error", "Ocurrio un error");
        }
    }
} else {
    $response->sendResponse("error", "Ocurrio un error");
}

function getExistUser($email, $crud)
{
    $email = $crud->getDbConnection()->real_escape_string($email); // Escapar el valor para prevenir SQL injection
    try {
        $result = $crud->select('COUNT(*) as count', 'usuarios', "correo = '$email'");

        if ($result === false) {
            throw new Exception("Error en la consulta: " . $crud->dbConnection->error);
        }

        $row = $result->fetch_assoc();
        return $row['count'] > 0; // Si count es mayor que 0, el usuario existe
    } catch (Exception $e) {
        return $response->sendResponse("error", "Ocurrio un error");
    }
}

function registerUser($name, $email, $password, $crud) {
    $dataUser = [
        'id' => $helper->generateUuidv4(),
        'correo' => $email,
        'contrasena' => $password,
        'nombre' => $name
    ];
    $insertData = $crud->insert('usuarios', $dataUser);
    return $insertData;
}
?>
