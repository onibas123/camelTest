<?php
  require_once('../config/config.php');
  require_once('../models/UsersModel.php');
  class UsersController
  {
    private $model; 
    
    function __construct()
    {
      $this->model = new UsersModel();
    } 
  
    public function index()
    {
      header('Location: '.BASE_URL.'/home.php');
    }

    public function login()
    {
      session_start();
      //declare
      $input_user;
      $input_password;
      //validation variables & initialize
      if(!empty($_POST['input-user']))
      {
        $input_user = $_POST['input-user'];
        if(!empty($_POST['input-password']))
        {
          $input_password = sha1($_POST['input-password']);

          $result = $this->model->login($input_user, $input_password);
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

          if(!empty($user_) && count($user_) > 0)
          {
            //user valid
            $date_now = date('Y-m-d H:i:s');
            
            $_SESSION['user_data'] = $user_;
            $_SESSION['message'] = "Bienvenido ".$user_['user'];
            $_SESSION['expire_mins'] = EXPIRE_MINS_INAC;
            $_SESSION['BASE_URL'] = BASE_URL;

            if($this->model->update_last_access($_SESSION['user_data']['id'], $date_now))
            {
              //insert into sessions 
              if($this->model->add_session($_SESSION['user_data']['id'], 'WEB', $date_now))
                $this->index();
            }
          }
          else
          {
            //no coincidence with user & pass
            header('Location: '.BASE_URL);
            $_SESSION['message'] = "Usuario y/o Contraseña incorrecto";
          }

        }
        else
        {
          //password empty
          header('Location: '.BASE_URL);
          $_SESSION['message'] = "Contraseña es requerida";
        }
      }
      else
      {
        //user empty
        header('Location: '.BASE_URL);
        $_SESSION['message'] = "Usuario es requerido";
      }
    }

    public function logout()
    {
      session_start();
      $_SESSION = array();
      session_destroy();
      header('Location: '.BASE_URL);
    }





}

?>