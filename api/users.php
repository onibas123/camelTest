<?php
    require_once('config/config.php');
    require_once('controller/UsersController.php');
    
    $uc = new UsersController();
    $uc->authorization();
?>