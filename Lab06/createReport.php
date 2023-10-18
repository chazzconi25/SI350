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
        session_start();
        if (isset($_SESSION['email'])) {
            $diet = $_GET['diet'];
            $cData = array();
            $header;
            $fileName = 'LOG.txt';
            $fp = fopen($fileName, 'r');   //open the file for reading
            if (!$fp) {                    //check that file opened ok
            echo"<ul class = \"nav\">
                <li class = \"nav\"><a class=\"active\" href=\"index.html\">Home</a></li>
                <li class = \"nav\"><a href=\"login.php\">Login</a></li>
                <li class = \"nav\"><a href=\"logout.php\">Logout</a></li>
                <li class = \"nav\"><a href=\"schedule.html\">Schedule</a></li>
                <li class = \"nav\"><a href=\"registration.html\">Register</a></li>
                <li class = \"nav\"><a href=\"requestReport.php\">View Camp Data</a></li>
              </ul>";
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
            echo"<ul class = \"nav\">
            <li class = \"nav\"><a class=\"active\" href=\"index.html\">Home</a></li>
            <li class = \"nav\"><a href=\"login.php\">Login</a></li>
            <li class = \"nav\"><a href=\"logout.php\">Logout</a></li>
            <li class = \"nav\"><a href=\"schedule.html\">Schedule</a></li>
            <li class = \"nav\"><a href=\"registration.html\">Register</a></li>
            <li class = \"nav\"><a href=\"requestReport.php\">View Camp Data</a></li>
            </ul>";
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
        } else {
            echo"<ul class = \"nav\">
            <li class = \"nav\"><a class=\"active\" href=\"index.html\">Home</a></li>
            <li class = \"nav\"><a href=\"login.php\">Login</a></li>
            <li class = \"nav\"><a href=\"logout.php\">Logout</a></li>
            <li class = \"nav\"><a href=\"schedule.html\">Schedule</a></li>
            <li class = \"nav\"><a href=\"registration.html\">Register</a></li>
            <li class = \"nav\"><a href=\"requestReport.php\">View Camp Data</a></li>
          </ul>";
            echo "<h1>Unauthorized access</h1>";
            echo "<h2><a href=\"login.html\">login here</a></h2>";
        }
        
    ?>
</body>