<?php
    include_once("DatabaseController.php");
    session_start();

    if(!empty($_SESSION['userid']) && !empty($_POST['message']))
    {
        $dbController = new DatabaseController();

        if($dbController->sendCommand($_SESSION['user'], $_SESSION['pass'], 'login'))
        {
            $dbController->sendCommand($_SESSION['user'], $_SESSION['pass'], 'send_message', json_encode(["userid" => $_SESSION['userid'], "message" => $_POST['message']]));
        }
    }
?>