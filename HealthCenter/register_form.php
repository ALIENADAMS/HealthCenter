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
                
                <form method="POST" action="register.php">
                    <table class="login_table">
                        <tr>
                            <td><label for="user_name">Login:</label></td>
                            <td><input type="text" name="user_name" id="user_name" /></td>
                        </tr>
                        <tr>
                            <td><label for="password">Hasło:</label></td>
                            <td><input type="password" name="password" id="password" /></td>
                        </tr>
                        <tr>
                            <td><label for="password2">Powtórz hasło:</label></td>
                            <td><input type="password" name="password2" id="password2" /></td>
                        </tr>
                        <tr>
                            <td><label for="email">Email:</label></td>
                            <td><input type="text" name="email" id="email" /></td>
                        </tr>
                    </table>
                    <input type="submit" class="login_box_submit_button" name="login" id="login" value="Zarejestruj"/>
                </form>
        
            </div>
        
        </div>

        <script src="js/scripts.js"></script>

    </body>
</html>