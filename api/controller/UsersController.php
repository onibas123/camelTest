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
                    $identifier_session = intval(trim($col['id']));
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
                //OK
                http_response_code(200);
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
        if(isset($_POST['token']) && !empty(trim($_POST['token'])))
        {
            // with token
            $token = trim($_POST['token']);
            $res = $this->um->validate_token($token, $date_time_now);
            $identifier_session = 0;

            while ($col = mysqli_fetch_array($res))
            {
                if(intval(trim($col['id'])) > 0 )
                {
                    $identifier_session = intval(trim($col['id']));
                }
            }

            if($identifier_session > 0)
            {
                //token & session valid
                //validate data 
                $res = $this->um->getRolBySession($identifier_session);

                $roles_id = 0;

                while ($col = mysqli_fetch_array($res))
                {
                    if(intval(trim($col['id'])) > 0 )
                    {
                        $roles_id = intval(trim($col['id']));
                    }
                }

                if($roles_id == 1)
                {
                    //ADMINISTRADOR
                    if(isset($_POST['user']) && !empty(trim($_POST['user'])) && 
                    isset($_POST['password']) && !empty(trim($_POST['password']) && 
                    isset($_POST['roles_id']) && !empty(trim($_POST['roles_id'])))
                    )
                    {

                        $user = trim($_POST['user']);
                        $password = sha1(trim($_POST['password']));
                        $roles_id = trim($_POST['roles_id']);

                        if($this->um->add($user, $password, $date_time_now, $roles_id))
                        {
                            $res = $this->um->last_id();

                            $last_id = 0;

                            while ($col = mysqli_fetch_array($res))
                            {
                                if(intval(trim($col['last_id'])) > 0 )
                                {
                                    $last_id = intval(trim($col['last_id']));
                                }
                            }

                            if($last_id > 0)
                            {
                                $user_created = array(
                                    'id' => $last_id,
                                    'user' => $user,
                                    'last_access' => $date_time_now,
                                    'roles_id' => $roles_id 
                                );
                                echo json_encode($user_created);
                                //Created
                                http_response_code(201);
                            }
                            else
                            {
                                //Internal Server Error
                                http_response_code(500);
                            }
                        }
                        else
                        {
                            //Internal Server Error
                            http_response_code(500);
                        }
                    }
                    else
                    {
                        //Bad Request if(user == null || password == null || roles_id == null)
                        http_response_code(400);
                    }
                }
                else
                {
                    //USUARIO
                    //Forbidden
                    http_response_code(403);
                }
            }
            else
            {
                //Forbidden
                echo 2;
                //http_response_code(403);
            }
        }
        else
        {
            // without token
            //Forbidden
            echo 3;
            //http_response_code(403);
        }
    }

    public function edit()
    {
        //PATCH METHOD HTTP
        $date_time_now = date('Y-m-d H:i:s');
        if(isset($_REQUEST['token']) && !empty(trim($_REQUEST['token'])))
        {
            // with token
            $token = trim($_REQUEST['token']);
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
                //validate data 
                $res = $this->um->getRolBySession($identifier_session);

                $roles_id = 0;

                while ($col = mysqli_fetch_array($res))
                {
                    if(intval(trim($col['id'])) > 0 )
                    {
                        $roles_id = intval(trim($col['id']));
                    }
                }

                if($roles_id == 1)
                {
                    //ADMINISTRADOR
                    if(isset($_REQUEST['user']) && !empty(trim($_REQUEST['user'])) && 
                    isset($_REQUEST['password']) && !empty(trim($_REQUEST['password']) && 
                    isset($_REQUEST['roles_id']) && !empty(trim($_REQUEST['roles_id']) && 
                    isset($_REQUEST['user_id']) && !empty(trim($_REQUEST['user_id'])))))
                    {

                        $user = trim($_REQUEST['user']);
                        $password = sha1(trim($_REQUEST['password']));
                        $roles_id = trim($_REQUEST['roles_id']);
                        $user_id = trim($_REQUEST['user_id']);

                        if($this->um->edit($user, $password, $roles_id, $user_id))
                        {
                            $user_edited = array(
                                'id' => $user_id,
                                'user' => $user,
                                'roles_id' => $roles_id 
                            );
                            echo json_encode($user_edited);
                            //OK
                            http_response_code(200);
                        }
                        else
                        {
                            //Internal Server Error
                            http_response_code(500);
                        }
                    }
                    else
                    {
                        //Bad Request if(user == null || password == null || roles_id == null || user_id == null)
                        http_response_code(400);
                    }
                }
                else
                {
                    //USUARIO
                    //Forbidden
                    http_response_code(403);
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

    public function delete()
    {
        //DELETE METHOD HTTP
        $date_time_now = date('Y-m-d H:i:s');
        if(isset($_REQUEST['token']) && !empty(trim($_REQUEST['token'])))
        {
            // with token
            $token = trim($_REQUEST['token']);
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
                //validate data 
                $res = $this->um->getRolBySession($identifier_session);

                $roles_id = 0;

                while ($col = mysqli_fetch_array($res))
                {
                    if(intval(trim($col['id'])) > 0 )
                    {
                        $roles_id = intval(trim($col['id']));
                    }
                }

                if($roles_id == 1)
                {
                    //ADMINISTRADOR
                    if(isset($_REQUEST['id']) && !empty(trim($_REQUEST['id'])))
                    {

                        $id = trim($_REQUEST['id']);

                        if($this->um->delete($id))
                        {
                            //OK
                            http_response_code(200);
                        }
                        else
                        {
                            //Internal Server Error
                            http_response_code(500);
                        }
                    }
                    else
                    {
                        //Bad Request if(user == null || password == null || roles_id == null || user_id == null)
                        http_response_code(400);
                    }
                }
                else
                {
                    //USUARIO
                    //Forbidden
                    http_response_code(403);
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
}
?>