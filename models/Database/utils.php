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
            return "Error insert: " . $e->getMessage();
        }
    }
    
    public function update(string $table, string $column, $value, $id)
    {
        $sql = "UPDATE $table SET $column = '$value' WHERE id = '$id'";
        try {
            $result = $this->dbConnection->query($sql);
            if ($result === false) {
                throw new Exception("Error en la consulta: " . $this->dbConnection->error);
            }
            return $result;
        } catch (Exception $e) {
            return "Error update: " . $e->getMessage();
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
            return "Error select: " . $e->getMessage();
        }
    }

    public function delete(string $table, string $id)
    {
        $sql = "UPDATE $table SET _status = 'trash' WHERE id = '$id'";
        try {
            $result = $this->dbConnection->query($sql);
            if ($result === false) {
                throw new Exception("Error en la consulta: " . $this->dbConnection->error);
            }
            return $result;
        } catch (Exception $e) {
            return "Error update: " . $e->getMessage();

        }
    }
    public function getMaxId(string $table)
    {
        $sql = "SELECT MAX(id) as id FROM $table";
        try {
            $result = $this->dbConnection->query($sql);
            if ($result === false) {
                throw new Exception("Error en la consulta: " . $this->dbConnection->error);
            }
            return $result;
        } catch (Exception $e) {
            return "Error select Max: " . $e->getMessage();
        }
    }
}
?>