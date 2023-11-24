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

    $user = new User("", "", $email);
    $data = $user->exists();
    if ($data) {
       $token =  $user->login($data[0]['contrasena'], $password ,$data);
       if ($token) {
        $response = new Response("ok", "se inicion sesion", array("token"=> $token, "typeUser"=> $data[0]['idTipoUsuario']));
       }else{
        $response = new Response("error", "La contraseña ingresada es incorrecta");
       }
       
    } else {
        $response = new Response("error", "Este usuario no se encuentra registrado.");
    }
} else {
    $response = new Response("error", "Ocurrio un error");
}

$response->send();