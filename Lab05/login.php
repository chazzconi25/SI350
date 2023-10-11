<body>
    <?php
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