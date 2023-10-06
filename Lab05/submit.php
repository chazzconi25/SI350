<!DOCTYPE html>

<!-- Lab 04 php-->

<html lang="en">

<!-- CSS and meta information-->
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Charlie Francesconi">
  <link rel="stylesheet" href="../styles.css">
  <title>Camp Registration</title>
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
      require('utilFunctions.inc.php');
      $log = fopen("LOG.txt", "a") or die("Unable to open file!");
      //https://stackoverflow.com/questions/4857182/best-way-to-determine-if-a-file-is-empty-php
      if ((filesize("LOG.txt")) == 0) {
        fwrite($log, "Name\tEmail\tPassword\tActivities\tdiet\tHiking Ability\tSwimming Ability\tComments\tExcitment Level\n");
      }
      
      //chmod($log, 777); 
      $responses = array($_POST['name'], $_POST['email'], $_POST['password'],
                         $_POST['activities'], $_POST['diet'], 
                         $_POST['ability'], $_POST['swimmertype'],
                         str_replace(array("\r\n","\n","\r"), "&&",$_POST['comments']), $_POST['excitement']);
      $hidden = "";
      
      for($i = 0; $i < strlen($responses[2]); $i++) {
        $hidden .= "*";
      }
      $responses[3] = listToString($responses[3]);
      $pass = $responses[2];
      if(pCheck($pass)) {
        $error = "";
        if(preg_match("/(?=.*?[0-9])/", $pass) == 0) {
          $error .= "<br>A digit";
        }
        if(preg_match("/(?=.*?[a-z])/", $pass) == 0) {
          $error .= "<br>A lower case letter";
        }
        if(preg_match("/(?=.*?[A-Z])/", $pass) == 0 ) {
          $error .= "<br>An uppercase letter";  
        }
        echo "<h1>Go back and resubmit the password in the form with: $error</h1>";
      } else if($responses[0] != "" && $responses[3] != "" && $responses[4] != "") {
        for($i = 0; $i < count($responses)-1; $i++) {
          fwrite($log, $responses[$i] . "\t");
        }
        fwrite($log, $responses[count($responses)-1]. "\n");
        fclose($log);
        echo "
          <h2> Thank you for registering to camp! We're so excited to see you!</h2>
          <h3> Please confirm our records are correct: </h3>
          <center>
            <table>
              <thead>
                <tr><td><b>Form Question</b></td><td><b>Response Recorded</b></td></tr>
              </thead>
              <tbody>
                <tr><td>Name</td><td>$responses[0]</td></tr>
                <tr><td>Email</td><td>$responses[1]</td></tr>
                <tr><td>Password </td><td>$hidden</td></tr>
                <tr><td>Activities </td><td>$responses[3]</td></tr>
                <tr><td>Diet </td><td>$responses[4]</td></tr>
                <tr><td>Hiking ability </td><td>$responses[5]</td></tr>
                <tr><td>Swimming ability </td><td>$responses[6]</td></tr>
                <tr><td>Comments </td><td>$responses[7]</td></tr>
                <tr><td>Excitment for camp! </td><td>$responses[8]</td></tr>
              </tbody>
            </table>
          </center>";
      } else {
        $error = "";
        if($responses[0] == "") {
          $error .= "<br>Your name";
        }
        if($responses[3] == "") {
          $error .= "<br>At least one activity";
        }
        if($responses[4]  == "") {
          $error .= "<br>Your diet type";
        }
        echo "<h1>Go back and resubmit the form with: $error</h1>";
      }
    ?>


</body>

</html>