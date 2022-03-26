
<?php
  session_start();

  if(!empty($_SESSION['loggedin']))
  {
    session_destroy();
  }

  header('Location: ../');
?>