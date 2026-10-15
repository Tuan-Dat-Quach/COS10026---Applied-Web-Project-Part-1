<?php 
  session_start();
  require_once "settings.php";
  $connect = mysqli_connect($host, $user, $pwd, $sql_db);
  if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
  }
  if (!isset($_SESSION['username'])) {
    header("Location: login.php");
  exit();
}
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

<body class="jobs-page">

<?php include 'header.inc'; ?>

    <main>
    <?php 
    ?>
    </main>

<?php include 'footer.inc'; ?>

</body>
</html>