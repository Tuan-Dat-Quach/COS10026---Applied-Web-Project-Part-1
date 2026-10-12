<?php

    function sanitize_input($data){
         $data = trim($data);
         $data = stripslashes($data);
         $data = htmlspecialchars($data);
         return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $job_reference_number = sanitize_input($_POST["Job_Reference_Number"]);
        $first_name = sanitize_input($_POST["First_Name"]);
        $last_name = sanitize_input($_POST["Last_Name"]);
        $date_of_birth = sanitize_input($_POST["Date_of_Birth"]);
        $gender = sanitize_input($_POST["Gender"]);
        $street_address = sanitize_input($_POST["Street_Address"]);
        $suburb = sanitize_input($_POST["Suburb/Town"]);
        $state = $_POST["State"];
        $postcode = sanitize_input($_POST["Postcode"]);
        $email = sanitize_input($_POST["Email"]);
        $phone_number = sanitize_input($_POST["Phone_Number"]);
        $skills = isset($_POST["Skills"]) ? $_POST["Skills"] : [];
        $other_skills = sanitize_input($_POST["Other_Skills"]);


        if empty($job_reference_number) {
            echo "Please enter the Job Reference Number of the position you plan to apply for. <br>";
        }

    }


?>