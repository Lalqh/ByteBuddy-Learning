<?php

require_once('helpers.php');
require_once(__DIR__ . '/../Auth/jwtManager.php');

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

    public function updatePassowrd($idUser)
    {
        $crud = new Crud($this->dbConnection);
        $updateData = $crud->update('usuarios', "contrasena", $this->password, $idUser);
        return $updateData;
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
            return DB::setQueryToArray($result);

        } catch (Exception $e) {
            return $e;
        }
    }

    public function login($passwordInDb, $passwordFrom, $dataUser)
    {
        if (password_verify($passwordFrom, $passwordInDb)) {
            $token = $this->classJwt->createJwt($dataUser[0]['id'], $dataUser[0]['idTipoUsuario']);
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
    private $img;

    public function __construct($courseArray)
    {
        $this->name = $courseArray["name"];
        $this->description = $courseArray["description"];
        $this->price = $courseArray["price"];
        $this->img = $courseArray["img_src"];
    }
    public function getData()
    {
        return [
            "nombre" => $this->name,
            "descripcion" => $this->description,
            "precio" => $this->price,
            "img_src" => $this->img
        ];
    }
}

?>