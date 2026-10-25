<?php
  session_start();
  require_once "settings.php";

  // Validate logged-in account
  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
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

    <title>Greener Society - View EOI details</title>

    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="manager-page">

<?php include 'header.inc'; ?>

    <main class="details-page">
    <?php
      // Validate if the user has used the "View EOI" button
      if (isset($_GET['chosen_eoi_number'])) {
        $eoi_number = $_GET['chosen_eoi_number'] ?? '';
        $sql_chosen_eoi = "SELECT * FROM eoi WHERE eoi_number = ?";

        if ($stmt = $conn->prepare($sql_chosen_eoi)) {
          $stmt->bind_param("i", $eoi_number);
          $stmt->execute();
          $result = $stmt->get_result();
          $chosen_eoi = mysqli_fetch_assoc($result);
          $stmt->close();
         
          if ($chosen_eoi) {
            // Ensure that user account can only view their own EOIs
            if ($_SESSION['role'] === 'User' && $chosen_eoi['user_id'] != $_SESSION['user_id']) {
              $chosen_eoi = null;  
            }
            
            echo "<h1> Details for EOI number: " . htmlspecialchars($chosen_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "</h1>";
            echo "<div class='table-wrapper-2'>";
            echo "<table>";
            echo "<tr>";
            // These sections use grid layout, so they are not organized in order as in the table

            // User ID
            echo "<th> User ID </th>";
            if ($chosen_eoi['user_id'] === NULL) {
              echo "<td> Anonymous </td>";
            } else {
              echo "<td>" . htmlspecialchars($chosen_eoi['user_id'], ENT_QUOTES, 'UTF-8') . "</td>";
            }
            // Postcode
            echo "<th> Postcode </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['postcode'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
            // EOI number
            echo "<tr>";
            echo "<th> EOI number </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "</td>";
            // Email
            echo "<th> Email </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['email'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
            // Job Reference number
            echo "<tr>";
            echo "<th> Job Reference </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['job_reference'], ENT_QUOTES, 'UTF-8') . "</td>";
            // Phone Number
            echo "<th> Phone number </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['phone_number'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
            // First name
            echo "<tr>";
            echo "<th> First name </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['first_name'], ENT_QUOTES, 'UTF-8') . "</td>";
            // Skills
            echo "<th rowspan='3'> Skills </th>";
            echo "<td rowspan='3'>";
            // Prepared statement to take the skill names, then join them to eoi_skills table
            $stmt = $conn->prepare("SELECT s.skill_name FROM eoi_skills es JOIN skills s ON s.skill_id = es.skill_id
                                    WHERE es.eoi_number = ? ORDER BY s.skill_id");
            $stmt->bind_param("i", $chosen_eoi['eoi_number']);
            $stmt->execute();
            $skill_result = $stmt->get_result();
            
            while ($skill = mysqli_fetch_assoc($skill_result)) {
              echo htmlspecialchars($skill['skill_name'], ENT_QUOTES, 'UTF-8') . "<br>";
            }
            $stmt->close();

            echo "</td>";
            echo "</tr>";
            // Last name
            echo "<tr>";
            echo "<th> Last name </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['last_name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
            // Date of birth
            echo "<tr>";
            echo "<th class='cell-3'> Date of birth </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['date_of_birth'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
            // Gender
            echo "<tr>";
            echo "<th> Gender </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['gender'], ENT_QUOTES, 'UTF-8') . "</td>";
            // Other skills
            echo "<th rowspan='3'> Other skills </th>";
            if (empty($chosen_eoi['other_skills'])) {
              echo "<td rowspan='3'>" . htmlspecialchars(null) . "</td>";
            } else {
              echo "<td rowspan='3'>" . htmlspecialchars($chosen_eoi['other_skills'], ENT_QUOTES, 'UTF-8') . "</td>";
            }
            echo "</tr>";
            // Street address
            echo "<tr>";
            echo "<th> Street address </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['street_address'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
            // Suburb
            echo "<tr>";
            echo "<th> Suburb </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['suburb'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
            // State
            echo "<tr>";
            echo "<th> State </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['state'], ENT_QUOTES, 'UTF-8') . "</td>";
            // Status
            echo "<th> Status </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['status'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
        
            echo "</table>";
            echo "</div>";

          } else {
            echo "<p class='no-eoi'> This EOI cannot be found. </p>";
          }
        } else {
          echo "<p class='failed-stmt'> Sorry, something went wrong. Please try again later. </p>";
        }
      }
      mysqli_close($conn);
    ?>
    </main>

<?php include 'footer.inc'; ?>

</body>
</html>