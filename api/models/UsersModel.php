<?php
require_once('../config/Database.php');
class UsersModel {
  
    private $db; 
    function __construct()
    {
        $this->db = new Database();
    } 

    public function auth($user, $password)
    {
        /*
        $conn = $this->db->db_connect();
        $query = 'SELECT users.id as id, users.user as user, users.password as password, DATE_FORMAT(users.last_access, "%d-%m-%Y %H:%i:%s") as last_access, roles.id as rol_id,  roles.rol as rol FROM users inner join roles on roles.id = users.roles_id WHERE users.user = "'.$user.'" AND users.password = "'.$password.'" LIMIT 1';
        $result = mysqli_query($conn, $query);
        $this->db->db_close($conn);
        return $result;
        */


    }
}

?>