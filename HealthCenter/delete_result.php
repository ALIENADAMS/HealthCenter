<?php include('scripts/Patient.php'); ?>
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
                $Patient = new Patient();
                $Patient->deleteTestResult();
                header('Location: results.php');
            ?>
        
        </div>

        <script src="js/scripts.js"></script>

    </body>
</html>