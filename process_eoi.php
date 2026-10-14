<?php
    
    $jrn_input = false
        $fn_input = false
        $ln_input = false
        $dob_input = false
        $gender_input = false
        $sa_input = false
        $suburb_input = false
        $state_input = false
        $postcode_input = false
        $email_input = false
        $pn_input = false
        $skills_input = false

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
        } else {
            $jrn_input = true
        }
        
        if (empty($first_name)) {
            echo "Please enter your First Name. <br>";
        }  elseif (!preg_match("/^[a-zA-z-' ]{1, 20}$/",$first_name)) {
            echo "Please enter a valid First Name. <br>";
        } else {
            $fn_input = true
        }

        if (empty($last_name)) {
            echo "Please enter your Last Name. <br>";
        }  elseif (!preg_match("/^[a-zA-z-' ]{1, 20}$/",$last_name)) {
            echo "Please enter a valid Last Name. <br>";
        } else {
            $ln_input = true
        }

        if (empty($date_of_birth)) {
            echo "Please enter your Date of Birth. <br>";
        } else {
            $dob_input = true
        }

        if (empty($gender)) {
            echo "Please select your preferred Gender. <br>";
        } else {
            $gender_input = true
        }

        if (empty($street_address)) {
            echo "Please enter your Street Address. <br>";
        }  elseif (!preg_match("/^.{1, 40}$/",$street_address)) {
            echo "Please enter a valid Street Address. <br>";
        } else {
            $sa_input = true
        }

        if (empty($suburb)) {
            echo "Please enter your Suburb. <br>";
        }  elseif (!preg_match("/^.{1, 40}$/",$suburb)) {
            echo "Please enter a valid Suburb. <br>";
        } else {
            $suburb_input = true
        }

        if (empty($state)) {
            echo "Please select your State. <br>";
        } else {
            $state_input = true
        }

        if (empty($postcode)) {
            echo "Please enter your Postcode. <br>";
        }  elseif (!preg_match("/^[0-9]{4}*$/",$postcode)) {
            echo "Please enter a valid Postcode. <br>";
        } else {
            $postcode_input = true
        }

        if (empty($email)) {
            echo "Please enter your Email. <br>";
        }  elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Please enter a valid Email. <br>";
        } else {
            $email_input = true
        }

        if (empty($phone_number)) {
            echo "Please enter your Phone Number. <br>";
        }  elseif (!preg_match("/^[0-9]{8, 12}$/",$phone_number)) {
            echo "Please enter a valid Phone Number. <br>";
        } else {
            $pn_input = true
        }

        if (empty($skills)) {
            echo "Please select the skills you think defines you. <br>";
        } else {
            $skills_input = true
        }

        if ($jrn_input = true && $fn_input = true && $ln_input = true && $dob_input = true && $gender_input = true && $sa_input = true
        && $suburb_input = true && $state_input = true && $postcode_input = true && $email_input = true && $pn_input = true && $skills_input = true) {
            echo "<h2>Your application has been successfully submitted!</h2>";
            echo "<p><strong>Job Reference Number:</strong> $job_reference_number</p>";
            echo "<p><strong>First Name:</strong> $first_name</p>";
            echo "<p><strong>Last Name:</strong> $last_name</p>";
            echo "<p><strong>Date of Birth:</strong> $date_of_birth</p>";
            echo "<p><strong>Gender:</strong> $gender</p>";
            echo "<p><strong>Street Address:</strong> $street_address</p>";
            echo "<p><strong>Suburb:</strong> $suburb</p>";
            echo "<p><strong>State:</strong> $state</p>";
            echo "<p><strong>Postcode:</strong> $postcode</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            echo "<p><strong>Phone Number:</strong> $phone_number</p>";
            echo "<p><strong>Skills:</strong> " . implode(", ", $skills) . "</p>";
            echo "<p><strong>Other Skills:</strong> $other_skills</p>";
        } else {
            echo "<p><strong>Please go back in fix all errors.</strong></p>"
        }

    }


?>