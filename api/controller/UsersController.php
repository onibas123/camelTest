<?php
  require_once('./config/config.php');
  require_once('./models/UsersModel.php');
  class UsersController
  {
    private $um; 
    
    function __construct()
    {
      $this->um = new UsersModel();
    }

    public function get()
    {
        //GET METHOD HTTP
        $date_time_now = date('Y-m-d H:i:s');
        if(isset($_GET['token']) && !empty(trim($_GET['token'])))
        {
            // with token
            $token = trim($_GET['token']);
            $res = $this->um->validate_token($token, $date_time_now);
            $identifier_session = 0;

            while ($col = mysqli_fetch_array($res))
            {
                if(intval(trim($col['id'])) > 0 )
                {
                    $identifier_session = trim($col['id']);
                }
            }

            if($identifier_session > 0)
            {
                //token & session valid
                if(isset($_GET['id']) && !empty(trim($_GET['id'])))
                {
                    $id = trim($_GET['id']);
                    //get a specific user by id
                    $result = $this->um->getUserById($id);
                    $user;
                    while ($col = mysqli_fetch_array($result))
                    {
                        $user = array(
                            'id' => $col['id'],
                            'user' => $col['user'],
                            'last_access' => $col['last_access'],
                            'rol_id' => $col['rol_id'],
                            'rol' => $col['rol']
                        );
                    }
                    echo json_encode($user);
                }
                else
                {
                    //get all users
                    $result = $this->um->getAllUsers();
                    $users = array();
                    while ($col = mysqli_fetch_array($result))
                    {
                        $temp = array(
                            'id' => $col['id'],
                            'user' => $col['user'],
                            'last_access' => $col['last_access'],
                            'rol_id' => $col['rol_id'],
                            'rol' => $col['rol']
                        );

                        array_push($users, $temp);
                    }
                    echo json_encode($users);
                }
            }
            else
            {
                //Forbidden
                http_response_code(403);
            }
        }
        else
        {
            // without token
            //Forbidden
            http_response_code(403);
        }
    }

    public function add()
    {
        //POST METHOD HTTP
        $date_time_now = date('Y-m-d H:i:s');
        if(isset($_GET['token']) && !empty(trim($_GET['token'])))
        {
            // with token
            $token = trim($_GET['token']);
            $res = $this->um->validate_token($token, $date_time_now);
            $identifier_session = 0;

            while ($col = mysqli_fetch_array($res))
            {
                if(intval(trim($col['id'])) > 0 )
                {
                    $identifier_session = trim($col['id']);
                }
            }

            if($identifier_session > 0)
            {
                //token & session valid
            }
            else
            {
                //Forbidden
                http_response_code(403);
            }
        }
        else
        {
            // without token
            //Forbidden
            http_response_code(403);
        }
    }

    public function edit()
    {
        //PATCH METHOD HTTP
        $date_time_now = date('Y-m-d H:i:s');
        if(isset($_GET['token']) && !empty(trim($_GET['token'])))
        {
            // with token
            $token = trim($_GET['token']);
            $res = $this->um->validate_token($token, $date_time_now);
            $identifier_session = 0;

            while ($col = mysqli_fetch_array($res))
            {
                if(intval(trim($col['id'])) > 0 )
                {
                    $identifier_session = trim($col['id']);
                }
            }

            if($identifier_session > 0)
            {
                //token & session valid
            }
            else
            {
                //Forbidden
                http_response_code(403);
            }
        }
        else
        {
            // without token
            //Forbidden
            http_response_code(403);
        }
    }

    public function delete()
    {
        //DELETE METHOD HTTP
        $date_time_now = date('Y-m-d H:i:s');
        if(isset($_DELETE['token']) && !empty(trim($_DELETE['token'])))
        {
            // with token
            $token = trim($_DELETE['token']);
            $res = $this->um->validate_token($token, $date_time_now);
            $identifier_session = 0;

            while ($col = mysqli_fetch_array($res))
            {
                if(intval(trim($col['id'])) > 0 )
                {
                    $identifier_session = trim($col['id']);
                }
            }

            if($identifier_session > 0)
            {
                //token & session valid
            }
            else
            {
                //Forbidden
                http_response_code(403);
            }
        }
        else
        {
            // without token
            //Forbidden
            http_response_code(403);
        }
    }
  
}
?>