<?php
    // This is here because I got advice to put it here form this source:
    // https://stackoverflow.com/questions/8028957/how-to-fix-headers-already-sent-error-in-php
    // Section 2
    session_start();
    // DEBUGGING CODE DELETE THIS SECTION WHEN FINISHED
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // DEBUGGING CODE DELETE THIS SECTION WHEN FINISHED
    function formProcessInt($formInput) {
        $int = 0;
        if(isset($_POST[$formInput]) && $formInput != "") {
            $int = (is_numeric($_POST[$formInput]) ? (int)$_POST[$formInput] : null);
            return $int;
        }
        return null;
    }
    function keepVal($varName) {
        if(isset($_POST[$varName])) {
            echo($_POST[$varName]);   
        }
    }
    function dispInputTable($inputArr) {

    }

?>
<!DOCTYPE html>
<!-- Lab 09 page-->
<html lang="en">
<!-- CSS and meta information-->
<head>

    <meta charset="utf-8" />
    <meta name="author" content="Charlie Francesconi">
    <link rel="stylesheet" href="../styles.css">
    <title>Lab 09</title>
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
    <form method="post" action="">
        <label for="years">Years to Calculate:</label>
        <input type="number" name="years" id="years" value=<?php keepVal("years")?>><br>
        <label for="roi">Expected Rate of Return:</label>
        <input type="number" name="roi" id="roi" value=<?php keepVal("roi")?>><br>
        <label for="initial">Initial Investment:</label>
        <input type="number" name="initial" id="initial" value=<?php keepVal("initial")?>><br>
        <label>Additional Investment:</label>
        <label for="ystrt">Start at Year:</label>
        <input type="number" name="ystrt" id="ystrt">
        <label for="pmnth">Additional amount per month:</label>
        <input type="number" name="pmnth" id="pmnth"><br>
        <input type ="submit" value="Calculate" name="calculate" id="calculate">
        <input type ="submit" value="Start Over" name="reset" id="reset">
    </form>
    <table>
        <tr>
            <th>
                Year
            </th>
            <th>
                Amount
            </th>
        </tr>
        <?php
            if(array_key_exists('reset', $_POST)) {
                unset($_SESSION['table']);
                unset($_SESSION['arr']);
            }
            $ystrt = formProcessInt("ystrt");
            $pmnth = formProcessInt("pmnth");
            if(!isset($_SESSION['table'])) {
                $_SESSION['table'] = "";
                $_SESSION['arr'] = array();
            }
            if(isset($ystrt, $pmnth)) {
                $_SESSION['arr'][$ystrt] = $pmnth;
                $row = "<tr><td>". $ystrt ."</td><td>". $pmnth ."</td></tr>";
                $_SESSION["table"] .= $row;
            }
            echo($_SESSION["table"]);
        ?>
    </table>
    <table>
        <tr>
            <th>
                Year
            </th>
            <th>
                Month
            </th>
            <th>
                Additional Principle
            </th>
            <th>
                EOM Balance
            </th>
            <th>
                EOM Balance with Initial Investment
            </th>
        </tr>
        <?php
            $rate = formProcessInt("roi");
            $initial = formProcessInt("initial");
            $years = formProcessInt("years");
            $addlprinc= 0.0;
            $eomBal = 0;
            for($i = 0; $i < $years; $i++) {
                if(array_key_exists($i, $_SESSION["arr"])) {
                    $addlprinc += $_SESSION["arr"][$i];
                }
                for($j = 0; $j < 12; $j++) {
                    $eomBal += $addlprinc;
                    $eomBal += ($rate/ 100.0 / 12.0) * $eomBal;
                    $initial += $addlprinc;
                    $initial += ($rate/ 100.0 / 12.0) * $initial;
                    echo("<tr><td>". $i ."</td><td>"
                        . $j+1 ."</td><td>"
                        . $addlprinc ."</td><td>"
                        . number_format($eomBal, 2, ".","") . "</td><td>"
                        . number_format($initial, 2, ".","") . "</td><td></tr>");
                }
            }
        ?>
    </table>


</body>

</html>