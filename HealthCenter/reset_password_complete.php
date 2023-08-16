<?php include('scripts/Database.php') ?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HealthCare</title>
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>

        <?php 

            $Database = new Database();
            $Database->resetPassword();

        ?>

        <script src="js/scripts.js"></script>

    </body>
</html>