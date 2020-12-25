<?php
  require_once('./config/config.php');
  require_once('./models/UsersModel.php');
  class UsersController
  {
    private $model; 
    
    function __construct()
    {
      $this->model = new UsersModel();
    } 

    public function generateToken()
    {
      $token = bin2hex(openssl_random_pseudo_bytes(32));
      return $token;
    }

    public function authorization()
    {
        if(!empty($_POST['user']))
        {
            if(!empty($_POST['password']))
            {
                $user = $_POST['user'];
                $password = sha1($_POST['password']);

                $result = $this->model->authentication($user, $password);
                $user_;
                while ($col = $result->fetch_assoc())
                {
                    $user_ = array(
                        'id' => $col['id'],
                        'user' => $col['user'],
                        'last_access' => $col['last_access'],
                        'rol_id' => $col['rol_id'],
                        'rol' => $col['rol']
                    );
                }

                if(!empty($user_) && count($user_) > 0)
                {
                    //user valid
                    $date_now = date('Y-m-d H:i:s');
                    
                    $exp = $this->add_mins_datetime(EXPIRE_MINS_INAC_API, $date_now);
                    if($this->model->update_last_access($user_['id'], $date_now))
                    {
                        //insert into sessions 
                        $token = $this->generateToken();
                        if($this->model->add_session($user_['id'], 'API', $token, $date_now, $exp))
                        {
                            $token_data = array(
                                'token' => $token,
                                'created' => $date_now,
                                'expired' => $exp
                            );
                            echo json_encode($token_data);
                        }
                        
                    }
                }
                else
                {
                    //no coincidence with user & pass
                    //403 Forbidden
                    http_response_code(403);
                }


            }
            else
            {
                //Unauthorized
                http_response_code(401);
            }
        }
        else
        {
            //Unauthorized
            http_response_code(401);
        }
        
    }

    private function add_mins_datetime($minutes_to_add, $datetime)
    {
      $time = new DateTime($datetime);
      $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

      $stamp = $time->format('Y-m-d H:i:s');
      return $stamp;
    }
}
?>