<?php
    include_once("DatabaseController.php");
    session_start();

    if(!empty($_SESSION['user']) && !empty($_SESSION['pass']))
    {
        $dbController = new DatabaseController();

        if($dbController->sendCommand($_SESSION['user'], $_SESSION['pass'], 'login', json_encode([])))
        {
            echo $dbController->sendCommand($_SESSION['user'], $_SESSION['pass'], 'get_message', json_encode([]));
        }
    }
?>