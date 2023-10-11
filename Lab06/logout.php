<!DOCTYPE html>

<!-- Lab 05 page-->

<html lang="en">

<!-- CSS and meta information-->
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Charlie Francesconi">
  <link rel="stylesheet" href="../styles.css">
  <title>Camp Login</title>
  <style>
    body {
    text-align: center;
    }
    datalist {
      color: white;
    }
  </style>
</head>


<body>

  <?php
  session_start();
  if (isset($_SESSION['email'])) {
      session_destroy();
      echo "<h1>You have been sucessfully logged out!</h1>";
      echo "<h2><a href=\"index.html\">Back to main page</a></h2>";
    } else {
      echo "<h1>Unauthorized access</h1>";
      echo "<h2><a href=\"login.html\">login here</a></h2>";
    }
  ?>
</body>
