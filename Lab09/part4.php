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
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
        <?php
            $rate = formProcessInt("roi");
            $initial = formProcessInt("initial");
            $years = formProcessInt("years");
            $addlprinc= 0.0;
            $eomBal = 0;
            $data = array();
            for($i = 0; $i < $years; $i++) {
                if(array_key_exists($i, $_SESSION["arr"])) {
                    $addlprinc += $_SESSION["arr"][$i];
                }
                for($j = 0; $j < 12; $j++) {
                    $eomBal += $addlprinc;
                    $eomBal += ($rate/ 100.0 / 12.0) * $eomBal;
                    $initial += $addlprinc;
                    $initial += ($rate/ 100.0 / 12.0) * $initial;
                    array_push($data,array(($i *12) + $j, $addlprinc, $eomBal, $initial));
                    //array_push($data['addlprinc'], $addlprinc);
                    //array_push($data['eomBal'], $eomBal);
                    //array_push($data['initial'], $initial);
                }
            }
        ?>
        <script type="text/javascript">
            var json_data = <?php echo json_encode($data); ?>;
            var today = new Date();
            function addMonths(date, months) {
                var d = date.getDate();
                date.setMonth(date.getMonth() + months);
                if (date.getDate() != d) {
                    date.setDate(0);
                }
                return date;
            }


            //
            for(var i = 0; i < json_data.length; i++){
                json_data[i][0] = addMonths(today, json_data[i][0]);
                today = new Date();
            }
            console.log(json_data);

            google.charts.load('current', {'packages':['corechart','line']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('date', 'Date');
                data.addColumn('number', 'Additional Principle');
                data.addColumn('number', 'Balance');
                data.addColumn('number', 'Balance with Inintal Investment');
                data.addRows(json_data);
                
                var options = {
                    curveType: 'function',
                    vAxis: {
                        title: 'Amount',
                        logScale: false,
                        slantedText: true
                    },
                    hAxis: {
                        title: 'Investment Preformance',
                        logScale: true,
                        gridlines: {count: json_data.length},
                        slantedText: true
                    }
                };
                var chart = new google.charts.Line(document.getElementById('linechart_material'));

                chart.draw(data, google.charts.Line.convertOptions(options));
            }
        </script>
        <div id="linechart_material" ></div>
    </body>

</html>