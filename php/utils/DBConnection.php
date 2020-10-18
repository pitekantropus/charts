<?php
class DBConnection {
    private const DB_SERVER = 'localhost';
    private const DB_USERNAME = 'id15055296_wykresy_user';
    private const DB_PASSWORD = 'Mastodont24!';
    private const DB_NAME = 'id15055296_wykresy';

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
}
?>