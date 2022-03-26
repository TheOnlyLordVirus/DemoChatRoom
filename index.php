<?php
    session_start();

    if (!empty($_SESSION['loggedin']))
    {
        header('Location: http://localhost/dashboard/api/php/chatPage.php');
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Chat Room Demo</title>
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="http://localhost/dashboard/api/css/style.css">
  </head>

  <body>
    <div class="mainPanel">
      <div>
        <h1 id="mainHeader">Login</h1>
      </div>

      <form action="http://localhost/dashboard/api/php/authenticate.php" method="post">
        <label for="username">
          <i class="fas fa-user"></i>
        </label>
        <input class="textBox" type="text" name="username" placeholder="Username" required>
        <br>
        <br>
        <label for="password">
          <i class="fas fa-lock"></i>
        </label>
        <input class="textBox" type="password" name="password" placeholder="Password" required>
        <br>
        <input class="submitButton" type="submit" name="sub" value="Login">
      </form>
    </div>
  </body>
</html>