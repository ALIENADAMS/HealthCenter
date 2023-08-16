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
                
                <form method="POST" action="send_forgot_password.php">
                    <table class="login_table">
                        <tr>
                            <p class="login_box_forgot_text">Podaj login i adres do wysyłki maila resetującego hasło.</p>
                        </tr>
                        <tr>
                            <td><label for="login">Login:</label></td>
                            <td><input type="text" name="login" id="login" /></td>
                        </tr>
                        <tr>
                            <td><label for="email">Email:</label></td>
                            <td><input type="email" name="email" id="email" /></td>
                        </tr>
                    </table>
                    <input type="submit" class="login_box_submit_button" name="login" id="login" value="Wyślij"/>
                </form>
        
            </div>
        
        </div>

        <script src="js/scripts.js"></script>

    </body>
</html>