<?php

    include_once 'Database.php';

    //Class for user operation in login/register
    class User
    {
        private $username, $password, $password2, $email;

        //constructor
        public function __construct()
        {
            $this->username = '';
            $this->password = '';
            $this->password2 = '';
            $this->email = '';
        }

        //check username format
        public static function validateUsername($username)
        {
            $username = $_POST['user_name'];
            trim($username);
            
            if($username == '' || $username == ' ' || preg_match('/^[A-Z0-9]{2,20}$/i', $username) == 0)
            {
                echo 'Błąd: Proszę podać poprawną nazwę użytkownika!';
            }
        }

        //check email format
        public static function validateEmailAddr($email)
        {
            $email = $_POST['email'];
            trim($email);
            
            if($email == '' || $email == ' ' || !filter_var($mail, FILTER_VALIDATE_EMAIL))
            {
                echo 'Błąd: Proszę podać poprawny adres email!';
            }
        }

        //check password format
        public static function validatePassword($password, $password2)
        {
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            trim($password);
            trim($password2);

            if($password != $password2)
            {
                echo 'Błąd: Hasła są różne, proszę podać takie same hasła.';
            }
            else if($password == '' || $password2 == '')
            {
                echo 'Błąd: Należy podać oba hasła.';
            }
            else
            {

            }
        }

        //register new user
        public static function register()
        {
            $username = $_POST['user_name'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            trim($username);
            trim($password);
            trim($email);

            $Database = new Database();
            $Database->serverConnect();
            $Database->insertUser($username, $password, $email);
        }

        //activate new user
        public static function activateUser()
        {
            $username = $_GET['username'];
            trim($username);

            $Database = new Database();
            $Database->serverConnect();
            $Database->setActive($username);
        }

        //login user
        public static function login()
        {
            $username = $_POST['login_name'];
            $password = $_POST['password'];
            trim($username);
            trim($password);

            $Database = new Database();
            $Database->serverConnect();
            $Database->login($username, $password);
        }

        //logout user
        public static function logout()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->logout();
        }
        
        public function sendForgotPassword()
        {
            $username = $_POST['login'];
            $email = $_POST['email'];

            $Database = new Database();
            $Database->serverConnect();
            $Database->checkUser($username, $email);

            $mail_title = 'HealthCare - przypomnienie hasła';
            $mail_body = 'Dzień dobry, <br /> oto link do zresetowania zapomnianego hasła: http://localhost/dashboard/Strony/HealthCenter/reset_password_form.php?username=' . $username;

            if(mail($email, $mail_title, $mail_body))
            {
                echo 'Wysłaliśmy link do resetowania hasła. Prosimy sprawdzić skrzynkę pocztową. <a href="http://localhost/dashboard/Strony/HealthCenter/index.php">Powrót do strony logowania</a>';
            }
            else
            {
                echo 'Ups! Coś poszło nie tak. Prosimy spróbować ponownie.';
            }
        }

        public function resetPassword()
        {
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];
            $username = $_POST['username'];

            if($password1 == $password2)
            {
                $Database = new Database();
                $Database->serverConnect();
                $Database->resetPassword($password1, $username);
            }
        }
    }

?>