<?php
//declare(strict_types=1);
class Crud
{
    private $dbConnection;
    public function __construct($conn = null)
    {
        $this->dbConnection = $conn;
    }

    public function getDbConnection()
    {
        return $this->dbConnection;
    }

    public function insert(string $table, array $array)
    {
        $keys = array_keys($array);
        $keys = implode(', ', $keys);
        $values = "";
        foreach ($array as $index => $value) {
            $values .= "'" . $value . "',";
        }
        $values = rtrim($values, ',');
        $sql = "INSERT INTO $table($keys) VALUES($values)";
        try {
            $result = $this->dbConnection->query($sql);
            if ($result)
                return $result;
            else
                return false;
        } catch (Exception $e) {
            echo "Error insert: " . $e->getMessage();
            return false;
        }
    }
    public function update(string $table, string $column, string|int $id)
    {
        $sql = "UPDATE $table SET $column = concat($column,$id) WHERE id = $id";
        try {
            $result = $this->dbConnection->query($sql);
            if ($result === false) {
                throw new Exception("Error en la consulta: " . $this->dbConnection->error);
            }
            return $result;
        } catch (Exception $e) {
            echo "Error update: " . $e->getMessage();
            return false;
        }

    }
    public function select(string $columns = "*", string $table, string $conditionals = "true")
    {
        $sql = "SELECT $columns FROM $table WHERE $conditionals";
        try {
            $result = $this->dbConnection->query($sql);
            if ($result === false) {
                throw new Exception("Error en la consulta: " . $this->dbConnection->error);
            }
            return $result;
        } catch (Exception $e) {
            echo "Error select: " . $e->getMessage();
            exit();
        }
    }

    public function delete(string $columns = "*", string $table, string $conditionals = "false")
    {
        $sql = "DELETE $columns FROM $table WHERE $conditionals";
        try {
            $result = $this->dbConnection->query($sql);
            if ($result === false) {
                throw new Exception("Error en la consulta: " . $this->dbConnection->error);
            }
            return $result;
        } catch (Exception $e) {
            echo "Error select: " . $e->getMessage();
            return false;
        }
    }

}
?>