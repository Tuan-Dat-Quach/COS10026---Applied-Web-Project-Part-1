
<?php
    session_start();
    require_once 'settings.php';

    function sanitize_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $create_eoi_sql = "CREATE TABLE IF NOT EXISTS `eoi` (
        `user_id` int(11) DEFAULT NULL,
        `eoi_number` int(11) NOT NULL,
        `job_reference` char(6) NOT NULL,
        `first_name` varchar(20) NOT NULL,
        `last_name` varchar(20) NOT NULL,
        `date_of_birth` date NOT NULL,
        `gender` enum('Male','Female','Rather Not Say') NOT NULL,
        `street_address` varchar(40) NOT NULL,
        `suburb` varchar(40) NOT NULL,
        `state` enum('VIC','NSW','QLD','NT','WA','SA','TAS','ACT') NOT NULL,
        `postcode` char(4) NOT NULL,
        `email` varchar(100) NOT NULL,
        `phone_number` varchar(12) NOT NULL,
        `other_skills` text DEFAULT NULL,
        `status` enum('NEW','CURRENT','FINAL') NOT NULL DEFAULT 'NEW'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ";

    $create_eoi_skills_sql = "CREATE TABLE IF NOT EXISTS `eoi_skills` (
        `eoi_number` int(11) NOT NULL,
        `skill_id` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Greener Society position description page featuring current environmental conservation employment opportunities.">
    <meta name="keywords" content="Greener Society, environmental jobs, conservation jobs, recruitment, sustainability">
    <meta name="author" content="TechTide Group">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Greener Society - Position Descriptions</title>

    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="manager-page">

<?php include 'header.inc'; ?>

  <main>
    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $skills = sanitize_input($_POST["Skills"] ?? []);
        if (!is_array($skills)) {
            $skills = [];
        }
        $other_skills = sanitize_input($_POST["Other_Skills"]);
        $status = "NEW";

        $error_messages = [];

        if (empty($job_reference_number)) {
            $error_messages[] = "<p> Please enter the Job Reference Number (either GS102A, GS204B, or GS305C). </p> <br>";
        } elseif (!preg_match("/^(GS102A|GS204B|GS305C)$/",$job_reference_number)) {
            $error_messages[] = "<p> Please enter the correct Job Reference Number (GS102A, GS204B, or GS305C, it is case-sensitive). </p> <br>";
        } 
        
        if (empty($first_name)) {
            $error_messages[] = "<p> Please enter your First Name. <br>";
        } elseif (!preg_match("/^[a-zA-Z-' ]{1,20}$/",$first_name)) {
            $error_messages[] = "<p> Please enter a valid First Name. It must only contain letters, spaces and/or ' or -. </p> <br>";
        } 

        if (empty($last_name)) {
            $error_messages[] = "<p> Please enter your Last Name.</p> <br>";
        } elseif (!preg_match("/^[a-zA-Z-' ]{1,20}$/",$last_name)) {
            $error_messages[] = "<p> Please enter a valid Last Name. It must only contain letters, spaces and/or ' or -. </p> <br>";
        } 

        if (empty($date_of_birth)) {
            $error_messages[] = "<p> Please enter your Date of Birth. </p> <br>";
        } 

        if (empty($gender)) {
            $error_messages[] = "<p> Please select your preferred Gender. </p> <br>";
        } 

        if (empty($street_address)) {
            $error_messages[] = "<p> Please enter your Street Address. </p> <br>";
        } elseif (!preg_match("/^.{1,40}$/",$street_address)) {
            $error_messages[] = "<p> Please enter a valid Street Address. </p> <br>";
        } 

        if (empty($suburb)) {
            $error_messages[] = "<p> Please enter your Suburb. </p> <br>";
        } elseif (!preg_match("/^.{1,40}$/",$suburb)) {
            $error_messages[] = "<p> Please enter a valid Suburb. </p> <br>";
        } 

        if (empty($state)) {
            $error_messages[] = "<p> Please select your State. </p> <br>";
        } 

        if (empty($postcode)) {
            $error_messages[] = "<p> Please enter your Postcode. </p> <br>";
        } elseif (!preg_match("/^[0-9]{4}$/",$postcode)) {
            $error_messages[] = "<p> Please enter a valid Postcode. It must only contain numbers and be exactly 4 digits in length. </p> <br>";
        } 

        if (empty($email)) {
            $error_messages[] = "<p> Please enter your Email. </p> <br>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_messages[] = "<p> Please enter a valid Email. </p> <br>";
        } 

        $skills_valid = true;

        $allowed_skills = ['Loves The Environment', 'Organization', 'Punctuality', 'Hard Working', 'Resilience', 'Team Player', 'Passionate', 'Leadership', 'Communication'];
            
        foreach ($skills as $skill) {
            if (!in_array($skill, $allowed_skills, true)) {
                $skills_valid = false;
            }
        }

        if (!$skills_valid) {
            $error_messages[] = "<p> Please select valid skills only. </p> <br>";
        }

        if (empty($phone_number)) {
            $error_messages[] = "<p> Please enter your Phone Number. </p> <br>";
        } elseif (!preg_match("/^[0-9]{8,12}$/",$phone_number)) {
            $error_messages[] = "<p> Please enter a valid Phone Number. It must only contain numbers and be 8-12 digits in length. </p> <br>";
        } 

        if (!empty($error_messages)) {
            echo "<h2> Your application has been successfully submitted! </h2>";
            echo "<table>";
            echo "<tr>";
            echo "<th> Job Reference Number: </th>";
            echo "<td> $job_reference_number </td>";
            echo "</tr>"
            echo "<tr>";
            echo "<th> First Name: </th>";
            echo "<td> $first_name </td>";
            echo "</tr>"
            echo "<tr>";
            echo "<th> Last Name: </th>";
            echo "<td> $last_name </td>";
            echo "</tr>"
            echo "<tr>";
            echo "<th> Date of Birth: </th>";
            echo "<td> $date_of_birth </td>";
            echo "</tr>"
            echo "<tr>";
            echo "<th> Gender: </th>";
            echo "<td> $gender </td>";
            echo "</tr>"
            echo "<tr>";
            echo "<th> Street Address: </th>";
            echo "<td> $street_address </td>";
            echo "</tr>"
            echo "<tr>";
            echo "<th> Suburb: </th>";
            echo "<td> $suburb </td>";
            echo "</tr>"
            echo "<tr>";
            echo "<th> State: </th>"; 
            echo "<td> $state </td>";
            echo "</tr>"
            echo "<tr>";
            echo "<th> Postcode: </th>";
            echo "<td> $postcode </td>";
            echo "</tr>"
            echo "<tr>";
            echo "<th> Email: </th>";
            echo "<td> $email </td>";
            echo "</tr>"
            echo "<tr>";
            echo "<th> Phone Number: </th>";
            echo "<td> $phone_number </td>";
            echo "</tr>"
            echo "<tr>";
            echo "<th> Skills: </th>";
            echo "<td>" . implode(", ", $skills) . "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th> Other Skills: </th>";
            echo "<td> $other_skills </td>";
            echo "</tr>";
            echo "</table>";

            $stmteoi = $conn->prepare("INSERT INTO `eoi` (`user_id`, `job_reference`, `first_name`, `last_name`, `date_of_birth`, `gender`, `street_address`, `suburb`, `state`, `postcode`, `email`, `phone_number`, `other_skills`, `status`)
                                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmteoi->bind_param("isssssssssssss", $user_id, $job_reference_number, $first_name, $last_name, $date_of_birth, $gender, $street_address, $suburb, $state, $postcode, $email, $phone_number, $other_skills, $status);
            $stmteoi->execute();
            $form_eoinumber = $conn->insert_id;
            $stmteoi->close();

            foreach ($skills as $value[]) {
                $stmtskills = $conn->prepare("SELECT skill_id FROM skills WHERE skill_name = ?");
                $stmtskills->bind_param("s", $value);
                $stmtskills->execute();
                $resultskills = $stmtskills->get_result();
                $single_skill = $resultskills->fetch_assoc();
                $stmtskills->close();

                if ($single_skill) {
                    $skill_id = $single_skill['skill_id'];
                    $stmteoiskills = $conn->prepare("INSERT INTO eoi_skills (eoi_number, skill_id)
                                                     VALUES (?, ?)");
                    $stmteoiskills->bind_param("ii", $form_eoinumber, $skill_id);
                    $stmteoiskills->execute();
                    $stmteoiskills->close();
                }
            }
        } else {
            echo "<p> <strong> Please go back in fix all errors. </strong> </p>";
        }


    }

    ?>
  </main>

<?php include 'footer.inc'; ?>

</body>
</html>