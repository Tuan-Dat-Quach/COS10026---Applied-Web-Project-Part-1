<?php
  session_start();
  require_once "settings.php";

  // Validate so that only logged-in users can see this page
  if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'user') {
    header("Location: login.php");
    exit;
  }

  $user_id = (int)$_SESSION['user_id'];
  $username = $_SESSION['username'] ?? '';
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

    </main>

<?php include 'footer.inc'; ?>

</body>
</html>