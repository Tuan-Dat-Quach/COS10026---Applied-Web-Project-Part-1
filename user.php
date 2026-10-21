<?php
  session_start();
  require_once "settings.php";

  // Validate so that only logged-in users can see this page
  if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'User') {
    header("Location: login.php");
    exit;
  }
  
  $user_id = (int)$_SESSION['user_id'];
  $username = $_SESSION['username'] ?? '';
  $user_role = $_SESSION['role'] ?? '';

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'withdraw') {
    $withdrawn_eoi = (int)($_POST['eoi_number'] ?? 0);
    // Delete an EOI according to its EOI number
    if ($withdrawn_eoi > 0) {
      $stmt = $conn->prepare("DELETE FROM eoi WHERE eoi_number = ? AND user_id = ? AND status IN ('NEW', 'CURRENT')");
      $stmt->bind_param("ii", $withdrawn_eoi, $user_id);
      $stmt->execute();
      $stmt->close();
    }
    /* Use urlencode to encode the parameters so they can be appropriate URL, and use the
    URL to pass the parameters so that the page can maintain current state after 
    withdrawing an EOI */
    $turn_back = "user.php?sort=" . urlencode($_POST['sort'] ?? '');
                
    // Return back to the table head
    header("Location: " . $turn_back . "#eoi-table");
    exit;
  }

  // Count this user's EOIs by status
  $total_eoi = 0;
  $new_eoi = 0;
  $current_eoi = 0;
  $final_eoi = 0;

  $stmt = $conn->prepare("SELECT status, COUNT(*) AS total FROM eoi WHERE user_id = ? GROUP BY status");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();

  while ($row = mysqli_fetch_assoc($result)) {
    $total_eoi += $row['total'];
    if ($row['status'] === 'NEW') {
      $new_eoi = $row['total'];
    } elseif ($row['status'] === 'CURRENT') {
      $current_eoi = $row['total'];
    } elseif ($row['status'] === 'FINAL') {
      $final_eoi = $row['total'];
    }
  }

  // Get user's latest EOI, sort it by EOI number, order the sorted from top to bottm, then take only the first row
  $latest_eoi = null;
  $stmt = $conn->prepare("SELECT eoi_number, job_reference, status FROM eoi WHERE user_id = ? ORDER BY eoi_number DESC LIMIT 1");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $latest_result = $stmt->get_result();
  $latest_eoi = mysqli_fetch_assoc($latest_result);
  $stmt->close();

  // Associative array to prevent SQL injection
  $sort_methods = [
    'eoi_number'    => 'eoi_number',
    'job_reference' => 'job_reference',
    'status'        => 'status'
  ];

  $sort_key = $_GET['sort'] ?? '';
  // Sort method is EOI number by default 
  $order_by = $sort_methods[$sort_key] ?? 'eoi_number';

  $stmt = $conn->prepare("SELECT eoi_number, job_reference, status FROM eoi WHERE user_id = ? ORDER BY $order_by");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $my_eois = $stmt->get_result();
  $stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Greener Society position description page featuring current environmental conservation employment opportunities.">
    <meta name="keywords" content="Greener Society, environmental jobs, conservation jobs, recruitment, sustainability">
    <meta name="author" content="TechTide Group">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Greener Society - Position Descriptions </title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="manager-page">

<?php include 'header.inc'; ?>

    <main>
        <h1> My Dashboard </h1>

        <!-- A Profile box including username, user ID, account type and latest EOI -->
        <h2> My Profile </h2>
        <section class="user-profile">
            <div class="profile-avatar" aria-hidden="true">
                <i class="fa-solid fa-circle-user"></i>
            </div>
            <dl class="profile-info">
              <?php
                // Using description list here, and later add flexbox display in CSS
                echo "<div>";
                echo "<dt> Username </dt>";
                echo "<dd>" . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . "</dd>";
                echo "</div>";
                echo "<div>";
                echo "<dt> User ID </dt>"; 
                echo "<dd>" . htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8') . "</dd>";
                echo "</div>";
                echo "<div>";
                echo "<dt> Account type </dt>";
                echo "<dd>" . htmlspecialchars($user_role, ENT_QUOTES, 'UTF-8') . "</dd>" ;
                echo "</div>";
                // Display user's latest EOI with its EOI number, Job Reference and current status
                if ($latest_eoi) {
                  $latest_class = 'status-final';
                  if ($latest_eoi['status'] === 'NEW') {
                    $latest_class = 'status-new';
                  } elseif ($latest_eoi['status'] === 'CURRENT') {
                    $latest_class = 'status-current';
                  }
                  echo "<div>";
                  echo "<dt> Latest EOI </dt>";
                  // Join the information of latest EOI
                  echo "<dd> #" . htmlspecialchars($latest_eoi['eoi_number'], ENT_QUOTES, 'UTF-8')
                       . " - " . htmlspecialchars($latest_eoi['job_reference'], ENT_QUOTES, 'UTF-8')
                       . " - " . "<span class='status $latest_class'>" . htmlspecialchars($latest_eoi['status'], ENT_QUOTES, 'UTF-8') 
                       . "</span> </dd>";
                  echo "</div>";
                } else {
                  echo "<div>";
                  echo "<dt> Latest EOI </dt>";
                  echo "<dd> No EOI yet </dd>";
                  echo "</div>";
                }
              ?>
            </dl>
        </section>

        <!-- An overview with some statistics: Total EOIs, New EOIs and Available job positions -->
        <h2> Overview </h2>
        <section class="user-statistic">
            <div class="user-total-eoi">
            <?php
              echo "<h3> <span aria-hidden='true'> 📋 </span> Total EOIs </h3>";
              echo "<p> $total_eoi </p>";
            ?>
            </div>

            <div class="user-new">
            <?php
              echo "<h3> <span aria-hidden='true'> 🆕 </span> New EOIs </h3>";
              echo "<p> $new_eoi </p>";
            ?>
            </div>

            <div class="user-current">
            <?php
              echo "<h3> <span aria-hidden='true'> 🔄 </span> Current EOIs </h3>" ;
              echo "<p> $current_eoi </p>";
            ?>
            </div>

            <div class="user-final">
            <?php
              echo "<h3> <span aria-hidden='true'> ✅ </span> Final EOIs </h3>";
              echo "<p> $final_eoi </p>";
            ?>
            </div>
        </section>

        <h2>My Submitted EOIs</h2>
        <!-- Sort field options allowed for the manager, with hidden inputs of list_eoi and job_reference -->
        <form action="user.php#sort" method="GET" class="sort-form">
          <label for="sort" class="eoi-list"> Sort by: </label>

          <select name="sort" id="sort">
            <!-- Sort by EOI number - Default method -->
            <option value="eoi_number"
            <?php
            if (isset($_GET['sort']) && $_GET['sort'] === 'eoi_number') {
              echo 'selected';
            }
            ?>> EOI number
            </option>
            <!-- Sort by job reference number -->
            <option value="job_reference"
            <?php
            if (isset($_GET['sort']) && $_GET['sort'] === 'job_reference') {
              echo 'selected';
            }
            ?>> Job Reference
            </option>
            <!-- Sort by EOI status -->
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

        <?php
          if ($my_eois && mysqli_num_rows($my_eois) > 0) {
            echo "<div class='table-wrapper' id='eoi-table'>";
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th class='cell'> EOI Number </th>";
            echo "<th class='cell'> Job Reference </th>";
            echo "<th class='cell'> Status </th>";
            echo "<th class='cell'> <span aria-hidden='true'> ✏️ </span> Action </th>";
            echo "</tr>";
            echo "</thead>";

            echo "<tbody>";
            while ($eoi = mysqli_fetch_assoc($my_eois)) {
              // Set the CSS class according to the EOI status
              if ($eoi['status'] == 'NEW') {
                $status_class = 'status-new';
              } elseif ($eoi['status'] == 'CURRENT') {
                $status_class = 'status-current';
              } else {
                $status_class = 'status-final';
              }

              echo "<tr id='eoi-" . htmlspecialchars($eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
              echo "<td>" . htmlspecialchars($eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "</td>";
              echo "<td>" . htmlspecialchars($eoi['job_reference'], ENT_QUOTES, 'UTF-8') . "</td>";
              echo "<td> <span class='status $status_class'>" . htmlspecialchars($eoi['status'], ENT_QUOTES, 'UTF-8') . "</span> </td>";
              echo "<td>";
              echo "<div class='eoi-action'>";
              // View details of the EOI
              echo "<form action='eoi_details.php' method='GET' class='view-eoi'>";
              echo "<input type='hidden' name='chosen_eoi_number' value='" . htmlspecialchars($eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
              echo "<button type='submit'> <i class='fa-solid fa-eye' aria-hidden='true'> </i> View </button>";
              echo "</form>";
              // Option to withdraw EOI if the current status is NEW or CURRENT
              if ($eoi['status'] == 'NEW' || $eoi['status'] == 'CURRENT') {
                echo "<form action='user.php#eoi-" . htmlspecialchars($eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "' method='GET' class='withdraw-eoi'>";
                echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
                echo "<input type='hidden' name='confirm-withdraw' value='" . (int)$eoi['eoi_number'] . "'>";
                echo "<button type='submit'> <i class='fa-solid fa-rotate-left' aria-hidden='true'> </i> Withdraw </button>";
                echo "</form>";
              // Disable the option to withdraw EOI if the current status is FINAL
              } else {
                echo "<button type='button' class='withdraw-disabled' disabled>";
                echo "<i class='fa-solid fa-lock' aria-hidden='true'> </i> Withdraw";
                echo "</button>";
              }
              echo "</div>"; 

              // Confirm if the user wants to withdraw the chosen EOI
              if (($_GET['confirm-withdraw'] ?? '') === (string)$eoi['eoi_number']) {
                echo "<p> ⚠️  Withdraw EOI number " . htmlspecialchars($eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "? This action cannot be undone. </p>";
                echo "<div class='confirm-box'>";
                // Cancel withdrawing button
                echo "<form action='user.php#eoi-" . htmlspecialchars($eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "' method='GET' class='confirm-no'>";
                echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
                echo "<button type='submit'> <i class='fa-solid fa-xmark' aria-hidden='true'> </i> Cancel </button>";
                echo "</form>";
                // Confirm withdrawing button
                echo "<form action='user.php' method='POST' class='confirm-yes'>";
                echo "<input type='hidden' name='action' value='withdraw'>";
                echo "<input type='hidden' name='eoi_number' value='" . htmlspecialchars($eoi['eoi_number'], ENT_QUOTES, 'UTF-8') . "'>";
                echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
                echo "<button type='submit'> <i class='fa-solid fa-check' aria-hidden='true'> </i> Yes, withdraw it </button>";
                echo "</form>";
                echo "</div>";
              }
              echo "</td>";
              echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
          } else {
            echo "<p class='no-eoi'>You have not submitted any EOIs yet.</p>";
          }
          mysqli_close($conn);
        ?>
    </main>

<?php include 'footer.inc'; ?>

</body>
</html>