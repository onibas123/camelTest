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
        $conn = mysqli_connect($this->server, $this->username, $this->password, $this->database);

        if (!$conn)
            die("Connection failed: " . mysqli_connect_error());

        return $conn;
    }

    public function db_close($conn)
    {
        mysqli_close($conn);
    }
}
?>