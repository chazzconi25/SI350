<body>
    <?php
        echo "<ul class = \"nav\">
        <li class = \"nav\"><a class=\"active\" href=\"index.html\">Home</a></li>
        <li class = \"nav\"><a href=\"login.php\">Login</a></li>
        <li class = \"nav\"><a href=\"logout.php\">Logout</a></li>
        <li class = \"nav\"><a href=\"schedule.html\">Schedule</a></li>
        <li class = \"nav\"><a href=\"registration.html\">Register</a></li>
        <li class = \"nav\"><a href=\"requestReport.php\">View Camp Data</a></li>
        </ul>";
        $responses = array($_POST['email'], $_POST['password']);
        $fp = fopen("LOG.txt", 'r');
        while ($row = fgetcsv($fp, null,"\t")) {
            if($row[1] == $responses[0] && $row[2] == $responses[1]) {
                session_start();
                $_SESSION['email'] = $responses[0];
                echo $_SESSION['email'];
                header("Location: requestReport.php");
                exit();
            } 
        }
        header("Location: login.html");
    ?>
</body>