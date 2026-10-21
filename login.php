
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'settings.php';

$message = '';
$messageType = '';

if (isset($_GET['logout'])) {
    $message = '✅ You have logged out successfully.';
    $messageType = 'success';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $message = 'Please enter your username and password.';
        $messageType = 'error';
    } else {
        $sql = "SELECT user_id, username, password, role
                FROM users
                WHERE username = ?";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                $account = mysqli_fetch_assoc($result);

                if ($account &&
                    password_verify($password, $account['password'])) {

                    session_regenerate_id(true);

                    $_SESSION['user_id'] = $account['user_id'];
                    $_SESSION['username'] = $account['username'];
                    $_SESSION['role'] = $account['role'];

                } else {
                    $message = 'Incorrect username or password.';
                    $messageType = 'error';
                }
            } else {
                $message = 'Login failed. Please try again.';
                $messageType = 'error';
            }

            mysqli_stmt_close($stmt);
        } else {
            $message = 'Unable to process login at the moment.';
            $messageType = 'error';
        }
    }
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
    <title> Greener Society - Position Descriptions </title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="login-page">

<?php include 'header.inc'; ?>

  <main class="login-container">
    <h1>Login</h1>

    <?php if ($message !== ''): ?>
        <p class="login-message <?= htmlspecialchars($messageType) ?>">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <?php if (empty($_SESSION['user_id'])): ?>

        <form action="login.php" method="post">
          <div class="signup-row">
            <label for="username">Username:</label>
            <input
                type="text"
                id="username"
                name="username"
                maxlength="50"
                autocomplete="username"
                required
            >
          </div>

          <div class="signup-row">
            <label for="password">Password:</label>
            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
            >
          </div>

            <button type="submit">Login</button>
        </form>

        <p class="login-note"> Don't have an account?
            <a href="signup.php">Sign up here</a>
        </p>

    <?php else: ?>

        <p class="login-note"> <span aria-hidden='true'> ✅ </span> You have successfully logged in as
            <?= htmlspecialchars($_SESSION['username']) ?>.
        </p>

        <?php if ($_SESSION['role'] === 'Manager'): ?>
            <p class="login-note"><a href="manager.php">Go to Manager Page</a></p>
        <?php else: ?>
            <p class="login-note"><a href="user.php">Go to User Page</a></p>
        <?php endif; ?>

        <p class="login-note"><a href="logout.php">Logout</a></p>

    <?php endif; ?>

    <?php mysqli_close($conn); ?>
  </main>

<?php include 'footer.inc'; ?>

</body>
</html>
