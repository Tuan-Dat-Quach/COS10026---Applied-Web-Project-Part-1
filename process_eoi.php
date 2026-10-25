
<?php
    session_start();
    require_once 'settings.php';
    // Block direct URL access
    if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["Job_Reference_Number"])) {
        header("Location: apply.php");
        exit;
    }
    // Sanitise input with trim, stripslashes and htmlspecialchars
    function sanitize_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    /* Create tables skills, eoi and eoi_skills if they do not exist, with eoi_skills
    along with its inserted contents */
    $create_skills_sql = "CREATE TABLE IF NOT EXISTS skills (
        skill_id INT(11) NOT NULL AUTO_INCREMENT,
        skill_name VARCHAR(50) NOT NULL,
        PRIMARY KEY (skill_id),
        UNIQUE KEY skill_name (skill_name)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    $create_eoi_sql = "CREATE TABLE IF NOT EXISTS eoi (
        user_id INT(11) DEFAULT NULL,
        eoi_number INT(11) NOT NULL AUTO_INCREMENT,
        job_reference CHAR(6) NOT NULL,
        first_name VARCHAR(20) NOT NULL,
        last_name VARCHAR(20) NOT NULL,
        date_of_birth DATE NOT NULL,
        gender ENUM('Male','Female','Rather Not Say') NOT NULL,
        street_address VARCHAR(40) NOT NULL,
        suburb VARCHAR(40) NOT NULL,
        state ENUM('VIC','NSW','QLD','NT','WA','SA','TAS','ACT') NOT NULL,
        postcode CHAR(4) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone_number VARCHAR(12) NOT NULL,
        other_skills TEXT DEFAULT NULL,
        status ENUM('NEW','CURRENT','FINAL') NOT NULL DEFAULT 'NEW',
        PRIMARY KEY (eoi_number),
        KEY user_id (user_id),
        KEY job_reference (job_reference),
        CONSTRAINT eoi_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (user_id),
        CONSTRAINT eoi_ibfk_2 FOREIGN KEY (job_reference) REFERENCES jobs (job_reference)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    $create_eoi_skills_sql = "CREATE TABLE IF NOT EXISTS eoi_skills (
        eoi_number INT(11) NOT NULL,
        skill_id INT(11) NOT NULL,
        PRIMARY KEY (eoi_number, skill_id),
        KEY skill_id (skill_id),
        CONSTRAINT eoi_skills_ibfk_1 FOREIGN KEY (eoi_number) REFERENCES eoi (eoi_number) ON DELETE CASCADE,
        CONSTRAINT eoi_skills_ibfk_2 FOREIGN KEY (skill_id) REFERENCES skills (skill_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    if (!mysqli_query($conn, $create_skills_sql) ||
        !mysqli_query($conn, $create_eoi_sql) || 
        !mysqli_query($conn, $create_eoi_skills_sql)) {
        die("Could not set up the required tables.");
    }
    // Use INSERT IGNORE INTO to prevent duplicate data
    $default_skills = ['Loves The Environment', 'Organization', 'Punctuality', 'Hard Working',
                   'Resilience', 'Team Player', 'Passionate', 'Leadership', 'Communication'];

    foreach ($default_skills as $skill_name) {
        $stmt = $conn->prepare("INSERT IGNORE INTO skills (skill_name) VALUES (?)");
        $stmt->bind_param("s", $skill_name);
        $stmt->execute();
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Greener Society position description page featuring current environmental conservation employment opportunities.">
    <meta name="keywords" content="Greener Society, environmental jobs, conservation jobs, recruitment, sustainability">
    <meta name="author" content="TechTide Group">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Greener Society - Submit Application</title>

    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="process-page">

<?php include 'header.inc'; ?>

  <main>
    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_SESSION['user_id'] ?? null;
        $job_reference_number = sanitize_input($_POST["Job_Reference_Number"] ?? "");
        $first_name = sanitize_input($_POST["First_Name"] ?? "");
        $last_name = sanitize_input($_POST["Last_Name"] ?? "");
        $date_of_birth = sanitize_input($_POST["Date_of_Birth"] ?? "");
        $gender = sanitize_input($_POST["Gender"] ?? "");
        $street_address = sanitize_input($_POST["Street_Address"] ?? "");
        $suburb = sanitize_input($_POST["Suburb"] ?? "");
        $state = sanitize_input($_POST["State"] ?? "");
        $postcode = sanitize_input($_POST["Postcode"] ?? "");
        $email = sanitize_input($_POST["Email"] ?? "");
        $phone_number = sanitize_input($_POST["Phone_Number"] ?? "");

        $skills = $_POST["Skills"] ?? [];
        if (!is_array($skills)) {
            $skills = [];
        }
        foreach ($skills as $single_skill => $skill) {
            $skills[$single_skill] = sanitize_input($skill);
        }

        $other_skills = sanitize_input($_POST["Other_Skills"] ?? "");
        $status = "NEW";

        $error_messages = [];

        $allowed_job_references = [];

        $result = mysqli_query($conn, "SELECT job_reference FROM jobs");

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $allowed_job_references[] = $row['job_reference'];
            }
        }

        if (empty($job_reference_number)) {
            $error_messages[] = "Please enter the Job Reference Number.";
        } elseif (!in_array($job_reference_number, $allowed_job_references, true)) {
            $error_messages[] = "Please enter a valid Job Reference Number (it is case-sensitive).";
        } 
        
        if (empty($first_name)) {
            $error_messages[] = "Please enter your First Name.";
        } elseif (!preg_match("/^[a-zA-Z-' ]{1,20}$/",$first_name)) {
            $error_messages[] = "Please enter a valid First Name. It must only contain letters, spaces and/or ' or -.";
        } 

        if (empty($last_name)) {
            $error_messages[] = "Please enter your Last Name.";
        } elseif (!preg_match("/^[a-zA-Z-' ]{1,20}$/",$last_name)) {
            $error_messages[] = "Please enter a valid Last Name. It must only contain letters, spaces and/or ' or -.";
        } 

        if (empty($date_of_birth)) {
            $error_messages[] = "Please enter your Date of Birth.";
        } 

        $allowed_gender = ['Male', 'Female', 'Rather Not Say'];

        if (empty($gender)) {
            $error_messages[] = "Please select your gender.";
        } elseif (!in_array($gender, $allowed_gender, true)) {
            $error_messages[] = "Please select valid gender only.";
        }

        if (empty($street_address)) {
            $error_messages[] = "Please enter your Street Address.";
        } elseif (!preg_match("/^.{1,40}$/",$street_address)) {
            $error_messages[] = "Please enter a valid Street Address.";
        } 

        if (empty($suburb)) {
            $error_messages[] = "Please enter your Suburb.";
        } elseif (!preg_match("/^.{1,40}$/",$suburb)) {
            $error_messages[] = "Please enter a valid Suburb.";
        } 

        $allowed_state = ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'];

        if (empty($state)) {
            $error_messages[] = "Please select your State.";
        } elseif (!in_array($state, $allowed_state, true)) {
            $error_messages[] = "Please select valid state only.";
        }

        if (empty($postcode)) {
            $error_messages[] = "Please enter your Postcode.";
        } elseif (!preg_match("/^[0-9]{4}$/",$postcode)) {
            $error_messages[] = "Please enter a valid Postcode. It must only contain numbers and be exactly 4 digits in length.";
        } 

        if (empty($email)) {
            $error_messages[] = "Please enter your Email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_messages[] = "Please enter a valid Email.";
        } 

        $skills_valid = true;

        $allowed_skills = ['Loves The Environment', 'Organization', 'Punctuality', 'Hard Working', 
                         'Resilience', 'Team Player', 'Passionate', 'Leadership', 'Communication'];
            
        foreach ($skills as $skill) {
            if (!in_array($skill, $allowed_skills, true)) {
                $skills_valid = false;
            }
        }

        if (empty($skills)) {
            $error_messages[] = "Please select at least one skill.";
        } elseif (!$skills_valid) {
            $error_messages[] = "Please select valid skills only.";
        }

        if (empty($phone_number)) {
            $error_messages[] = "Please enter your Phone Number.";
        } elseif (!preg_match("/^[0-9]{8,12}$/",$phone_number)) {
            $error_messages[] = "Please enter a valid Phone Number. It must only contain numbers and be 8-12 digits in length.";
        } 

        if (empty($error_messages)) {

            $stmteoi = $conn->prepare("INSERT INTO `eoi` (`user_id`, `job_reference`, `first_name`, `last_name`, `date_of_birth`, 
                                      `gender`, `street_address`, `suburb`, `state`, `postcode`, `email`, `phone_number`, `other_skills`, `status`)
                                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmteoi->bind_param("isssssssssssss", $user_id, $job_reference_number, $first_name, $last_name, $date_of_birth, 
                                 $gender, $street_address, $suburb, $state, $postcode, $email, $phone_number, $other_skills, $status);

            if ($stmteoi->execute()) {
                $form_eoinumber = $conn->insert_id;
                $stmteoi->close();
            
                foreach ($skills as $value) {
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

                echo "<h1> Application Submission </h1>";
                echo "<p> Your application has been successfully submitted! </p>";
                echo "<p> Your EOI number is: <strong>" . (int)$form_eoinumber . "</strong> </p>";
                echo "<table>";
                echo "<tr>";
                echo "<th> Job Reference Number: </th>";
                echo "<td> $job_reference_number </td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th> First Name: </th>";
                echo "<td> $first_name </td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th> Last Name: </th>";
                echo "<td> $last_name </td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th> Date of Birth: </th>";
                echo "<td> $date_of_birth </td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th> Gender: </th>";
                echo "<td> $gender </td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th> Street Address: </th>";
                echo "<td> $street_address </td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th> Suburb: </th>";
                echo "<td> $suburb </td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th> State: </th>"; 
                echo "<td> $state </td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th> Postcode: </th>";
                echo "<td> $postcode </td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th> Email: </th>";
                echo "<td> $email </td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th> Phone Number: </th>";
                echo "<td> $phone_number </td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th> Skills: </th>";
                echo "<td>" . implode(", ", $skills) . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th> Other Skills: </th>";
                echo "<td> $other_skills </td>";
                echo "</tr>";
                echo "</table>";

                unset($_SESSION['form_data']);
            } else {
                $error_messages[] = "Unable to submit your application.";
                $stmteoi->close();
            }
        } else {
            $_SESSION['form_data'] = $_POST;
            echo "<ul class='error-list'>";
            foreach ($error_messages as $message) { 
                echo "<li>" . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "</li>";
            }
            echo "</ul>";
            echo "<p class='error-eoi'> <strong> ⚠️ Please go back to <a href='apply.php'> Apply page </a> and fix all errors. </strong> </p>";
        }
    }

    ?>
  </main>

<?php include 'footer.inc'; ?>

</body>
</html>