<?php
class Db
{
    private static $instance;
    private $connection;
 
    // private $host = '64.20.36.19';
    // private $username = 'u32759_0pF4s7NULd';
    // private $password = 'Qbb5u8eGuA9RK2w5Vw+5UbRY';
    // private $database = 's32759_ByteBuddyLearning';

    private $host = '10.0.0.5';
    private $username = 'bytebuddy';
    private $password = '1234';
    private $database = 'bytebuddy';


    // Constructor privado para prevenir instanciación directa
    private function __construct()
    {
        //puerto 3306
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        //puerto 3307
        //$this->connection = new mysqli($this->host, $this->username, $this->password, $this->database, 3307);
        if ($this->connection->connect_error) {
            die("Error de conexión: " . $this->connection->connect_error);
        }
    }

    // Método para obtener la instancia única
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

    // Método para obtener la conexión a la base de datos
    public function getConnection()
    {
        return $this->connection;
    }
    public static function setQueryToArray($object)
    {
        $arr = [];
        while ($row = $object->fetch_assoc()) {
            array_push($arr, $row);
        }
        return $arr;
    }
}

?>