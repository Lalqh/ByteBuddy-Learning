<?php
require_once('helpers.php');
require_once('responses.php');
class User
{
    private $uuid;
    private $userName;
    private $password;
    private $email;
    private $dbConnection;
    private $helper;

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
            $result = $crud->select('COUNT(*) as count', 'usuarios', "correo = '$email'");

            if ($result === false) {
                throw new Exception("Error en la consulta: " . $crud->dbConnection->error);
            }

            $row = $result->fetch_assoc();
            return $row['count'] > 0; // Si count es mayor que 0, el usuario existe
        } catch (Exception $e) {
            $response = new Response('Error', $e->getMessage());
            return false;
        }
    }


}

?>