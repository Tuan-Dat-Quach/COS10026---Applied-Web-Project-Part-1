
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

  echo "<form action='$saved_url' method='GET' class='logout-no'>";
  echo "<button type='submit'> <i class='fa-solid fa-xmark' aria-hidden='true'></i> Cancel </button>";
  echo "</form>";

  // Confirm button: Go to logout.php

  echo "<form action='logout.php' method='GET' class='logout-yes'>";
  echo "<button type='submit'> <i class='fa-solid fa-check' aria-hidden='true'></i> Yes, log out </button>";
  echo "</form>";
  echo "</div>";
  echo "</div>";
}
?>