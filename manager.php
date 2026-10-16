<?php 
  session_start();
  require_once "settings.php";
  $connect = mysqli_connect($host, $user, $pwd, $sql_db);
  if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
  }
  $sql_eoi = "SELECT * FROM eoi";
  $all_eoi = mysqli_query($connect, $sql_eoi);
  $sql_jobs = "SELECT * FROM jobs";
  $all_jobs = mysqli_query($connect, $sql_jobs);
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
              $sql_new_eoi = "SELECT * FROM eoi WHERE status = 'NEW'";
              $new_eoi = mysqli_query($connect, $sql_new_eoi);
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
        <form action="manager.php" method="GET">
            <label for="list_eoi"> List EOIs: </label>

            <select name="list_eoi" id="list_eoi">
              <option value=""> Choose how to list EOIs: </option>
              <option value="all"
              <?php
              if (isset($_GET['list_eoi']) && $_GET['list_eoi'] === 'all') {
                echo 'selected';
              }
              ?>> List all EOIs 
              </option>

              <option value="job_reference"
              <?php
              if (isset($_GET['list_eoi']) && $_GET['list_eoi'] === 'job_reference') {
                echo 'selected';
              }
              ?>> List EOIs by job reference
              </option>
            </select>
           
            <input type="submit" value="Go">
        </form>

        <?php
        if ((isset($_GET['list_eoi']) && $_GET['list_eoi'] === 'job_reference') || (isset($_GET['job_reference']))) {
          echo "<form action='manager.php' method='GET'>";
          echo "<input type='hidden' name='list_eoi' value='job_reference'>";
          echo "<label for='job_reference'> Choose Job Reference: </label>";
          echo "<select name='job_reference' id='job_reference'>";
          echo "<option value=''> Choose a job reference </option>";

          // Get job references from the jobs table
          $sql_job_reference = "SELECT job_reference FROM jobs";
          $single_job_ref = mysqli_query($connect, $sql_job_reference);

          if ($single_job_ref) {
            while ($row = mysqli_fetch_assoc($single_job_ref)) {
              $reference_option = htmlspecialchars($row['job_reference'], ENT_QUOTES, 'UTF-8');
              $selected_job_ref = '';
              if (isset($_GET['job_reference']) && $_GET['job_reference'] === $row['job_reference']) {
                $selected_job_ref = 'selected';
              }
              echo "<option value='$reference_option' $selected_job_ref>";
              echo "$reference_option</option>";
            }
          }
          echo "</select>";
          echo "<input type='submit' value='Go'>";
        }
        ?>
    </main>

<?php include 'footer.inc'; ?>

</body>
</html>