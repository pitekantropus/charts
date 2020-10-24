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
}
?>