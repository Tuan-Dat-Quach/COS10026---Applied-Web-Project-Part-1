
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// This is equal to session_unset()
$_SESSION = [];

session_destroy();

header('Location: login.php?logout=1');
exit;
?>
