
<?php
    session_start();

    require_once 'settings.php';



    function sanitize_input($data){
         $data = trim($data);
         $data = stripslashes($data);
         $data = htmlspecialchars($data);
         return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $user_id = (int)$_SESSION['user_id'];
        $job_reference_number = sanitize_input($_POST["Job_Reference_Number"]);
        $first_name = sanitize_input($_POST["First_Name"]);
        $last_name = sanitize_input($_POST["Last_Name"]);
        $date_of_birth = sanitize_input($_POST["Date_of_Birth"]);
        $gender = $_POST["Gender"];
        $street_address = sanitize_input($_POST["Street_Address"]);
        $suburb = sanitize_input($_POST["Suburb"]);
        $state = $_POST["State"];
        $postcode = sanitize_input($_POST["Postcode"]);
        $email = sanitize_input($_POST["Email"]);
        $phone_number = sanitize_input($_POST["Phone_Number"]);
        $skills = isset($_POST["Skills"]) ? $_POST["Skills"] : [];
        $other_skills = sanitize_input($_POST["Other_Skills"]);
        $status = "NEW";


        $jrn_input = false;
        $fn_input = false;
        $ln_input = false;
        $dob_input = false;
        $gender_input = false;
        $sa_input = false;
        $suburb_input = false;
        $state_input = false;
        $postcode_input = false;
        $email_input = false;
        $pn_input = false;
        $skills_input = false;
        $form_submit = false;

        if (empty($job_reference_number)) {
            echo "<p style='color:red;'>Please enter the Job Reference Number (either GS102A, GS204B, or GS305C).</p> <br>";
        }  elseif (!preg_match("/^(GS102A|GS204B|GS305C)$/",$job_reference_number)) {
            echo "<p style='color:red;'>Please enter the correct Job Reference Number (GS102A, GS204B, or GS305C, it is case sensitive).</p> <br>";
        } else {
            $jrn_input = true;
        }
        
        if (empty($first_name)) {
            echo "<p style='color:red;'>Please enter your First Name. <br>";
        }  elseif (!preg_match("/^[a-zA-Z-' ]{1,20}$/",$first_name)) {
            echo "<p style='color:red;'>Please enter a valid First Name. It must only contain letters, spaces and/or ' or -. <br>";
        } else {
            $fn_input = true;
        }

        if (empty($last_name)) {
            echo "<p style='color:red;'>Please enter your Last Name.</p> <br>";
        }  elseif (!preg_match("/^[a-zA-Z-' ]{1,20}$/",$last_name)) {
            echo "<p style='color:red;'>Please enter a valid Last Name. It must only contain letters, spaces and/or ' or -.</p> <br>";
        } else {
            $ln_input = true;
        }

        if (empty($date_of_birth)) {
            echo "<p style='color:red;'>Please enter your Date of Birth.</p> <br>";
        } else {
            $dob_input = true;
        }

        if (empty($gender)) {
            echo "<p style='color:red;'>Please select your preferred Gender.</p> <br>";
        } else {
            $gender_input = true;
        }

        if (empty($street_address)) {
            echo "<p style='color:red;'>Please enter your Street Address.</p> <br>";
        }  elseif (!preg_match("/^.{1,40}$/",$street_address)) {
            echo "<p style='color:red;'>Please enter a valid Street Address.</p> <br>";
        } else {
            $sa_input = true;
        }

        if (empty($suburb)) {
            echo "<p style='color:red;'>Please enter your Suburb.</p> <br>";
        }  elseif (!preg_match("/^.{1,40}$/",$suburb)) {
            echo "<p style='color:red;'>Please enter a valid Suburb.</p> <br>";
        } else {
            $suburb_input = true;
        }

        if (empty($state)) {
            echo "<p style='color:red;'>Please select your State.</p> <br>";
        } else {
            $state_input = true;
        }

        if (empty($postcode)) {
            echo "<p style='color:red;'>Please enter your Postcode.</p> <br>";
        }  elseif (!preg_match("/^[0-9]{4}$/",$postcode)) {
            echo "<p style='color:red;'>Please enter a valid Postcode. It must only contain numbers and be exactly 4 digits in length.</p> <br>";
        } else {
            $postcode_input = true;
        }

        if (empty($email)) {
            echo "<p style='color:red;'>Please enter your Email.</p> <br>";
        }  elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p style='color:red;'>Please enter a valid Email.</p> <br>";
        } else {
            $email_input = true;
        }

        if (empty($phone_number)) {
            echo "<p style='color:red;'>Please enter your Phone Number.</p> <br>";
        }  elseif (!preg_match("/^[0-9]{8,12}$/",$phone_number)) {
            echo "<p style='color:red;'>Please enter a valid Phone Number. It must only contain numbers and be 8-12 digits in length.</p> <br>";
        } else {
            $pn_input = true;
        }

        if ($jrn_input == true && $fn_input == true && $ln_input == true && $dob_input == true && $gender_input == true && $sa_input == true
        && $suburb_input == true && $state_input == true && $postcode_input == true && $email_input == true && $pn_input == true && $skills_input == true) {
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
            echo "<p><strong>Other Skills:</strong> $other_skills</p>";
            $form_submit = true;
        } else {
            echo "<p style='color:red;'><strong>Please go back in fix all errors.</strong></p>";
        }

        if ($form_submit == true) {
            foreach ($skills as )

            $stmt = $conn->prepare("INSERT INTO `eoi` (`user_id`, `job_reference`, `first_name`, `last_name`, `date_of_birth`, `gender`, `street_address`, `suburb`, `state`, `postcode`, `email`, `phone_number`, `other_skills`, `status`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssssssisiss", $user_id, $job_reference_number, $first_name, $last_name, $date_of_birth, $gender, $street_address, $suburb, $state, $postcode, $email, $phone_number, $other_skills, $status);
            $stmt->execute();
            
        }
        


    }

?>