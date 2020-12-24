<?php
require_once './config/Database.php';
class UsersModel {
  
    private $db; 
    function __construct()
    {
        parent::__construct();
        $this->db = new Database();
    } 
  
    public function getUsers()
    {
        $conn = $this->db->db_connect();

        $query = 'SELECT users.id as id, users.user as user, DATE_FORMAT(users.last_access, "%d-%m-%Y") as last_access, roles.id as rol_id,  roles.rol as rol FROM users inner join roles on roles.id = users.rol_id';
        $result = mysqli_query( $conn, $query);
        /*
        while ($columna = mysqli_fetch_array( $resultado ))
        {
            echo "<tr>";
            echo "<td>" . $columna['id'] . "</td>";
            echo "<td>" . $columna['rut'] . "-".$columna['dv']."</td>";
            echo "<td>" . $columna['name'] . "</td>";
            echo "<td>" . $columna['grade'] . "</td>";
            echo "<td>" . $columna['birthdate'] . "</td>";
            echo "</tr>";
        }
        */
        $this->db->db_close($conn);
        return $result;
    }
}

?>