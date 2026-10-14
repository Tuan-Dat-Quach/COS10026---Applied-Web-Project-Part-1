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
        $gender = $_POST["Gender"];
        $street_address = sanitize_input($_POST["Street_Address"]);
        $suburb = sanitize_input($_POST["Suburb/Town"]);
        $state = $_POST["State"];
        $postcode = sanitize_input($_POST["Postcode"]);
        $email = sanitize_input($_POST["Email"]);
        $phone_number = sanitize_input($_POST["Phone_Number"]);
        $skills = isset($_POST["Skills"]) ? $_POST["Skills"] : [];
        $other_skills = sanitize_input($_POST["Other_Skills"]);


        if (empty($job_reference_number)) {
            echo "Please enter the Job Reference Number of the position you plan to apply for. <br>";
        }  elseif (!preg_match(^GS102A$ | ^GS204B$ | ^GS305C$, $job_reference_number)) {
            echo "Please enter the correct Job Reference Number of the position you plan to apply for. <br>";
        }
        
        

        if (empty($first_name)) {
            echo "Please enter your First Name. <br>";
        }  elseif (!preg_match("/^[a-zA-z-' ]{1, 20}$/",$first_name)) {
            echo "Please enter a valid First Name. <br>";
        }

        if (empty($last_name)) {
            echo "Please enter your Last Name. <br>";
        }  elseif (!preg_match("/^[a-zA-z-' ]{1, 20}$/",$last_name)) {
            echo "Please enter a valid Last Name. <br>";
        }

        if (empty($date_of_birth)) {
            echo "Please enter your Date of Birth. <br>";
        } 

        if (empty($gender)) {
            echo "Please select your preferred Gender. <br>";
        }

        if (empty($street_address)) {
            echo "Please enter your Street Address. <br>";
        }  elseif (!preg_match("/^.{1, 40}$/",$street_address)) {
            echo "Please enter a valid Street Address. <br>";
        }

        if (empty($suburb)) {
            echo "Please enter your Suburb. <br>";
        }  elseif (!preg_match("/^.{1, 40}$/",$suburb)) {
            echo "Please enter a valid Suburb. <br>";
        }

        if (empty($state)) {
            echo "Please select your State. <br>";
        }

        if (empty($postcode)) {
            echo "Please enter your Postcode. <br>";
        }  elseif (!preg_match("/^[0-9]{4}*$/",$postcode)) {
            echo "Please enter a valid Postcode. <br>";
        }

        if (empty($email)) {
            echo "Please enter your Email. <br>";
        }  elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Please enter a valid Email. <br>";
        }

        if (empty($phone_number)) {
            echo "Please enter your Phone Number. <br>";
        }  elseif (!preg_match("/^[0-9]{8, 12}$/",$phone_number)) {
            echo "Please enter a valid Phone Number. <br>";
        }

        if (empty($skills)) {
            echo "Please select the skills you think defines you. <br>";
        }



    }


?>