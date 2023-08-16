<?php

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_SCHEMA', 'health_center');

    //Class for user operation in database
    class Database
    {
        private $db_host = 'localhost';
        private $db_user = 'root';
        private $db_password = '';
        private $db_schema = 'health_center';

        //constructor
        public function __construct()
        {

        }

        //connect to database server and select db
        public function serverConnect()
        {
            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
            }
            catch(PDOException $e)
            {
                echo 'Error! ' . $e->getMessage() . '<br />';
                die();
            }
        }

        public function insertUser($username, $password, $email)
        {
            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $user_count = $pdo->query('SELECT count(*) FROM users WHERE username = "' . $username . '"');
                
                foreach($user_count as $row)
                {
                    $count = $row['count(*)'];
                }
                
                if($count != 0)
                {
                    echo 'Taki użytkownik już istnieje. Prosimy podać inne dane logowania.<br />';
                    echo "<a href='http://localhost/dashboard/Strony/HealthCenter/index.php'>Powrót</a>";
                }
                else
                {
                    $password = sha1($password);
                    $subject = 'HealthCare - Rejestracja nowego użytkownika';
                    $message = 'Dzień dobry! <br /> Rejestracja zakończyła się pomyślnie. Aby aktywować konto, kliknij w link: <br /> http://localhost/dashboard/Strony/HealthCenter/register_verify.php?username=$username <br /> Jeśli nie rejestrowałeś się na naszej stronie, prosimy zignorować tego maila.';
                    $pdo->query('INSERT INTO users(username, password, email_addr, is_active) VALUES ("' . $username . '", "' . $password . '", "' . $email . '", 0)');
                    $pdo->query('INSERT INTO personal_data(username) VALUES ("' . $username . '")');
                    mail($email, $subject, $message);
                    echo 'Rejestracja przebiegła pomyślnie! Na podanego maila został wysłany link aktywacyjny.';
                    die();
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function setActive($user)
        {
            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $pdo->query('UPDATE users SET is_active = 1 WHERE username = "' . $user . '"');
                echo 'Konto zostało aktywowane. Można się <a href="http://localhost/dashboard/Strony/HealthCenter/index.php">zalogować</a>.';
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function checkUser($username, $email)
        {
            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $user_count = $pdo->query('SELECT count(*) FROM users WHERE username = "' . $username . '" AND email_addr = "' . $email . '"');
                if($user_count == 0)
                {
                    echo 'Podane dane są nieprawidłowe. Proszę spróbować ponownie.';
                    echo '<a href="forgot_password.php">Powrót do strony resetowania</a>';
                }
                else
                {
                    $subject = 'HealthCare - resetowanie hasła';
                    $message = 'Dzień dobry! <br /> Wysłano prośbę o resetowanie hasła. Oto link -> <a href="http://localhost/dashboard/Strony/HealthCenter/reset_password_complete.php">Resetuj hasło</a>';
                    mail($email, $subject, $message);
                }
            }   
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function resetPassword()
        {
            $username = $_POST['username'];
            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $user_count = $pdo->query('SELECT count(*) FROM users WHERE username = "' . $username . '"');
                if($user_count == 0)
                {
                    echo 'Niestety nie ma takiego użytkownika';
                    echo '<a href="reset_password_form.php">Powrót do strony resetowania</a>';
                }
                else
                {
                    $pdo->query('UPDATE users SET password = "' . $password . '" WHERE username = "' . $username . '"');
                    echo 'Hasło zostało zaktualizowane. Można się <a href="http://localhost/dashboard/Strony/HealthCenter/index.php">zalogować</a>.';
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function login($username, $password)
        {
            $password = sha1($password);
            
            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $user_count = $pdo->query('SELECT count(*) FROM users WHERE username = "' . $username . '" AND password = "' . $password . '"');
                if($user_count == 0)
                {
                    echo 'Błędny login lub hasło. Prosimy spróbować ponownie.<br />';
                    echo '<a href="index.php">Powrót do strony logowania</a>';
                }
                else
                {
                    session_start();
                    $_SESSION['username'] = $username;
                    $pdo->query('INSERT INTO login_users(username) values ("' . $username . '")');
                    header('Location: dashboard.php');
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function updateUserData($username, $first_name, $last_name, $street, $home_number, $postal_code, $city)
        {
            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $pdo->query('UPDATE personal_data SET first_name = "' . $first_name . '", last_name = "' . $last_name . '", street = "' . $street . '", home_number = "' . $home_number . '", postal_code = "' . $postal_code . '", city = "' . $city . '" WHERE username = "' . $username . '"');
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function getUserData()
        {
            $username = $_SESSION['username'];

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $user_data = $pdo->query('SELECT * FROM personal_data WHERE username = "' . $username . '"');
                $user_data->execute();
                $row = $user_data->fetchAll();
                
                print('<form method="POST" action="update_personal_data.php">');
                print('<table class="data_box__table">');
                    print('<tr>');
                        print('<td>');
                            print('<label for="first_name">Imię</label>');
                            print('<input type="text" name="first_name" id="first_name" value="' . $row[0][1] . '"></input>');
                        print('</td>');
                        print('<td>');
                            print('<label for="last_name">Nazwisko</label>');
                            print('<input type="text" name="last_name" id="last_name" value="' . $row[0][2] . '"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="street">Ulica</label>');
                            print('<input type="text" name="street" id="street" value="' . $row[0][3] . '"></input>');
                        print('</td>');
                        print('<td>');
                            print('<label for="home_number">Nr domu/mieszkania</label>');
                            print('<input type="text" name="home_number" id="home_number" value="' . $row[0][4] . '"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="postal_code">Kod pocztowy</label>');
                            print('<input type="text" name="postal_code" id="postal_code" value="' . $row[0][5] . '"></input>');
                        print('</td>');
                        print('<td>');
                            print('<label for="city">Miasto</label>');
                            print('<input type="text" name="city" id="city" value="' . $row[0][6] . '"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td><button class="data_box__button">Zapisz</button></td>');
                    print('</tr>');
                print('</table>');
                print('</form>');
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function getPatientDesease()
        {
            $username = $_SESSION['username'];

            print('<form method="POST" action="add_desease.php" enctype="multipart/form-data">');
                print('<table class="data_box__table">');
                    print('<tr>');
                        print('<td>');
                            print('<label for="desease">Nazwa choroby</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="text" name="desease" id="desease"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="diagnosis_date">Data diagnozy</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="date" name="diagnosis_date" id="diagnosis_date"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="diagnosis_making">Stawiający diagnozę</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="text" name="diagnosis_making" id="diagnosis_making"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="diagnosis_document">Dokument potwierdzający</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />');
                            print('<input type="file" name="diagnosis_document" id="diagnosis_document"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td><button class="data_box__button" id="save_button">Zapisz</button></td>');
                    print('</tr>');
                print('</table>');
            print('</form>');

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $user_deseases_count = $pdo->query('SELECT count(*) FROM deseases WHERE username = "' . $username . '"');
                $user_deseases_count->execute();
                $row = $user_deseases_count->fetchAll();
                $count = $row[0][0];
                
                if($count == 0)
                {
                    echo "Nie dodano żadnej choroby.";
                }
                else
                {
                    echo "<p class='data_box__deseases_list'>Choroby:</p>";
                    $user_deseases = $pdo->query('SELECT * FROM deseases WHERE username = "' . $username . '" ORDER BY diagnosis_date DESC');
                    $user_deseases->execute();
                    $row = $user_deseases->fetchAll();
                    
                    for($i = 0; $i < $count; $i++)
                    {
                        echo "<div class='data_box__deseas_box'>";
                            echo "<div class='data_box__delete_button' id='" . $row[$i][1] . "'><a href='delete_deseas.php?delete=" . $row[$i][1] . "'>X</a></div>";
                            echo "<span class='data_box__spec'>Nazwa choroby:</span> " . $row[$i][1] . "<br /><br />";
                            echo "<span class='data_box__spec'>Data diagnozy:</span>" . $row[$i][2] . "<br /><br />";
                            echo "<span class='data_box__spec'>Lekarz diagnozujący:</span>" . $row[$i][3] . "<br /><br />";
                            echo "<span class='data_box__spec'>Dokument z diagnozą:</span> <a href='images/documents/" . $row[$i][4] . "'><div class='data_box__document_button'><img class='data_box__document_icon' src='images/documents/download_arrow.png' alt='dokument'/>Pobierz</div></a><br /><br />";
                        echo "</div>";
                    }
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function addPatientDesease()
        {
            $username = $_SESSION['username'];
            $desease = $_POST['desease'];
            $diagnosis_date = $_POST['diagnosis_date'];
            $diagnosis_making = $_POST['diagnosis_making'];
            $file_folder = 'E:\\xampp\\htdocs\\dashboard\\Strony\\HealthCenter\\images\\documents\\';

            if($_FILES['diagnosis_document']['error'] > 0)
            {
                echo 'Problem: ';
                switch($_FILES['diagnosis_document']['error'])
                {
                    case 1:
                        echo 'Rozmiar pliku przekroczył wartość maksymalną.';
                        break;
                    case 2:
                        echo 'Rozmiar pliku przekroczył wartość maksymalną.';
                        break;
                    case 3:
                        echo 'Plik przesłany tylko częściowo.';
                        break;
                    case 4:
                        echo 'Nie wysłano pliku.';
                        break;
                    case 6:
                        echo 'Nie można wysłać pliku: Nie wskazano katalogu tymczasowego.';
                        break;
                    case 7:
                        echo 'Wysłanie pliku nie powiodło się: Nie zapisano pliku na dysku.';
                        break;
                    case 8:
                        echo 'Rozszerzenie PHP zablokowało odebranie pliku na serwerze.';
                        break;
                }
                exit;
            }

            $location = $file_folder . $_FILES['diagnosis_document']['name'];

            if(!move_uploaded_file($_FILES['diagnosis_document']['tmp_name'], $location))
            {
                echo 'Problem: Plik nie może zostać skopiowany do katalogu.';
                exit;
                }

            echo 'Plik przesłano.';

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $add_desease = $pdo->query('INSERT INTO deseases(username, desease, diagnosis_date, diagnosis_making, diagnosis_document) VALUES ("' . $username . '", "' . $desease . '", "' . $diagnosis_date . '", "' . $diagnosis_making . '", "' . $_FILES['diagnosis_document']['name'] . '")');
                move_uploaded_file($diagnosis_document, $file_folder);
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function deletePatientDesease()
        {
            session_start();
            $username = $_SESSION['username'];
            $desease = $_GET['delete'];

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $delete_desease = $pdo->query('DELETE FROM deseases WHERE username = "' . $username . '" AND desease = "' . $desease . '"');
                $delete_desease->execute();
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function getTreatmentProcess()
        {
            $username = $_SESSION['username'];

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $user_deseases_count = $pdo->query('SELECT count(*) FROM deseases WHERE username = "' . $username . '"');
                $user_deseases_count->execute();
                $row = $user_deseases_count->fetchAll();
                $count = $row[0][0];
                
                if($count == 0)
                {
                    echo "Nie dodano żadnej choroby.";
                }
                else
                {
                    $user_deseases = $pdo->query('SELECT * FROM deseases WHERE username = "' . $username . '" ORDER BY diagnosis_date DESC');
                    $user_deseases->execute();
                    $row = $user_deseases->fetchAll();
                    
                    echo "<center><span class='data_box__spec'>Choroby</span><br /><br />";
                    for($i = 0; $i < $count; $i++)
                    {
                        if($i != 0)
                        {
                            echo "<span class='data_box__spec'>&#8657;</span>";
                        }
                        
                        echo "<div class='treatment_box'>";
                        echo "<span class='data_box__spec'>" . $row[$i][1] . "</span><br />";
                        echo "<span class='data_box__spec'>Data diagnozy:</span>" . $row[$i][2] . "<br />";
                        echo "<span class='data_box__spec'>Lekarz diagnozujący:</span>" . $row[$i][3] . "<br /><br />";
                        echo "</div>";
                    }
                    echo "</center>";
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function getHemoglobin()
        {
            $username = $_SESSION['username'];

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $user_hemoglobin = $pdo->query('SELECT test_result, test_date FROM hemoglobin WHERE username = "' . $username . '" ORDER BY test_date LIMIT 10');
                $user_hemoglobin->execute();
                $row = $user_hemoglobin->fetchAll();

                for($i = 0; $i < 10; $i++)
                {
                    $data = json_encode($row[$i]);
                    if(($data[15] . $data[16]) <= 10)
                    {
                        echo "<div id='hemoglobin" . $i . "' style='height:" . ($data[15] . $data[16]) * 10 . "px; width: 120px; background-color: #ff0000; border-radius: 5px 5px 0 0; float: left; margin-left: 5px; font-family: Verdana; color: #FFFFFF; text-align: center; position: absolute; bottom: 0; '>";
                    }
                    else
                    {
                        echo "<div id='hemoglobin" . $i . "' style='height:" . ($data[15] . $data[16]) * 10 . "px; width: 120px; background-color: #00b06f; border-radius: 5px 5px 0 0; float: left; margin-left: 5px; font-family: Verdana; color: #FFFFFF; text-align: center; position: absolute; bottom: 0; '>";
                    }
                    echo $data[15] . $data[16] . "<br /><br />";
                    for($j = 38; $j < 48; $j++)
                    {
                        echo $data[$j];
                    }
                    echo "</div>";
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function getDoctors()
        {
            $username = $_SESSION['username'];

            print('<form method="POST" action="add_doctor.php">');
                print('<table class="data_box__table">');
                    print('<tr>');
                        print('<td>');
                            print('<label for="first_name_doctor">Imię</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="text" name="first_name_doctor" id="first_name_doctor"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="last_name_doctor">Nazwisko</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="text" name="last_name_doctor" id="last_name_doctor"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="desease">Diagnoza</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="text" name="desease" id="desease"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td><button class="data_box__button" id="save_button">Zapisz</button></td>');
                    print('</tr>');
                print('</table>');
            print('</form>');

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ";dbname=" . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $get_doctors_count = $pdo->query('SELECT count(*) FROM doctors WHERE username = "' . $username . '"');
                $get_doctors_count->execute();
                $row = $get_doctors_count->fetchAll();
                $count = $row[0][0];

                if($count == 0)
                {
                    echo "Nie dodano żadnego lekarza.";
                }
                else
                {
                    $get_doctors = $pdo->query('SELECT * FROM doctors WHERE username = "' . $username . '" ORDER BY last_name');
                    $get_doctors->execute();
                    $row = $get_doctors->fetchAll();
                    echo "<p class='data_box__deseases_list'>Lekarze:</p>";
                    
                    for($i = 0; $i < $count; $i++)
                    {
                        echo "<div class='treatment_box'>";
                        echo "<div class='data_box__delete_button' id='" . $row[$i][1] . "'><a href='delete_doctor.php?delete=" . $row[$i][1] . "'>X</a></div>";
                        echo "<span class='data_box__spec'>Imię:</span> " . $row[$i][0] . "<br />";
                        echo "<span class='data_box__spec'>Nazwisko:</span>" . $row[$i][1] . "<br />";
                        echo "<span class='data_box__spec'>Diagnoza:</span>" . $row[$i][2] . "<br />";
                        echo "<br /><br />";
                        echo "</div>";
                    }
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function addDoctor()
        {
            $username = $_SESSION['username'];
            $first_name = $_POST['first_name_doctor'];
            $last_name = $_POST['last_name_doctor'];
            $desease = $_POST['desease'];

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $check_doctor = $pdo->query('SELECT count(*) FROM doctors WHERE username = "' . $username . '" AND last_name = "' . $last_name . '"');
                $check_doctor->execute();
                $row = $check_doctor->fetchAll();
                $count = $row[0][0];

                if($count != 0)
                {
                    echo "Ten lekarz jest już dodany.";
                }
                else
                {
                    $pdo->query('INSERT INTO doctors(first_name, last_name, desease, username) VALUES ("' . $first_name . '", "' . $last_name . '", "' . $desease . '", "' . $username . '")');
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function deleteDoctor()
        {
            session_start();
            $username = $_SESSION['username'];
            $doctor = $_GET['delete'];

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $delete_desease = $pdo->query('DELETE FROM doctors WHERE username = "' . $username . '" AND last_name = "' . $doctor . '"');
                $delete_desease->execute();
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function getResults()
        {
            $username = $_SESSION['username'];

            print('<form method="POST" action="add_test_result.php">');
                print('<table class="data_box__table">');
                    print('<tr>');
                        print('<td>');
                            print('<label for="test_name">Nazwa badania</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="text" name="test_name" id="test_name"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="test_date">Data wykonania badania</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="date" name="test_date" id="test_date"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="reference_value_min">Wartość referencyjna od</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="text" name="reference_value_min" id="reference_value_min"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="reference_value_max">Wartość referencyjna do</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="text" name="reference_value_max" id="reference_value_max"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="test_value">Wynik</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="text" name="test_value" id="test_value"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td><button class="data_box__button" id="save_button">Zapisz</button></td>');
                    print('</tr>');
                print('</table>');
            print('</form>');

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ";dbname=" . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $get_doctors_count = $pdo->query('SELECT count(*) FROM tests WHERE username = "' . $username . '"');
                $get_doctors_count->execute();
                $row = $get_doctors_count->fetchAll();
                $count = $row[0][0];

                if($count == 0)
                {
                    echo "Nie dodano żadnych wyników";
                }
                else
                {
                    $get_doctors = $pdo->query('SELECT * FROM tests WHERE username = "' . $username . '" ORDER BY test_date DESC');
                    $get_doctors->execute();
                    $row = $get_doctors->fetchAll();
                    echo "<p class='data_box__deseases_list'>Wyniki:</p>";
                    
                    for($i = 0; $i < $count; $i++)
                    {
                        echo "<div class='treatment_box'>";
                        echo "<div class='data_box__delete_button' id='" . $row[$i][6] . "'><a href='delete_result.php?delete=" . $row[$i][6] . "'>X</a></div>";
                        echo "<span class='data_box__spec'>Nazwa badania:</span><span class='test_name'>" . $row[$i][1] . "</span><br />";
                        echo "<span class='data_box__spec'>Data wykonania:</span><span class='test_date'>" . $row[$i][2] . "</span><br />";
                        echo "<span class='data_box__spec'>Wartość referencyjna od:</span><span id='reference_min_value'>" . $row[$i][3] . "</span><br />";
                        echo "<span class='data_box__spec'>Wartość referencyjna do:</span><span id='reference_max_value'>" . $row[$i][4] . "</span><br />";
                        echo "<span class='data_box__spec'>Wartość wyniku:</span><span id='value_of_test'>" . $row[$i][5] . "</span><br />";
                        echo "<br /><br />";
                        echo "</div>";
                    }
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function addTestResult()
        {
            $username = $_SESSION['username'];
            $test_name = $_POST['test_name'];
            $test_date = $_POST['test_date'];
            $reference_value_min = $_POST['reference_value_min'];
            $reference_value_max = $_POST['reference_value_max'];
            $test_value = $_POST['test_value'];

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $add_test_result = $pdo->query('INSERT INTO tests(username, test_name, test_date, reference_value_min, reference_value_max, test_value) VALUES ("' . $username . '", "' . $test_name . '", "' . $test_date . '", "' . $reference_value_min . '", "' . $reference_value_max . '", "' . $test_value . '")');
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function deleteTestResult()
        {
            session_start();
            $username = $_SESSION['username'];
            $test_delete = $_GET['delete'];

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $delete_desease = $pdo->query('DELETE FROM tests WHERE username = "' . $username . '" AND id = "' . $test_delete . '"');
                $delete_desease->execute();
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function getMedicaments()
        {
            $username = $_SESSION['username'];

            print('<form method="POST" action="add_medicament.php">');
                print('<table class="data_box__table">');
                    print('<tr>');
                        print('<td>');
                            print('<label for="medicine_name">Nazwa leku</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="text" name="medicine_name" id="medicine_name"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="dose">Dawka leku (np. 10mg)</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="text" name="dose" id="dose"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="hour">Godzina podania</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="time" name="hour" id="hour"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td><button class="data_box__button" id="save_button">Zapisz</button></td>');
                    print('</tr>');
                print('</table>');
            print('</form>');

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $get_medicaments_count = $pdo->query('SELECT count(*) FROM medicines WHERE username = "' . $username . '"');
                $get_medicaments_count->execute();
                $row = $get_medicaments_count->fetchAll();
                $count = $row[0][0];
                if($count == 0)
                {
                    echo "Nie dodano żadnych leków.";
                }
                else
                {
                    $get_medicaments = $pdo->query('SELECT * FROM medicines WHERE username = "' . $username . '" ORDER BY hour');
                    $get_medicaments->execute();
                    $row = $get_medicaments->fetchAll();
                    echo "<p class='data_box__deseases_list'>Twoje leki:</p>";
                    
                    for($i = 0; $i < $count; $i++)
                    {
                        echo "<div class='treatment_box'>";
                        echo "<div class='data_box__delete_button' id='" . $row[$i][1] . "'><a href='delete_medicament.php?delete=" . $row[$i][1] . "&hour=" . $row[$i][3] . "'>X</a></div>";
                        echo "<span class='data_box__spec'>Nazwa leku:</span><span class='test_name'>" . $row[$i][1] . "</span><br />";
                        echo "<span class='data_box__spec'>Dawka:</span><span class='test_date'>" . $row[$i][2] . "</span><br />";
                        echo "<span class='data_box__spec'>Godzina podania:</span><span id='reference_min_value'>" . $row[$i][3] . "</span><br />";
                        echo "<br /><br />";
                        echo "</div>";
                    }
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function addMedicament()
        {
            $username = $_SESSION['username'];
            $medicine_name = $_POST['medicine_name'];
            $dose = $_POST['dose'];
            $hour = $_POST['hour'];

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $check_medicament = $pdo->query('SELECT count(*) FROM medicines WHERE username = "' . $username . '"AND medicine = "' . $medicine_name . '" AND hour = "' . $hour . '"');
                $check_medicament->execute();
                $row = $check_medicament->fetchAll();
                $count = $row[0][0];

                if($count != 0)
                {
                    $pdo->query('UPDATE medicines SET dose = "' . $dose . '", hour = "' . $hour . '" WHERE medicine = "' . $medicine_name . '" AND username = "' . $username . '"');
                }
                else
                {
                    $pdo->query('INSERT INTO medicines(username, medicine, dose, hour) VALUES ("' . $username . '", "' . $medicine_name . '", "' . $dose . '", "' . $hour . '")');
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function deleteMedicament()
        {
            $username = $_SESSION['username'];
            $medicine_name = $_GET['delete'];
            $hour = $_GET['hour'];

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $delete_desease = $pdo->query('DELETE FROM medicines WHERE username = "' . $username . '" AND medicine = "' . $medicine_name . '" AND hour = "' . $hour . '"');
                $delete_desease->execute();
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function getVisits()
        {
            $username = $_SESSION['username'];

            print('<form method="POST" action="add_visit.php">');
                print('<table class="data_box__table">');
                    print('<tr>');
                        print('<td>');
                            print('<label for="doctor_first_name">Imię doktora</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="text" name="doctor_first_name" id="doctor_first_name"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="doctor_last_name">Nazwisko doktora</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="text" name="doctor_last_name" id="doctor_last_name"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="visit_date">Data wizyty</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="date" name="visit_date" id="visit_date"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td>');
                            print('<label for="visit_hour">Godzina wizyty</label>');
                        print('</td>');
                        print('<td>');
                            print('<input type="time" name="visit_hour" id="visit_hour"></input>');
                        print('</td>');
                    print('</tr>');
                    print('<tr>');
                        print('<td><button class="data_box__button" id="save_button">Zapisz</button></td>');
                    print('</tr>');
                print('</table>');
            print('</form>');

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $get_visits_count = $pdo->query('SELECT count(*) FROM visits WHERE username = "' . $username . '"');
                $get_visits_count->execute();
                $row = $get_visits_count->fetchAll();
                $count = $row[0][0];
                if($count == 0)
                {
                    echo "Nie zaplanowano żadnych wizyt.";
                }
                else
                {
                    $get_visits = $pdo->query('SELECT * FROM visits WHERE username = "' . $username . '" ORDER BY visit_date DESC');
                    $get_visits->execute();
                    $row = $get_visits->fetchAll();
                    
                    for($i = 0; $i < $count; $i++)
                    {
                        if($row[$i][3] <= date('Y-m-d') && $row[$i][4] <= date('H:i:s'))
                        {
                            echo "<p class='data_box__deseases_list'>Odbyte wizyty</p>";
                            echo "<div class='treatment_box'>";
                                echo "<div class='data_box__delete_button' id='" . $row[$i][3] . "'><a href='delete_visit.php?date=" . $row[$i][3] . "&hour=" . $row[$i][4] . "'>X</a></div>";
                                echo "<span class='data_box__spec'>Imię lekarza:</span><span class='test_name'>" . $row[$i][1] . "</span><br />";
                                echo "<span class='data_box__spec'>Nazwisko lekarza:</span><span class='test_date'>" . $row[$i][2] . "</span><br />";
                                echo "<span class='data_box__spec'>Data wizyty:</span><span id='visit_date'>" . $row[$i][3] . "</span><br />";
                                echo "<span class='data_box__spec'>Godzina wizyty:</span><span id='visit_hour'>" . $row[$i][4] . "</span>";
                                echo "<br /><br />";
                            echo "</div>";
                        }
                        else if($row[$i][3] > date('Y-m-d') && $row[$i][4] > date('H:i:s'))
                        {
                            echo "<p class='data_box__deseases_list'>Zaplanowane wizyty:</p>";
                            echo "<div class='treatment_box'>";
                                echo "<div class='data_box__delete_button' id='" . $row[$i][3] . "'><a href='delete_visit.php?date=" . $row[$i][3] . "&hour=" . $row[$i][4] . "'>X</a></div>";
                                echo "<span class='data_box__spec'>Imię lekarza:</span><span class='test_name'>" . $row[$i][1] . "</span><br />";
                                echo "<span class='data_box__spec'>Nazwisko lekarza:</span><span class='test_date'>" . $row[$i][2] . "</span><br />";
                                echo "<span class='data_box__spec'>Data wizyty:</span><span id='visit_date'>" . $row[$i][3] . "</span><br />";
                                echo "<span class='data_box__spec'>Godzina wizyty:</span><span id='visit_hour'>" . $row[$i][4] . "</span>";
                                echo "<br /><br />";
                            echo "</div>";
                        }
                        else
                        {
                            echo "<p class='data_box__deseases_list'>Zaplanowane wizyty:</p>";
                            echo "<div class='treatment_box'>";
                                echo "<div class='data_box__delete_button' id='" . $row[$i][3] . "'><a href='delete_visit.php?date=" . $row[$i][3] . "&hour=" . $row[$i][4] . "'>X</a></div>";
                                echo "<span class='data_box__spec'>Imię lekarza:</span><span class='test_name'>" . $row[$i][1] . "</span><br />";
                                echo "<span class='data_box__spec'>Nazwisko lekarza:</span><span class='test_date'>" . $row[$i][2] . "</span><br />";
                                echo "<span class='data_box__spec'>Data wizyty:</span><span id='visit_date'>" . $row[$i][3] . "</span><br />";
                                echo "<span class='data_box__spec'>Godzina wizyty:</span><span id='visit_hour'>" . $row[$i][4] . "</span>";
                                echo "<br /><br />";
                            echo "</div>";
                        }
                    }
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function addVisit()
        {
            $username = $_SESSION['username'];
            $doctor_first_name = $_POST['doctor_first_name'];
            $doctor_last_name = $_POST['doctor_last_name'];
            $visit_date = $_POST['visit_date'];
            $visit_hour = $_POST['visit_hour'];

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $get_mail = $pdo->query('SELECT email_addr FROM users WHERE username = "' . $username . '"');
                $get_mail->execute();
                $mail_count = $get_mail->fetchAll();
                foreach($mail_count as $row)
                {
                    $mail = $row['email_addr'];
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $check_medicament = $pdo->query('SELECT count(*) FROM visits WHERE username = "' . $username . '" AND doctor_first_name = "' . $doctor_first_name . '" AND doctor_last_name = "' . $doctor_last_name . '" AND visit_date = "' . $visit_date . '" AND visit_hour = "' . $visit_hour . '"');
                $check_medicament->execute();
                $row = $check_medicament->fetchAll();
                $count = $row[0][0];

                if($count != 0)
                {
                    echo "Masz już zaplanowaną taką wizytę! Proszę zmienić dane.";
                }
                else
                {
                    $subject = 'HealthCenter - Twoja wizyta';
                    $message = 'Dzień dobry! <br /> Twoja wizyta u ' . $doctor_first_name . ' ' . $doctor_last_name . ' została zaplanowana i zapisana w systemie z datą: ' . $visit_date . ' i godziną: ' . $visit_hour . '. <br /> Dozobaczenia!';
                    $pdo->query('INSERT INTO visits(username, doctor_first_name, doctor_last_name, visit_date, visit_hour) VALUES ("' . $username . '", "' . $doctor_first_name . '", "' . $doctor_last_name . '", "' . $visit_date . '", "' . $visit_hour . '")');
                    mail($mail, $subject, $message);
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function deleteVisit()
        {
            session_start();
            $username = $_SESSION['username'];
            $date = $_GET['date'];
            $hour = $_GET['hour'];

            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $delete_visit = $pdo->query('DELETE FROM visits WHERE username = "' . $username . '" AND visit_date = "' . $date . '" AND visit_hour = "' . $hour . '"');
                $delete_visit->execute();
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }

        public function logout()
        {
            session_start();
            $username = $_SESSION['username'];
            
            
            try
            {
                $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_SCHEMA, DB_USER, DB_PASSWORD);
                $check_login = $pdo->query('SELECT count(*) FROM login_users WHERE username = "' . $username . '"');
                if($check_login == 0)
                {
                    header('Location: index.php');
                }
                else
                {
                    $pdo->query('DELETE FROM login_users WHERE username = "' . $username . '"');
                    session_destroy();
                    echo '<p class="message">Zostałeś wylogowany. <a href="index.php">Powrót do strony logowania</a></p>';
                }
            }
            catch(PDOException $e)
            {
                echo 'Wystąpił błąd! (' . $e->getMessage() . ') :( Prosimy spróbować ponownie.';
                die();
            }
        }
        
    }

?>