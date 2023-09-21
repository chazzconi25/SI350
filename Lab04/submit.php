<!DOCTYPE html>

<!-- Lab 03 php-->

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
      $log = fopen("LOG.txt", "a") or die("Unable to open file!");
      //https://stackoverflow.com/questions/4857182/best-way-to-determine-if-a-file-is-empty-php
      if ((filesize("LOG.txt")) == 0) {
        fwrite($log, "Name\tEmail\tPassword\tActivities\tdiet\tHiking Ability\tComments\tExcitment Level");
      }
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $hidden = "";
      for($i = 0; $i < strlen($password); $i++) {
        $hidden .= "*";
      }
      $activities = "";
      $swimming = isset($_POST['swimming']);
      if($swimming) {
        $activities .= "swimming,";
      }
      $fishing = isset($_POST['fishing']);
      if($fishing) {
        $activities .= "fishing,";
      }
      $kayaking = isset($_POST['kayaking']);
      if($kayaking) {
        $activities .= "kayaking";
      }
      $omnivore = isset($_POST['omni']);
      $pescatarian = isset($_POST['pesca']);
      $vegitarian = isset($_POST['vegi']);
      if($omnivore) {
        $diet = "Omnivore";
      } else if($pescatarian) {
        $diet = "Pescatarian";
      } else {
        $diet = "vegitarian";
      }
      $hability = $_POST['ability'];
      $sability = $_POST['swimmertype'];
      $comments = $_POST['comments'];
      $excitement = $_POST['excitement'];
      if($password != "" && preg_match("/(?=.*?[0-9])(?=.*?[a-z])(?=.*?[A-Z])/", $password) == 0) {
        $error = "";
        if(preg_match("/(?=.*?[0-9])/", $password) == 0) {
          $error .= "<br>A digit";
        }
        if(preg_match("/(?=.*?[a-z])/", $password) == 0) {
          $error .= "<br>A lower case letter";
        }
        if(preg_match("/(?=.*?[A-Z])/", $password) == 0 ) {
          $error .= "<br>An uppercase letter";  
        }
        echo "<h1>Go back and resubmit the password in the form with: $error</h1>";
      } else if($name != "" && ($swimming || $fishing || $kayaking) &&
                        ($omnivore || $pescatarian || $vegitarian)) {
        // error check here from w3schools


        fwrite($log, $name . "\t" . $email . "\t" . $password . "\t" . $activities . "\t" . $diet . "\t" . $hability . "\t" . $comments . "\t" . $excitement . "\n");
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
                <tr><td>Name</td><td>$name</td></tr>
                <tr><td>Email</td><td>$email</td></tr>
                <tr><td>Password </td><td>$hidden</td></tr>
                <tr><td>Activities </td><td>$activities</td></tr>
                <tr><td>Diet </td><td>$diet</td></tr>
                <tr><td>Hiking ability </td><td>$hability</td></tr>
                <tr><td>Swimming ability </td><td><$sability/td></tr>
                <tr><td>Comments </td><td><$comments</td></tr>
                <tr><td>Excitment for camp! </td><td>$excitement</td></tr>
              </tbody>
            </table>
          </center>";
      } else {
        $error = "";
        if($name == "") {
          $error .= "<br>Your name";
        }
        if(!($swimming || $fishing || $kayaking)) {
          $error .= "<br>At least one activity";
        }
        if(!($omnivore || $pescatarian || $vegitarian)) {
          $error .= "<br>Your diet type";
        }
        echo "<h1>Go back and resubmit the form with: $error</h1>";
      }
    ?>


</body>

</html>