<?php
    require_once('config/config.php');
    require_once('controller/AuthorizationController.php');
    
    $auth = new AuthorizationController();

    $method = $_SERVER['REQUEST_METHOD'];
    switch($method)
    {
        case 'POST':
            // authorization & return token to access api methods
            $auth->authorization();
            break;
        default:
            //405 Method Not Allowed
            header('Allow: POST');
            http_response_code(405);
            break;
    }

?>