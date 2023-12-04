<?php
class Db
{
    private static $instance;
    private $connection;

    // private $host = '64.20.36.19';
    // private $username = 'u32759_0pF4s7NULd';
    // private $password = 'Qbb5u8eGuA9RK2w5Vw+5UbRY';
    // private $database = 's32759_ByteBuddyLearning';

    private $host = 'localhost';
    private $username = 'root';
    private $password = 'Admin1*';
    private $database = 's32759_bytebuddylearning';

    // Constructor privado para prevenir instanciación directa
    private function __construct()
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

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