<?php
  require_once('../config/config.php');
  require_once('../models/UsersModel.php');
  class UsersController
  {
    private $um; 
    
    function __construct()
    {
      $this->um = new UsersModel();
    } 
  
    public function index()
    {
      //302 Found HTTP CODE STATUS
      header('Location: '.BASE_URL.'/home.php', true, 302);
    }

    public function login()
    {
      session_start();
      //declare
      $input_user;
      $input_password;
      //validation variables & initialize
      if(!empty(trim($_POST['input-user'])))
      {
        $input_user = trim($_POST['input-user']);
        if(!empty($_POST['input-password']))
        {
          $input_password = sha1(trim($_POST['input-password']));

          $result = $this->um->login($input_user, $input_password);
          //user_ => data array to store result query login
          $user_;
          while ($col = mysqli_fetch_array($result))
          {
              $user_ = array(
                'id' => $col['id'],
                'user' => $col['user'],
                'password' => $col['password'],
                'last_access' => $col['last_access'],
                'rol_id' => $col['rol_id'],
                'rol' => $col['rol']
              );
          }

          $result = $this->um->getLastAccessWay($user_['id']);

          while ($col = mysqli_fetch_array($result))
          {
              $user_['access_way'] = $col['access_way'];
          }

          if(!empty($user_) && count($user_) > 0)
          {
            //user valid
            $date_now = date('Y-m-d H:i:s');
            
            $_SESSION['user_data'] = $user_;
            $_SESSION['message'] = "Bienvenido ".$user_['user'];
            $_SESSION['expire_mins'] = EXPIRE_MINS_INAC;
            $_SESSION['BASE_URL'] = BASE_URL;

            if($this->um->update_last_access($_SESSION['user_data']['id'], $date_now))
            {
              //insert into sessions 
              $token = $this->generateToken();
              $exp = $this->add_mins_datetime(EXPIRE_MINS_INAC, $date_now);
              if($this->um->add_session($_SESSION['user_data']['id'], 'WEB', $token, $date_now, $exp))
              {
                $this->index();
              }
                
            }
          }
          else
          {
            //no coincidence with user & pass
            //302 Found HTTP CODE STATUS
            header('Location: '.BASE_URL, true, 302);
            $_SESSION['message'] = "Usuario y/o Contraseña incorrecto";
          }

        }
        else
        {
          //password empty
          //302 Found HTTP CODE STATUS
          header('Location: '.BASE_URL, true, 302);
          $_SESSION['message'] = "Contraseña es requerida";
        }
      }
      else
      {
        //user empty
        //302 Found HTTP CODE STATUS
        header('Location: '.BASE_URL, true, 302);
        $_SESSION['message'] = "Usuario es requerido";
      }
    }

    public function logout()
    {
      session_start();
      $_SESSION = array();
      session_destroy();
      //302 Found HTTP CODE STATUS
      header('Location: '.BASE_URL, true, 302);
    }

    private function generateToken()
    {
      $token = bin2hex(openssl_random_pseudo_bytes(32));
      return $token;
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