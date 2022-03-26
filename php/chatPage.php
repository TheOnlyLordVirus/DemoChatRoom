<?php
    if (!empty($_SESSION['loggedin']))
    {
        header('Location: ../');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Chat Room</title>
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="http://localhost/dashboard/api/css/style.css">
  </head>

  <body>
    <div class="mainPanel">
      <div>
        <h1 id="mainHeader">Chat Demo</h1>
      </div>

      <h2></h2>

      <form id="mainForm">
        <div id="chatDiv">
          <table id="chatTable">
          </table>
        </div>
      </form>

      <form action="sendChat.php" method="post">
        <input class="textBox" id="message" type="text" name="message" placeholder="Enter Message Here..." required>
        <input class="submitButton" id="postMessage" type="submit" name="postMessage" value="Send Message">
      </form>

      <form action="logout.php" method="post">
        <input class="submitButton" type="submit" name="logout" value="Logout">
      </form>
    </div>

    <script src="http://localhost/dashboard/api/js/jquery-3.4.1.min.js"></script>
    <script src="http://localhost/dashboard/api/js/jquery.validate.min.js"></script>
    <script src="http://localhost/dashboard/api/js/chatAjaxHelper.js"></script>
  </body>
</html>