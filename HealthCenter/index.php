<?php include('scripts/User.php') ?>
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

            <div class="login_box">
                
                <form method="POST" action="login.php">
                    <table class="login_table">
                        <tr>
                            <td><label for="login_name">Login:</label></td>
                            <td><input type="text" name="login_name" id="login_name" /></td>
                        </tr>
                        <tr>
                            <td><label for="password">Hasło:</label></td>
                            <td><input type="password" name="password" id="password" /></td>
                        </tr>
                    </table>
                    <input type="submit" class="login_box_submit_button" name="login" id="login" value="Zaloguj"/>
                </form>

                <a href="forgot_password.php"><div class="login_box_form_button">Zapomniałem hasła</div></a>
                <a href="register_form.php"><div class="login_box_form_button login_box_form_button--register">Rejestracja</div></a>
        
            </div>
        
        </div>

        <script src="js/scripts.js"></script>

    </body>
</html>