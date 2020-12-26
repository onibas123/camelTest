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
            //$this->delete_contact($name);
            break;
        case 'PATCH':
            // update a register
            //$this->display_contact($name);
            break;
        case 'DELETE':
            // delete a register url?id=1..n
            //$this->display_contact($name);
            break;
        default:
            //405 Method Not Allowed
            header('Allow: GET, POST, PATCH, DELETE');
            http_response_code(405);
            break;
    }

?>