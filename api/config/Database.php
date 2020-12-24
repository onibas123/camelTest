<?php
class Database {
    private $server;
    private $database;
    private $username;
    private $password;

    function __construct()
    {
        $this->server = 'localhost';
        $this->database = 'camel';
        $this->username = 'root';
        $this->password = '';
    }

    public function db_connect()
    {
        $conn = new mysqli($this->server, $this->username, $this->password, $this->database);

        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);

        return $conn;
    }

    public function db_close($conn)
    {
        $conn->close();
    }
}
?>