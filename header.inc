
<header class="navigation">

    <figure>
        <img id="company_logo"
             src="Images/Official_Company_Logo.png"
             alt="Greener Society's Company Logo">
    </figure>

    <?php include 'nav.inc'; ?>

</header>

<?php
if (isset($_GET['confirm_logout']) && !empty($_SESSION['user_id'])) {
  echo "<div class='logout-confirm' role='alert'>";
  echo "<span class='logout-text'> ⚠️ Are you sure you want to log out? </span>";

  echo "<div class='logout'>";

  // Cancel button: Reload the current page without the confirm_logout parameter

  echo "<form action='" . htmlspecialchars(basename($_SERVER['PHP_SELF']), ENT_QUOTES, 'UTF-8') . "' method='GET' class='logout-no'>";

  // Preserve the current sorting option
  if (isset($_GET['sort'])) {
    echo "<input type='hidden' name='sort' value='" . htmlspecialchars($_GET['sort'], ENT_QUOTES, 'UTF-8') . "'>";
  }

  // Preserve the EOI listing option
  if (isset($_GET['list_eoi'])) {
    echo "<input type='hidden' name='list_eoi' value='" . htmlspecialchars($_GET['list_eoi'], ENT_QUOTES, 'UTF-8') . "'>";
  }

  // Preserve the selected job reference
  if (isset($_GET['job_reference'])) {
    echo "<input type='hidden' name='job_reference' value='" . htmlspecialchars($_GET['job_reference'], ENT_QUOTES, 'UTF-8') . "'>";
  }
  echo "<button type='submit' class='confirm-no'> <i class='fa-solid fa-xmark' aria-hidden='true'></i> Cancel </button>";
  echo "</form>";

  // Confirm button: Go to logout.php

  echo "<form action='logout.php' method='GET' class='logout-yes'>";
  echo "<button type='submit' class='confirm-yes'> <i class='fa-solid fa-check' aria-hidden='true'></i> Yes, log out </button>";
  echo "</form>";
  echo "</div>";
  echo "</div>";
}
?>