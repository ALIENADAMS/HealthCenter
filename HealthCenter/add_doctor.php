<?php 
    include('scripts/User.php'); 
    include('scripts/Patient.php');

    if(!isset($_SESSION))
    {
        session_start();
        header('Cache-control: private');
    }

    if(!isset($_SESSION['username']) || $_SESSION['username'] == false)
    {
        header('Location: 401.php');
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HealthCare</title>
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>

        <div class="title_box">

            <a href="index.php">HealthCare &hearts;</a>

        </div>

        <div class="content_box">

            <?php
                $User = new User();
                $Patient = new Patient();
                $Patient->addDoctor();

                header('Location: doctors.php');
            ?>
        
        </div>

        <script src="js/scripts.js"></script>

    </body>
</html>