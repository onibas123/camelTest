<?php
  require_once './models/UsersModel.php';
  class UsersController
  {
    private $model; 
    
    function __construct()
    {
      parent::__construct();
      $this->model = new UsersModel();
    } 
  
    public function index()
    {
      $this->model->index();
    }





}

?>