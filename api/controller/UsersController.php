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

    public function generateToken()
    {
      $token = bin2hex(openssl_random_pseudo_bytes(32));
      return $token;
    }
}
?>