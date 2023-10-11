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
      echo "
      <h1>Use this form to see all of the campers of a specific diet:</h1>
      <form method=\"get\" action=\"createReport.php\">
          <fieldset style=\"display:inline-block;\">
            <legend>What diet campers would you like to view?</legend>
            <label for=\"diet\">Omnivore:</label>
            <input type=\"radio\" name=\"diet\" id=\"omni\" value=\"omni\"><br>
            <label for=\"diet\">Pescatarian:</label>
            <input type=\"radio\" name=\"diet\" id=\"pesca\" value=\"pesca\"><br>
            <label for=\"diet\">Vegitarian:</label>
            <input type=\"radio\" name=\"diet\" id=\"vegi\" value=\"vegi\"><br>
          </fieldset><br>
          <input type=\"submit\" value=\"Submit Form\">
          <input type=\"reset\" value=\"Clear Form\">
        </form>
        <a href=\"index.html\">Return to camp website page</a>
        <p>
          This form generates a report of all of the campers of a certain
          diet so we can see which campers should sit at what tables.
        </p>";
    } else {
      echo "<h1>Unauthorized access</h1>";
      echo "<h2><a href=\"login.html\">login here</a></h2>";
    }
  ?>
</body>
