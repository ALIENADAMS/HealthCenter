<?php include('scripts/User.php') ?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HealthCare Dashboard</title>
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>

        <?php

            $User = new User();
            $User->activateUser();

        ?>

        <script src="js/scripts.js"></script>

    </body>
</html>