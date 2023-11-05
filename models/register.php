<?php

require_once 'conector.php';
require_once 'Utils.php';

$db = Db::getInstance();
$conexion = $db->getConnection();
$crud = new Crud($conexion);

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
        $response = array('respuesta' => 'registrado');
    } else {
        $registerOk = registerUser($name, $email, $encrypt, $crud);
        if ($registerOk) {
            $response = array('respuesta' => 'correcto');
        } else {
            $response = array('respuesta' => 'error');
        }
    }

    echo json_encode($response);
} else {
    $response = array('respuesta' => 'error');
    echo json_encode($response);
}

function getExistUser($email, $crud) {
    $email = $crud->getDbConnection()->real_escape_string($email); // Escapar el valor para prevenir SQL injection
    try {
        $result = $crud->select('COUNT(*) as count', 'usuarios', "correo = '$email'");

        if ($result === false) {
            throw new Exception("Error en la consulta: " . $crud->dbConnection->error);
        }

        $row = $result->fetch_assoc();
        return $row['count'] > 0; // Si count es mayor que 0, el usuario existe
    } catch (Exception $e) {
        echo "Error usuarioExiste: " . $e->getMessage();
        return false;
    }
}

function registerUser($name, $email, $password, $crud) {
    $dataUser = [
        'id' => generateUuidv4(),
        'correo' => $email,
        'contrasena' => $password,
        'nombre' => $name
    ];

    $insertData = $crud->insert('usuarios', $dataUser);
    return $insertData;
}

function generateUuidv4()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    mt_rand(0, 0xffff), mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0x0fff) | 0x4000,
    mt_rand(0, 0x3fff) | 0x8000,
    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

?>
