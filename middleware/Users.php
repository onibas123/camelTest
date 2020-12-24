<?php
require_once('../controller/UsersController.php');
$uc = new UsersController();
$action = $_REQUEST['action'];
switch ($action) {
    case 'login':
        $uc->login();
        break;
    case 'logout':
        $uc->logout();
        break;
    default:
        header('Location: '.BASE_URL);
}

?>