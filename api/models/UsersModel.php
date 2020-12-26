<?php
require_once('./config/Database.php');
class UsersModel {
  
    private $db; 
    function __construct()
    {
        $this->db = new Database();
    } 
    //#################### [INI AUTHORIZATION & SESSION] ###########################################################
    public function authentication($user, $password)
    {
        $conn = $this->db->db_connect();

        $sql = 'SELECT users.id as id, users.user as user, users.password as password, DATE_FORMAT(users.last_access, "%d-%m-%Y %H:%i:%s") as last_access, roles.id as rol_id,  roles.rol as rol FROM users inner join roles on roles.id = users.roles_id WHERE users.user = ? AND users.password = ? LIMIT 1;';
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("ss", $user, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close(); 
        $this->db->db_close($conn);
        return $result;
    }

    public function update_last_access($id, $last_access)
    {
        $conn = $this->db->db_connect();
        $query = 'UPDATE users set last_access = "'.$last_access.'" WHERE id = '.$id.';';
        $result = mysqli_query($conn, $query);
        $this->db->db_close($conn);
        return $result;
    }

    public function add_session($users_id, $access_way, $token, $created, $exp)
    {
        $conn = $this->db->db_connect();
        $query = 'INSERT INTO sessions (users_id, access_way, token, created, exp) VALUES ('.$users_id.', "'.$access_way.'", "'.$token.'", "'.$created.'", "'.$exp.'");';
        $result = mysqli_query($conn, $query);
        $this->db->db_close($conn);
        return $result;
    }
    //#################### [END AUTHORIZATION & SESSION] ###########################################################

    //#################### [INI CRUD] ##############################################################################
    public function getUserById($id)
    {
        $conn = $this->db->db_connect();
        $sql = 'SELECT users.id as id, users.user as user, DATE_FORMAT(users.last_access, "%d-%m-%Y %H:%i:%s") as last_access, roles.id as rol_id,  roles.rol as rol FROM users inner join roles on roles.id = users.roles_id WHERE users.id = ? LIMIT 1;';
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close(); 
        $this->db->db_close($conn);
        return $result;
    }

    public function getAllUsers()
    {
        $conn = $this->db->db_connect();
        $sql = 'SELECT users.id as id, users.user as user, DATE_FORMAT(users.last_access, "%d-%m-%Y %H:%i:%s") as last_access, roles.id as rol_id,  roles.rol as rol FROM users inner join roles on roles.id = users.roles_id ORDER BY users.id;';
        $stmt = $conn->prepare($sql); 
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        $this->db->db_close($conn);
        return $result;
    }

    public function add($user, $password, $last_access, $roles_id)
    {
        $conn = $this->db->db_connect();
        $sql = 'INSERT INTO users (user, password, last_access, roles_id) VALUES (?, ?, ?, ?);';
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("sssi", $user, $password, $last_access, $roles_id);
        $result = $stmt->execute();

        $stmt->close(); 
        $this->db->db_close($conn);
        return $result;
    }

    public function edit($user, $password, $roles_id, $user_id)
    {
        $conn = $this->db->db_connect();
        $sql = 'UPDATE users SET user = ?, password = ?, roles_id = ? WHERE users.id = ? ;';
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("ssii", $user, $password, $roles_id, $user_id);
        $result = $stmt->execute();

        $stmt->close(); 
        $this->db->db_close($conn);
        return $result;
    }

    public function delete($id)
    {
        $conn = $this->db->db_connect();
        $sql = 'DELETE FROM users WHERE id = ?;';
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();

        $stmt->close(); 
        $this->db->db_close($conn);
        return $result;
    }

    public function last_id()
    {
        $conn = $this->db->db_connect();
        $sql = 'SELECT MAX(id) as last_id FROM users LIMIT 1;';
        $stmt = $conn->prepare($sql); 
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close(); 
        $this->db->db_close($conn);
        return $result;
    }
    //#################### [END CRUD] ##############################################################################

    //#################### [INI TOKEN] ##############################################################################
    public function validate_token($token, $date_time)
    {
        $conn = $this->db->db_connect();
        $sql = 'SELECT sessions.id as id FROM sessions WHERE token = ? AND sessions.exp >= ? ORDER BY sessions.id DESC LIMIT 1;';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $token, $date_time);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        $this->db->db_close($conn);
        return $result;
    }

    public function getRolBySession($session_id)
    {
        $conn = $this->db->db_connect();
        $sql = 'SELECT roles.id as id FROM roles inner join users on users.roles_id = roles.id inner join sessions on sessions.users_id = users.id WHERE sessions.id = ? LIMIT 1;';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $session_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt->close();
        $this->db->db_close($conn);
        return $result;
    }
    //#################### [END TOKEN] ##############################################################################

}
?>