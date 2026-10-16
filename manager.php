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

        <form action="manager.php" method="GET" class="sort-form">
          <input type="hidden" name="list_eoi" 
                 value="<?php echo htmlspecialchars($_GET['list_eoi'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
          <input type="hidden" name="job_reference" 
                 value="<?php echo htmlspecialchars($_GET['job_reference'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

          <label for="sort" class="eoi-list"> Sort by: </label>

          <select name="sort" id="sort">
            <option value="eoi_number"
            <?php
            if (isset($_GET['sort']) && $_GET['sort'] === 'eoi_number') {
              echo 'selected';
            }
            ?>> EOI number
            </option>

            <option value="first_name"
            <?php
            if (isset($_GET['sort']) && $_GET['sort'] === 'first_name') {
              echo 'selected';
            }
            ?>> First name
            </option>

            <option value="last_name"
            <?php
            if (isset($_GET['sort']) && $_GET['sort'] === 'last_name') {
              echo 'selected';
            }
            ?>> Last name
            </option>

            <option value="full_name"
            <?php
            if (isset($_GET['sort']) && $_GET['sort'] === 'full_name') {
              echo 'selected';
            }
            ?>> First name and Last name
            </option>

            <option value="status"
            <?php
            if (isset($_GET['sort']) && $_GET['sort'] === 'status') {
              echo 'selected';
            }
            ?>> Status
            </option>
          </select>

          <input type="submit" value="Sort">
        </form>

        <form action="manager.php" method="GET">
            <input type="hidden" name="sort"
                   value="<?php echo htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <label for="list_eoi" class="eoi-list"> List EOIs: </label>

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
        if ((isset($_GET['list_eoi']) && $_GET['list_eoi'] === 'job_reference')) {
          echo "<form action='manager.php' method='GET'>";
          echo "<input type='hidden' name='list_eoi' value='job_reference'>";
          $sort_value = htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8');
          echo "<input type='hidden' name='sort' value='$sort_value'>";

          echo "<label for='job_reference' class='eoi-list'> Choose Job Reference: </label>";
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
          echo "</form>";
        }
        ?>
    </main>

<?php include 'footer.inc'; ?>

</body>
</html>