<?php

require_once('helpers.php');
require_once('./Auth/jwtManager.php');

class User
{
    private $uuid;
    private $userName;
    private $password;
    private $email;
    private $dbConnection;
    private $helper;
    private $classJwt;

    public function __construct($userName = "", $password = "", $email = "")
    {
        $options = array(
            'cost' => 10
        );
        $this->userName = $userName;
        $this->password = password_hash($password, PASSWORD_BCRYPT, $options);
        $this->email = $email;
        $this->dbConnection = Db::getInstance()->getConnection();
        $this->helper = new Helper();
        $this->classJwt = new JwtManager();
    }
    public function create()
    {
        $crud = new Crud($this->dbConnection);
        $dataUser = [
            'id' => $this->helper->generateUuidv4(),
            'correo' => $this->email,
            'contrasena' => $this->password,
            'nombre' => $this->userName
        ];
        $insertData = $crud->insert('usuarios', $dataUser);
        return $insertData;
    }

    public function exists()
    {
        $crud = new Crud($this->dbConnection);
        $email = $crud->getDbConnection()->real_escape_string($this->email); // Escapar el valor para prevenir SQL injection

        try {
            $result = $crud->select('COUNT(*) as count, contrasena, id, idTipoUsuario', 'usuarios', "correo = '$email'");

            if ($result === false) {
                throw new Exception("Error en la consulta: " . $crud->dbConnection->error);
            }

            $row = $result->fetch_assoc();
            $exists = $row['count'] > 0; // Si count es mayor que 0, el usuario existe

            $data = [
                'exists' => $exists,
                'contrasena' => $exists ? $row['contrasena'] : null,
                'id' => $exists ? $row['id'] : null,
                'idTipoUsuario' => $exists ? $row['idTipoUsuario'] : null
            ];

            return $data;

        } catch (Exception $e) {
            return $e;
        }
    }

    public function login($passwordInDb, $passwordFrom, $dataUser)
    {
        if (password_verify($passwordFrom, $passwordInDb)) {
            $token = $this->classJwt->createJwt($dataUser['id']);
            return $token;
        } else {
            return false;
        }
    }
}

class Course
{
    private $name;
    private $description;
    private $price;

    public function __construct($courseArray)
    {
        $this->name = $courseArray["name"];
        $this->description = $courseArray["description"];
        $this->price = $courseArray["price"];
    }
    public function getData()
    {
        return [
            "nombre" => $this->name,
            "descripcion" => $this->description,
            "precio" => $this->price
        ];
    }
}

?>