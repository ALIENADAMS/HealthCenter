<?php

    include_once 'Database.php';

    //Class for patient operation

    class Patient
    {
        //constructor
        public function __construct()
        {

        }

        //get patient data, check and insert to database
        public static function updatePatientData()
        {
            $username = $_SESSION['username'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $street = $_POST['street'];
            $home_number = $_POST['home_number'];
            $postal_code = $_POST['postal_code'];
            $city = $_POST['city'];

            trim($first_name);
            trim($last_name);
            trim($street);
            trim($home_number);
            trim($postal_code);
            trim($city);

            if($first_name == '' || $first_name == ' ' || $last_name == '' || $last_name == ' ' || $home_number == '' || $home_number == ' ' || $postal_code == '' || $postal_code == ' ' || $city == '' || $city == ' ')
            {
                echo 'Proszę wypełnić wszystkie wymagane dane.';
            }
            else
            {
                $Database = new Database();
                $Database->serverConnect();
                $Database->updateUserData($username, $first_name, $last_name, $street, $home_number, $postal_code, $city);
            }
        }

        //fill form with user data
        public static function fillFormUserData()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->getUserData();
        }

        //get user disease
        public static function getPatientDesease()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->getPatientDesease();
        }

        //save user disease
        public static function addPatientDesease()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->addPatientDesease();
        }

        //get treatment process
        public static function getTreatmentProcess()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->getTreatmentProcess();
        }

        //delete user disease
        public static function deletePatientDesease()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->deletePatientDesease();
        }

        //get hemoglobin
        public static function getHemoglobin()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->getHemoglobin();
        }

        //get doctors
        public static function getDoctors()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->getDoctors();
        }

        //save user doctor
        public static function addDoctor()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->addDoctor();
        }

        //delete user doctor
        public static function deleteDoctor()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->deleteDoctor();
        }

        //get results
        public static function getResults()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->getResults();
        }

        //add test result
        public static function addTestResult()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->addTestResult();
        }

        //delete test result
        public static function deleteTestResult()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->deleteTestResult();
        }

        //get medicaments
        public static function getMedicaments()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->getMedicaments();
        }

        //add medicament
        public static function addMedicament()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->addMedicament();
        }

        //delete medicament
        public static function deleteMedicament()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->deleteMedicament();
        }

        //get visits
        public static function getVisits()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->getVisits();
        }

        //add visit
        public static function addVisit()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->addVisit();
        }

        //delete visit
        public static function deleteVisit()
        {
            $Database = new Database();
            $Database->serverConnect();
            $Database->deleteVisit();
        }
    }

?>