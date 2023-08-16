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
        <title>HealthCare Dashboard</title>
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>

        <div class="top_bar" id="top_bar">

            <div class="username">
                <?php echo $_SESSION["username"]; ?>
            </div>

            <div class="menu">

            <ul>
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="doctors.php">Lekarze</a></li>
                    <li><a href="medicaments.php">Leki</a></li>
                    <li><a href="results.php">Wyniki</a></li>
                    <li><a href="visits.php">Wizyty</li>
                </ul>

            </div>

            <div class="logout">
                <a href="logout.php">Wyloguj</a>
            </div>

        </div>

        <div class="banner">
        
        </div>

        <div class="contents">

            <div class="data_box">

                <div class="data_box__title">
                    Lekarze
                </div>

                <?php

                    $Patient = new Patient();
                    $Patient->getDoctors();

                ?>

            </div>

        </div>

        <div class="footer">System design and create by Łukasz Adamski copyright &copy</div>

        <script type="text/javascript" src="js/scripts.js"></script>

    </body>
</html>