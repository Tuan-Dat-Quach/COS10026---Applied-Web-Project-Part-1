<?php 
  session_start();
  require_once "settings.php";
  $connect = mysqli_connect($host, $user, $pwd, $sql_db);
  if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
  }
  $sql_1 = "SELECT * FROM eoi";
  $all_eoi = mysqli_query($connect, $sql_1);
  $sql_2 = "SELECT * FROM jobs";
  $all_jobs = mysqli_query($connect, $sql_2);
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
</head>

<body class="manager-page">

<?php include 'header.inc'; ?>

    <main>
        <h1> Manager Dashboard </h1>
        <h2> Overview </h2>
        <section class="statistic">
            <div class="total">
            <?php
              $eoi_count = mysqli_num_rows($all_eoi);
              echo "<h3> <span aria-hidden='true'> 📋 </span> Total EOIs <h3>";
              echo "<p> $eoi_count </p>";
            ?>
            </div>

            <div class="new">
            <?php
              $sql_3 = "SELECT * FROM eoi WHERE status = 'NEW'";
              $new_eoi = mysqli_query($connect, $sql_3);
              $new_eoi_count = mysqli_num_rows($new_eoi);
              echo "<h3> <span aria-hidden='true'> 🆕 </span> New EOIs <h3>";
              echo "<p> $new_eoi_count </p>";
            ?>
            </div>

            <div class="available-positions">
            <?php
              $job_count = mysqli_num_rows($all_jobs);
              echo "<h3> <span aria-hidden='true'> 💼 </span> Available Positions <h3>";
              echo "<p> $job_count </p>";
            ?>
            </div>
        </section>

        <h2> Manage </h2>
        
    <?php 
    ?>
    </main>

<?php include 'footer.inc'; ?>

</body>
</html>