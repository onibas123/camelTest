<?php
require_once('../config/Database.php');
class UsersModel {
  
    private $db; 
    function __construct()
    {
        $this->db = new Database();
    } 

    public function login($user, $password)
    {
        $conn = $this->db->db_connect();
        $query = 'SELECT users.id as id, users.user as user, users.password as password, DATE_FORMAT(users.last_access, "%d-%m-%Y %H:%i:%s") as last_access, roles.id as rol_id,  roles.rol as rol FROM users inner join roles on roles.id = users.roles_id WHERE users.user = "'.$user.'" AND users.password = "'.$password.'" LIMIT 1';
        $result = mysqli_query($conn, $query);
        $this->db->db_close($conn);
        return $result;
    }

    public function update_last_access($id, $last_access)
    {
        $conn = $this->db->db_connect();
        $query = 'UPDATE users set last_access = "'.$last_access.'" WHERE id = '.$id;
        $result = mysqli_query($conn, $query);
        $this->db->db_close($conn);
        return $result;
    }

    public function add_session($users_id, $access_way, $token, $created, $exp)
    {
        $conn = $this->db->db_connect();
        $query = 'INSERT INTO sessions (users_id, access_way, token, created, exp) VALUES ('.$users_id.', "'.$access_way.'", "'.$token.'", "'.$created.'", "'.$exp.'")';
        $result = mysqli_query($conn, $query);
        $this->db->db_close($conn);
        return $result;
    }
}

?>