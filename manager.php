<?php 
  session_start();
  require_once "settings.php";
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  $sql_eoi = "SELECT user_id, eoi_number, first_name, last_name, job_reference, status FROM eoi";
  $all_eoi = mysqli_query($conn, $sql_eoi);

  $sql_jobs = "SELECT * FROM jobs";
  $all_jobs = mysqli_query($conn, $sql_jobs);

  $sql_new_eoi = "SELECT * FROM eoi WHERE status = 'NEW'";
  $new_eoi = mysqli_query($conn, $sql_new_eoi);
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
              echo "<h3> <span aria-hidden='true'> 📋 </span> Total EOIs </h3>";
              echo "<p> $eoi_count </p>";
            ?>
            </div>

            <div class="new">
            <?php
              $new_eoi_count = mysqli_num_rows($new_eoi);
              echo "<h3> <span aria-hidden='true'> 🆕 </span> New EOIs </h3>";
              echo "<p> $new_eoi_count </p>";
            ?>
            </div>

            <div class="available-positions">
            <?php
              $job_count = mysqli_num_rows($all_jobs);
              echo "<h3> <span aria-hidden='true'> 💼 </span> Available Positions </h3>";
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
            <option value="user_id"
            <?php
            if (isset($_GET['sort']) && $_GET['sort'] === 'user_id') {
              echo 'selected';
            }
            ?>> User ID
            </option>

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

      <div class="eoi-manage"> 
        <div class="choose-method">
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
        </div>

        <div class="choose-job-ref">
        <?php
        if ((isset($_GET['list_eoi']) && $_GET['list_eoi'] === 'job_reference')) {
          echo "<form action='manager.php' method='GET' class='choose-job-ref'>";
          echo "<input type='hidden' name='list_eoi' value='job_reference'>";
          $sort_value = htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8');
          echo "<input type='hidden' name='sort' value='$sort_value'>";

          echo "<label for='job_reference' class='eoi-list'> Choose Job Reference: </label>";
          echo "<select name='job_reference' id='job_reference'>";
          echo "<option value=''> Choose a job reference </option>";

          // Get job references from the jobs table
          $sql_job_reference = "SELECT job_reference FROM jobs";
          $single_job_ref = mysqli_query($conn, $sql_job_reference);

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
        </div>
      </div>

    <?php
    if (($_GET['list_eoi'] ?? '')=== 'all' && $all_eoi && mysqli_num_rows($all_eoi) > 0) {
      echo "<div class='table-wrapper'>";
      echo "<table>";
      echo "<tr>";
      echo "<th> User ID </th>";
      echo "<th> EOI number </th>";
      echo "<th> Full name </th>";
      echo "<th> Job Reference </th>";
      echo "<th> Status </th>";
      echo "<th> <span aria-hidden='true'> ✏️ </span> Action </th>";
      echo "</tr>";
      while ($single_eoi = mysqli_fetch_assoc($all_eoi)) {
        echo "<tr>";
        if ($single_eoi['user_id'] === NULL) {
          echo "<td> Anonymous </td>";
        } else {
          echo "<td>" . htmlspecialchars($single_eoi['user_id'], ENT_QUOTES, 'UTF-8') . "</td>";
        }
        echo "<td>" . htmlspecialchars($single_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($single_eoi['first_name'], ENT_QUOTES, 'UTF-8') . " " 
                    . htmlspecialchars($single_eoi['last_name'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($single_eoi['job_reference'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($single_eoi['status'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>";
        echo "<div class='eoi-action'>";
        echo "<form action='eoi_details.php' method='GET'>";
        echo "<input type='hidden' name='chosen_eoi_number' value='" . htmlspecialchars($single_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
        echo "<input type='submit' value='View this EOI'>";
        echo "</form>";
        echo "<form action='manager.php' method='GET'>";
        echo "<input type='submit' value='Change Status' class='change-status'>";
        echo "</form>";
        echo "<form action='manager.php' method='GET'>";
        echo "<input type='submit' value='Delete this EOI' class='delete-eoi'>";
        echo "</form>";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
      }
      echo "</table>";
      echo "</div>";
    } 

    if (isset($_GET['job_reference']) && $_GET['job_reference'] !== '') {
      $chosen_job_ref = $_GET['job_reference'];
      $sql_given_eoi = "SELECT user_id, eoi_number, first_name, last_name, job_reference, status FROM eoi
                        WHERE job_reference = ?";

      if ($stmt = $conn->prepare($sql_given_eoi)) {
        $stmt->bind_param("s", $chosen_job_ref);
        $stmt->execute();
        $given_eoi = $stmt->get_result();

        if ($given_eoi && mysqli_num_rows($given_eoi) > 0) {
          echo "<div class='table-wrapper'>";
          echo "<table>";
          echo "<tr>";
          echo "<th> User ID </th>";
          echo "<th> EOI number </th>";
          echo "<th> Full name </th>";
          echo "<th> Job Reference </th>";
          echo "<th> Status </th>";
          echo "<th> <span aria-hidden='true'> ✏️ </span> Action </th>";
          echo "</tr>";
          while ($single_given_eoi = mysqli_fetch_assoc($given_eoi)) {
            echo "<tr>";
            if ($single_given_eoi['user_id'] === NULL) {
              echo "<td> Anonymous </td>";
            } else {
              echo "<td>" . htmlspecialchars($single_given_eoi['user_id'], ENT_QUOTES, 'UTF-8') . "</td>";
            }
            echo "<td>" . htmlspecialchars($single_given_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($single_given_eoi['first_name'], ENT_QUOTES, 'UTF-8') . " " 
                        . htmlspecialchars($single_given_eoi['last_name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($single_given_eoi['job_reference'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($single_given_eoi['status'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>";
            echo "<div class='eoi-action'>";
            echo "<form action='eoi_details.php' method='GET'>";
            echo "<input type='hidden' name='chosen_eoi_number' value='" . htmlspecialchars($single_given_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
            echo "<input type='submit' value='View this EOI'>";
            echo "</form>";
            echo "<form action='manager.php' method='GET'>";
            echo "<input type='submit' value='Change Status' class='change-status'>";
            echo "</form>";
            echo "<form action='manager.php' method='GET'>";
            echo "<input type='submit' value='Delete this EOI' class='delete-eoi'>";
            echo "</form>";
            echo "</div>";
            echo "</td>";
            echo "</tr>";
          }
          echo "</table>";
          echo "</div>";
        }
      } else {
        echo "<p class='failed-stmt'> Sorry, something went wrong. Please try again later. <p>";
      }
    }

    if ((($_GET['list_eoi'] ?? '') === 'all' && $all_eoi && mysqli_num_rows($all_eoi) == 0) ||
       (isset($_GET['job_reference']) && $given_eoi && mysqli_num_rows($given_eoi) == 0)) {
      echo "<p class='no-eoi'> There is currently no EOI. Come back later, manager ! </p>";
    }
    ?>
    </main>

<?php include 'footer.inc'; ?>

</body>
</html>