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
      $cData = array();
      $header;
      $fileName = 'LOG.txt';
      $fp = fopen($fileName, 'r');   //open the file for reading
      if (!$fp) {                    //check that file opened ok
      echo "<p>ERROR! Could not open file $fileName for reading.</p>";
      } else {
          while ($row = fgetcsv($fp, null,"\t")) {
              if($row[4] == $diet) {
                  array_push($cData, $row);
                  //print_r($row);
                  //echo "<br>";
              } else if($row[4] == 'diet') {
                $header = $row;
              }
          }
      }
      array_multisort(array_column($cData, 0), SORT_ASC, $cData);
      echo "<table>";
      echo "<tr>";
      echo "<h2>Below are the ". count($cData) ." campers who are $diet diet, sorted alphabetically by name</h2>";
      for ($i = 0; $i < count($header); $i++) {
          echo "<th> $header[$i]</th>";
      }
      echo "</tr>";

      for ($i = 0; $i < count($cData); $i++) {
          echo "<tr>";
          for ($j = 0; $j < count($cData[$i]); $j++) {
              if($j != 2) {
                  echo "<td>". $cData[$i][$j] . "</td>";
              } else {
                  echo "<td>*****</td>";
              }
              
          }
          echo "</tr>";
      }

      echo "</table>";

      fclose($fp);                   //close the file

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