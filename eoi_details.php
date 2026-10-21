<?php
  session_start();
  require_once "settings.php";
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

    <main class="details-page">
    <?php
      if (isset($_GET['chosen_eoi_number'])) {
        $eoi_number = $_GET['chosen_eoi_number'] ?? '';
        $sql_chosen_eoi = "SELECT * FROM eoi WHERE eoi_number = ?";

        if ($stmt = $conn->prepare($sql_chosen_eoi)) {
          $stmt->bind_param("i", $eoi_number);
          $stmt->execute();
          $result = $stmt->get_result();
          $chosen_eoi = mysqli_fetch_assoc($result);

          if ($chosen_eoi) {
            echo "<h1> Details for EOI number: " . htmlspecialchars($chosen_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "</h1>";
            echo "<div class='table-wrapper-2'>";
            echo "<table>";
            echo "<tr>";
            echo "<th> User ID </th>";
            if ($chosen_eoi['user_id'] === NULL) {
              echo "<td> Anonymous </td>";
            } else {
              echo "<td>" . htmlspecialchars($chosen_eoi['user_id'], ENT_QUOTES, 'UTF-8') . "</td>";
            }
            echo "<th> Postcode </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['postcode'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th> EOI number </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<th> Email </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['email'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th> Job Reference </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['job_reference'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<th> Phone number </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['phone_number'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th> First name </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['first_name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<th rowspan='3'> Skills </th>";
            echo "<td rowspan='3'>";
            $skills = explode(",", $chosen_eoi['skills']);
            foreach ($skills as $single_skills) {
              $single_skills = trim($single_skills);
              if ($single_skills !== "") {
                echo htmlspecialchars($single_skills, ENT_QUOTES, 'UTF-8');
                echo "<br>";
              }
            }
            echo "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th> Last name </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['last_name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th class='cell-3'> Date of birth </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['date_of_birth'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th> Gender </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['gender'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<th rowspan='3'> Other skills </th>";
            if ($chosen_eoi['other_skills'] === '') {
              echo "<td rowspan='3'> Not mentioned </td>";
            } else {
              echo "<td rowspan='3'>" . htmlspecialchars($chosen_eoi['other_skills'], ENT_QUOTES, 'UTF-8') . "</td>";
            }
            echo "</tr>";

            echo "<tr>";
            echo "<th> Street address </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['street_address'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th> Suburb </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['suburb'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<th> State </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['state'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<th> Status </th>";
            echo "<td>" . htmlspecialchars($chosen_eoi['status'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";

            echo "</table>";
            echo "</div>";

          } else {
            echo "<p class='no-eoi'> This EOI cannot be found. </p>";
          }
        } else {
          echo "<p class='failed-stmt'> Sorry, something went wrong. Please try again later. <p>";
        }
      }
    ?>
    </main>

<?php include 'footer.inc'; ?>

</body>
</html>