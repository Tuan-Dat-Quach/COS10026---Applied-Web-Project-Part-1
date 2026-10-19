<?php 
  session_start();
  require_once "settings.php";

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $deleted_eoi = (int)($_POST['eoi_number'] ?? 0);
    // Delete an EOI according to its EOI number
    if ($deleted_eoi > 0) {
      $stmt = $conn->prepare("DELETE FROM eoi WHERE eoi_number = ?");
      $stmt->bind_param("i", $deleted_eoi);
      $stmt->execute();
      $stmt->close();
    }
    /* Use urlencode to encode the parameters so they can be appropriate URL, and use the
    URL to pass the parameters so that the page can maintain current state after 
    deleting an EOI */
    $turn_back_1 = "manager.php?list_eoi=" . urlencode($_POST['list_eoi'] ?? '')
                 . "&sort=" . urlencode($_POST['sort'] ?? '')
                 . "&job_reference=" . urlencode($_POST['job_reference'] ?? '');
    // Return back to the table head
    header("Location: " . $turn_back_1 . "#eoi-table");
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'change_status') {
    $changed_eoi = (int)($_POST['eoi_number'] ?? 0);
    $new_status = $_POST['new_status'] ?? '';
  // Update an EOI's status according to its EOI number
  if ($changed_eoi > 0 && ($new_status === 'NEW' || $new_status === 'CURRENT' || $new_status === 'FINAL')) {
    $stmt = $conn->prepare("UPDATE eoi SET status = ? WHERE eoi_number = ?");
    $stmt->bind_param("si", $new_status, $changed_eoi);
    $stmt->execute();
    $stmt->close();
  }

    $turn_back_2 = "manager.php?list_eoi=" . urlencode($_POST['list_eoi'] ?? '')
                 . "&sort=" . urlencode($_POST['sort'] ?? '')
                 . "&job_reference=" . urlencode($_POST['job_reference'] ?? '');
    // Return back to the chosen EOI
    header("Location: " . $turn_back_2 . "#eoi-" . $changed_eoi);
    exit;
  }

  // Associative array to prevent SQL injection
  $sort_methods = [
    'user_id'       => 'user_id',
    'eoi_number'    => 'eoi_number',
    'first_name'    => 'first_name',
    'last_name'     => 'last_name',
    'full_name'     => 'first_name, last_name',
    'job_reference' => 'job_reference',
    'status'        => 'status'
  ];

  $sort_key = $_GET['sort'] ?? '';
  // Sort method is EOI number by default 
  $order_by = $sort_methods[$sort_key] ?? 'eoi_number';

  $sql_eoi = "SELECT user_id, eoi_number, first_name, last_name, job_reference, status FROM eoi ORDER BY $order_by";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
            <option value="eoi_number"
            <?php
            if (isset($_GET['sort']) && $_GET['sort'] === 'eoi_number') {
              echo 'selected';
            }
            ?>> EOI number
            </option>

            <option value="user_id"
            <?php
            if (isset($_GET['sort']) && $_GET['sort'] === 'user_id') {
              echo 'selected';
            }
            ?>> User ID
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

            <option value="job_reference"
            <?php
            if (isset($_GET['sort']) && $_GET['sort'] === 'job_reference') {
              echo 'selected';
            }
            ?>> Job Reference
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
    // Option to list all EOIs
    if (($_GET['list_eoi'] ?? '')=== 'all' && $all_eoi && mysqli_num_rows($all_eoi) > 0) {
      echo "<div class='table-wrapper' id='eoi-table'>";
      echo "<table>";
      echo "<tr>";
      echo "<th class='cell'> User ID </th>";
      echo "<th class='cell'> EOI number </th>";
      echo "<th class='cell'> Full name </th>";
      echo "<th class='cell'> Job Reference </th>";
      echo "<th class='cell'> Status </th>";
      echo "<th class='cell'> <span aria-hidden='true'> ✏️ </span> Action </th>";
      echo "</tr>";
      while ($single_eoi = mysqli_fetch_assoc($all_eoi)) {
        echo "<tr id='eoi-" . htmlspecialchars($single_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
        if ($single_eoi['user_id'] === NULL) {
          echo "<td> Anonymous </td>";
        } else {
          echo "<td>" . htmlspecialchars($single_eoi['user_id'], ENT_QUOTES, 'UTF-8') . "</td>";
        }
        echo "<td>" . htmlspecialchars($single_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($single_eoi['first_name'], ENT_QUOTES, 'UTF-8') . " " 
                    . htmlspecialchars($single_eoi['last_name'], ENT_QUOTES, 'UTF-8') . "</td>";
        echo "<td>" . htmlspecialchars($single_eoi['job_reference'], ENT_QUOTES, 'UTF-8') . "</td>";
        $status_class_1 = '';
        if ($single_eoi['status'] === 'NEW') {
          $status_class_1 = 'status-new';
        } elseif ($single_eoi['status'] === 'CURRENT') {
          $status_class_1 = 'status-current';
        } else {
          $status_class_1 = 'status-final';
        }
        echo "<td><span class='status $status_class_1'>" . htmlspecialchars($single_eoi['status'], ENT_QUOTES, 'UTF-8') . "</td>";
        // Action column
        echo "<td>";
        echo "<div class='eoi-action'>";
        // Button to view one EOI
        echo "<form action='eoi_details.php' method='GET' class='view-eoi'>";
        echo "<input type='hidden' name='chosen_eoi_number' value='" . htmlspecialchars($single_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
        echo "<button type='submit'> <i class='fa-solid fa-eye' aria-hidden='true'> </i> View </button>";
        echo "</form>";
        // Button to change status of an EOI
        echo "<form action='manager.php#eoi-" . htmlspecialchars($single_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "' method='GET' class='change-status'>";
        echo "<input type='hidden' name='list_eoi' value='" . htmlspecialchars($_GET['list_eoi'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
        echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
        echo "<input type='hidden' name='job_reference' value='" . htmlspecialchars($_GET['job_reference'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
        echo "<input type='hidden' name='confirm_status' value='" . htmlspecialchars($single_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
        echo "<button type='submit'> <i class='fa-solid fa-pen-to-square' aria-hidden='true'> </i> Change Status </button>";
        echo "</form>";
        // Button to delete an EOI, using anchor to maintain the current place
        echo "<form action='manager.php#eoi-" . htmlspecialchars($single_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "' method='GET' class='delete-eoi'>";
        echo "<input type='hidden' name='list_eoi' value='" . htmlspecialchars($_GET['list_eoi'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
        echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
        echo "<input type='hidden' name='job_reference' value='" . htmlspecialchars($_GET['job_reference'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
        echo "<input type='hidden' name='confirm_delete' value='" . (int)$single_eoi['eoi_number'] . "'>";
        echo "<button type='submit'> <i class='fa-solid fa-trash' aria-hidden='true'> </i> Delete this EOI </button>";
        echo "</form>";
        echo "</div>";

        if (($_GET['confirm_delete'] ?? '') === (string)$single_eoi['eoi_number']) {
          echo "<p> Delete EOI number " . htmlspecialchars($single_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "? This action cannot be undone. </p>";
          echo "<div class='confirm-box'>";
          // Cancel deleting button
          echo "<form action='manager.php#eoi-" . htmlspecialchars($single_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "' method='GET' class='confirm-no'>";
          echo "<input type='hidden' name='list_eoi' value='" . htmlspecialchars($_GET['list_eoi'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
          echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
          echo "<input type='hidden' name='job_reference' value='" . htmlspecialchars($_GET['job_reference'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
          echo "<button type='submit'> <i class='fa-solid fa-xmark' aria-hidden='true'> </i> Cancel </button>";
          echo "</form>";
          // Confirm deleting button
          echo "<form action='manager.php' method='POST' class='confirm-yes'>";
          echo "<input type='hidden' name='action' value='delete'>";
          echo "<input type='hidden' name='eoi_number' value='" . htmlspecialchars($single_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
          echo "<input type='hidden' name='list_eoi' value='" . htmlspecialchars($_GET['list_eoi'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
          echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
          echo "<input type='hidden' name='job_reference' value='" . htmlspecialchars($_GET['job_reference'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
          echo "<button type='submit'> <i class='fa-solid fa-check' aria-hidden='true'> </i> Yes, delete it </button>";
          echo "</form>";
         
          echo "</div>";
        }

        // Display other status than current status for users to choose from, using foreach to compare
        if (($_GET['confirm_status'] ?? '') === (string)$single_eoi['eoi_number']) {
          echo "<p> Change to which status? </p>";
          echo "<div class='confirm-box'>";
          foreach (['NEW', 'CURRENT', 'FINAL'] as $status_option) {
            if ($status_option !== $single_eoi['status']) {
              echo "<form action='manager.php' method='POST' class='status-choice'>";
              echo "<input type='hidden' name='action' value='change_status'>";
              echo "<input type='hidden' name='new_status' value='$status_option'>";
              echo "<input type='hidden' name='eoi_number' value='" . htmlspecialchars($single_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
              echo "<input type='hidden' name='list_eoi' value='" . htmlspecialchars($_GET['list_eoi'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
              echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
              echo "<input type='hidden' name='job_reference' value='" . htmlspecialchars($_GET['job_reference'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
              echo "<button type='submit'> $status_option </button>";
              echo "</form>";
            }
          }
          // Cancel change button
          echo "<form action='manager.php#eoi-" . htmlspecialchars($single_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "' method='GET' class='confirm-no'>";
          echo "<input type='hidden' name='list_eoi' value='" . htmlspecialchars($_GET['list_eoi'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
          echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
          echo "<input type='hidden' name='job_reference' value='" . htmlspecialchars($_GET['job_reference'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
          echo "<button type='submit'> <i class='fa-solid fa-xmark' aria-hidden='true'> </i> Cancel </button>";
          echo "</form>";

          echo "</div>";
        }
        echo "</td>";
        echo "</tr>";
      }
      echo "</table>";
      echo "</div>";
    } 

    $given_eoi = null;
    // Option to list all EOIs by a given job reference
    if (($_GET['list_eoi'] ?? '') === 'job_reference' && isset($_GET['job_reference']) && $_GET['job_reference'] !== '') {
      $chosen_job_ref = $_GET['job_reference'];
      $sql_given_eoi = "SELECT user_id, eoi_number, first_name, last_name, job_reference, status FROM eoi
                        WHERE job_reference = ? ORDER BY $order_by";

      if ($stmt = $conn->prepare($sql_given_eoi)) {
        $stmt->bind_param("s", $chosen_job_ref);
        $stmt->execute();
        $given_eoi = $stmt->get_result();

        if ($given_eoi && mysqli_num_rows($given_eoi) > 0) {
          echo "<div class='table-wrapper' id='eoi-table'>";
          echo "<table>";
          echo "<tr>";
          echo "<th class='cell'> User ID </th>";
          echo "<th class='cell'> EOI number </th>";
          echo "<th class='cell'> Full name </th>";
          echo "<th class='cell'> Job Reference </th>";
          echo "<th class='cell'> Status </th>";
          echo "<th class='cell'> <span aria-hidden='true'> ✏️ </span> Action </th>";
          echo "</tr>";
          while ($single_given_eoi = mysqli_fetch_assoc($given_eoi)) {
            echo "<tr id='eoi-" . htmlspecialchars($single_given_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
            if ($single_given_eoi['user_id'] === NULL) {
              echo "<td> Anonymous </td>";
            } else {
              echo "<td>" . htmlspecialchars($single_given_eoi['user_id'], ENT_QUOTES, 'UTF-8') . "</td>";
            }
            echo "<td>" . htmlspecialchars($single_given_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($single_given_eoi['first_name'], ENT_QUOTES, 'UTF-8') . " " 
                        . htmlspecialchars($single_given_eoi['last_name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($single_given_eoi['job_reference'], ENT_QUOTES, 'UTF-8') . "</td>";
            $status_class_2 = '';
            if ($single_given_eoi['status'] === 'NEW') {
              $status_class_2 = 'status-new';
            } elseif ($single_given_eoi['status'] === 'CURRENT') {
              $status_class_2 = 'status-current';
            } else {
              $status_class_2 = 'status-final';
            }
            echo "<td><span class='status $status_class_2'>" . htmlspecialchars($single_given_eoi['status'], ENT_QUOTES, 'UTF-8') . "</td>";
            // Action column
            echo "<td>";
            echo "<div class='eoi-action'>";
            // Button to view one EOI
            echo "<form action='eoi_details.php' method='GET' class='view-eoi'>";
            echo "<input type='hidden' name='chosen_eoi_number' value='" . htmlspecialchars($single_given_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
            echo "<button type='submit'> <i class='fa-solid fa-eye' aria-hidden='true'> </i> View </button>";
            echo "</form>";
            // Button to change status of an EOI
            echo "<form action='manager.php#eoi-" . htmlspecialchars($single_given_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "' method='GET' class='change-status'>";
            echo "<input type='hidden' name='list_eoi' value='" . htmlspecialchars($_GET['list_eoi'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
            echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
            echo "<input type='hidden' name='job_reference' value='" . htmlspecialchars($_GET['job_reference'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
            echo "<input type='hidden' name='confirm_status' value='" . htmlspecialchars($single_given_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
            echo "<button type='submit'> <i class='fa-solid fa-pen-to-square' aria-hidden='true'> </i> Change Status </button>";
            echo "</form>";
            // Button to delete an EOI
            echo "<form action='manager.php#eoi-" . htmlspecialchars($single_given_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "' method='GET' class='delete-eoi'>";
            echo "<input type='hidden' name='list_eoi' value='" . htmlspecialchars($_GET['list_eoi'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
            echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
            echo "<input type='hidden' name='job_reference' value='" . htmlspecialchars($_GET['job_reference'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
            echo "<input type='hidden' name='confirm_delete' value='" . (int)$single_given_eoi['eoi_number'] . "'>";
            echo "<button type='submit'> <i class='fa-solid fa-trash' aria-hidden='true'> </i> Delete this EOI </button>";
            echo "</form>";
            echo "</div>";

            if (($_GET['confirm_delete'] ?? '') === (string)$single_given_eoi['eoi_number']) {
              echo "<p> Delete EOI number " . htmlspecialchars($single_given_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "? This action cannot be undone. </p>";
              echo "<div class='confirm-box'>";
              // Cancel deleting button
              echo "<form action='manager.php#eoi-" . htmlspecialchars($single_given_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "' method='GET' class='confirm-no'>";
              echo "<input type='hidden' name='list_eoi' value='" . htmlspecialchars($_GET['list_eoi'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
              echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
              echo "<input type='hidden' name='job_reference' value='" . htmlspecialchars($_GET['job_reference'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
              echo "<button type='submit'> <i class='fa-solid fa-xmark' aria-hidden='true'> </i> Cancel </button>";
              echo "</form>";
              // Confirm deleting button
              echo "<form action='manager.php' method='POST' class='confirm-yes'>";
              echo "<input type='hidden' name='action' value='delete'>";
              echo "<input type='hidden' name='eoi_number' value='" . htmlspecialchars($single_given_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
              echo "<input type='hidden' name='list_eoi' value='" . htmlspecialchars($_GET['list_eoi'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
              echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
              echo "<input type='hidden' name='job_reference' value='" . htmlspecialchars($_GET['job_reference'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
              echo "<button type='submit'> <i class='fa-solid fa-check' aria-hidden='true'> </i> Yes, delete it </button>";
              echo "</form>";
         
              echo "</div>";
            }

            // Display other status than current status for users to choose from, using foreach to compare
            if (($_GET['confirm_status'] ?? '') === (string)$single_given_eoi['eoi_number']) {
              echo "<p> Change to which status? </p>";
              echo "<div class='confirm-box'>";
              foreach (['NEW', 'CURRENT', 'FINAL'] as $status_option) {
                if ($status_option !== $single_given_eoi['status']) {
                  echo "<form action='manager.php' method='POST' class='status-choice'>";
                  echo "<input type='hidden' name='action' value='change_status'>";
                  echo "<input type='hidden' name='new_status' value='$status_option'>";
                  echo "<input type='hidden' name='eoi_number' value='" . htmlspecialchars($single_given_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
                  echo "<input type='hidden' name='list_eoi' value='" . htmlspecialchars($_GET['list_eoi'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
                  echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
                  echo "<input type='hidden' name='job_reference' value='" . htmlspecialchars($_GET['job_reference'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
                  echo "<button type='submit'> $status_option </button>";
                  echo "</form>";
                }
              }
              // Cancel change button
              echo "<form action='manager.php#eoi-" . htmlspecialchars($single_given_eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "' method='GET' class='confirm-no'>";
              echo "<input type='hidden' name='list_eoi' value='" . htmlspecialchars($_GET['list_eoi'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
              echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
              echo "<input type='hidden' name='job_reference' value='" . htmlspecialchars($_GET['job_reference'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
              echo "<button type='submit'> <i class='fa-solid fa-xmark' aria-hidden='true'> </i> Cancel </button>";
              echo "</form>";

              echo "</div>";
            }
            echo "</td>";
            echo "</tr>";
          }
          echo "</table>";
          echo "</div>";
        }
      } else {
        echo "<p class='failed-stmt'> Sorry, something went wrong. Please try again later. </p>";
      }
    }

    if ((($_GET['list_eoi'] ?? '') === 'all' && $all_eoi && mysqli_num_rows($all_eoi) == 0) ||
       (($_GET['list_eoi'] ?? '') ==='job_reference' && $given_eoi && mysqli_num_rows($given_eoi) == 0)) {
      echo "<p class='no-eoi'> There is currently no EOI. Come back later, manager ! </p>";
    }
    ?>
    </main>

<?php include 'footer.inc'; ?>

</body>
</html>