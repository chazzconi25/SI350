<!DOCTYPE html>

<!-- Lab 04 php-->

<html lang="en">

<!-- CSS and meta information-->
<head>
  <meta charset="utf-8" />
  <meta name="author" content="Charlie Francesconi">
  <link rel="stylesheet" href="../styles.css">
  <title>Diet Report</title>
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
        function listToString(array $arr) {
          $string = "";
          for($i = 0; $i < count($arr) -1; $i++) {
            $string .= $arr[$i]. ",";
          }
          $string .= $arr[count($arr)-1];
          return $string;
        }

        function pCheck($pass) {
          return preg_match("/(?=.*?[0-9])(?=.*?[a-z])(?=.*?[A-Z])/", $pass) == 0;
        }
    ?>
</body>