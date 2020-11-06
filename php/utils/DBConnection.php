<?php
class DBConnection {
    private const DB_SERVER = 'localhost';
    private const DB_USERNAME = 'dobrewykresy';
    private const DB_PASSWORD = 'Australopitek24!';
    private const DB_NAME = 'dobre_wykresy';

    public $connection;

    function __construct() {
        $this->connection = new mysqli(self::DB_SERVER, self::DB_USERNAME, self::DB_PASSWORD, self::DB_NAME);
        if($this->connection->connect_error) {
            die('Connect Error (' . $this->connection->connect_errno . ') '
                    . $this->connection->connect_error);
        }
    }

    public function query($query) {
        $result = $this->connection->query($query);
        if(!$result) {
            printf('Query error: %s', $this->connection->error);
        }
        return $result;
    }

    public function safeString($string) {
        return $this->connection->real_escape_string(htmlspecialchars(trim($string)));
    }

    public function lastId() {
        return $this->connection->insert_id;
    }

    public function fetchSingleRowById($table, $id) {
        return $this->fetchSingleRow($table, 'id', $id);
    }

    public function fetchSingleRow($table, $column, $value) {
        $result = $this->connection->query("SELECT * FROM $table WHERE $column = '$value'");
        if($result && $result->num_rows == 1) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function fetchFromTable($table, $columns, $conditions = null) {
        $query = "SELECT $columns FROM $table";
        if(!is_null($conditions)) {
            $query .= " WHERE $conditions";
        }
        $result = $this->connection->query($query);
        if(!$result) {
            return null;
        }
        $array = array();
        while($row = $result->fetch_assoc()) {
            $array[] = $row;
        }
        return $array;
    }

    public function insertIntoTable($table, $valuesMap) {
        $columns = '';
        $values = '';
        foreach($valuesMap as $column => $value) {
            $columns .= "$column, ";
            $values .= "'$value, ";
        }
        $columns = substr($columns, 0, -2);
        $values = substr($values, 0, -2);
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        $result = $this->connection->query($query);
        if(!$result) {
            return false;
        }
        return true;
    }

    public function updateTable($table, $valuesMap, $conditions) {
        $query = "UPDATE $table SET";
        foreach($valuesMap as $column => $value) {
            $query .= " $column = '$value',";
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE $conditions";
        $result = $this->connection->query($query);
        if(!$result) {
            return false;
        }
        return true;
    }
}
?>