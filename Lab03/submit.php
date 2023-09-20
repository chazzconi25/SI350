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
      
      if($name != "" && ($swimming || $fishing || $kayaking) &&
                        ($omnivore || $pescatarian || $vegitarian)) {
        // error check here from w3schools
        $log = fopen("LOG.txt", "w") or die("Unable to open file!");
        echo($name. "\t" . $email . "\t" . $password . "\t" .
        $activities . "\t" . $diet . "\t" . $hability . "\t" .
        $comments . "\t" . $excitement);
        fwrite($log, $name. "\t" . $email . "\t" . $password . "\t" .
               $activities . "\t" . $diet . "\t" . $hability . "\t" .
               $comments . "\t" . $excitement);
        fclose($log);
      }
    ?>
    <h2> Thank you for registering to camp! We're so excited to see you!</h2>
    <h3> Please confirm our records are correct: </h3>
    <center>
      <table>
        <thead>
          <tr><td><b>Form Question</b></td><td><b>Response Recorded</b></td></tr>
        </thead>
        <tbody>
          <tr><td>Name</td><td><?php echo $name; ?></td></tr>
          <tr><td>Email</td><td><?php echo $email; ?></td></tr>
          <tr><td>Password </td><td><?php echo $hidden; ?></td></tr>
          <tr><td>Activities </td><td><?php echo $activities; ?></td></tr>
          <tr><td>Diet </td><td><?php echo $diet; ?></td></tr>
          <tr><td>Hiking ability </td><td><?php echo $hability; ?></td></tr>
          <tr><td>Swimming ability </td><td><?php echo $sability; ?></td></tr>
          <tr><td>Comments </td><td><?php echo $comments; ?></td></tr>
          <tr><td>Excitment for camp! </td><td><?php echo $excitement; ?></td></tr>
        </tbody>
      </table>
    </center>
</body>

</html>