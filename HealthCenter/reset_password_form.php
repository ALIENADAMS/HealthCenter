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
                
            <form method="POST" action="reset_password_complete.php">
                    <table class="login_table">
                        <tr>
                            <p class="login_box_forgot_text">Podaj nowe hasło i potwierdź je</p>
                        </tr>
                        <tr>
                            <td><label for="password1">Hasło:</label></td>
                            <td><input type="password" name="password1" id="password1" /></td>
                        </tr>
                        <tr>
                            <td><label for="password2">Powtórz hasło:</label></td>
                            <td><input type="password" name="password2" id="password2" /></td>
                        </tr>
                    </table>
                    <input type="submit" class="login_box_submit_button" name="login" id="login" value="Wyślij"/>
                </form>
        
            </div>
        
        </div>

        <script src="js/scripts.js"></script>

    </body>
</html>