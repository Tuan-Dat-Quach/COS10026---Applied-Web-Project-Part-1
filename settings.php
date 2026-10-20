
<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "greener_society";

$connect = mysqli_connect($host, $user, $password, $database);

if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($connect, "utf8mb4");
?>
