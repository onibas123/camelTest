<?php
    require_once('config/config.php');
    require_once('controller/UsersController.php');
    
    $uc = new UsersController();

    $method = $_SERVER['REQUEST_METHOD'];
    switch($method)
    {
        case 'GET':
            //url?id=1..n => list only one depends of id in range 1 to n  || url => list all
            $uc->get();
            break;
        case 'POST':
            // create a new register 
            $uc->add();
            break;
        case 'PATCH':
            // update a register
            $uc->edit();
            break;
        case 'DELETE':
            // delete a register url?id=1..n
            $uc->delete();
            break;
        default:
            //405 Method Not Allowed
            header('Allow: GET, POST, PATCH, DELETE');
            http_response_code(405);
            break;
    }

?>