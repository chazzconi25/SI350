<!DOCTYPE html>

<!-- Lab 02 page-->

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
        $swimming = $_POST['swimming'] == 'Yes';
        $fishing = $_POST['fishing'] == 'Yes';
        $kayaking = $_POST['kayaking'] == 'Yes';

        if($name != "") {
            echo "$name<br>";
        } else {
            echo "Please enter a name in the name field<br>";
        }

        if($swimming || $fishing || $kayaking) {
            echo "Good to go<br>";
        } else {
            echo "$swimming<br>";
        }
        
        
    ?>

</body>

</html>