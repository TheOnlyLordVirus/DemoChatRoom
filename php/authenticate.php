<?php
    include_once("DatabaseController.php");

    if(!empty($_POST['username']) && !empty($_POST['password']))
    {
        if($databaseController = new DatabaseController())
        {
            if($databaseController->sendCommand($_POST['username'], $_POST['password'], 'login', json_encode([])))
            {
                session_start();

                $_SESSION['loggedin'] = true;
                $_SESSION['userid'] = $databaseController->sendCommand($_POST['username'], $_POST['password'], 'get_uid', json_encode(["username" => $_POST['username'], "password" => $_POST['password']]));
                $_SESSION['user'] = $_POST['username'];
                $_SESSION['pass'] = $_POST['password'];
    
                header('Location: http://localhost/dashboard/api/php/chatPage.php');
            }
        }
    }
    header('Location: ../');
?>