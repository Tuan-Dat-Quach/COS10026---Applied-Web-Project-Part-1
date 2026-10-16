
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'settings.php';

$message = '';
$messageType = '';

if (isset($_GET['logout'])) {
    $message = 'You have logged out successfully.';
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
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $account = mysqli_fetch_assoc($result);

        if ($account &&
            password_verify($password, $account['password'])) {

            session_regenerate_id(true);

            $_SESSION['user_id'] = $account['user_id'];
            $_SESSION['username'] = $account['username'];
            $_SESSION['role'] = $account['role'];

            $message = 'Login successful! Welcome, '
                     . $account['username'] . '.';
            $messageType = 'success';
        } else {
            $message = 'Incorrect username or password.';
            $messageType = 'error';
        }

        mysqli_stmt_close($stmt);
    }
}

include 'header.inc';
?>

<main class="login-container">
    <h1>Login</h1>

    <?php if ($message !== ''): ?>
        <p class="login-message <?= htmlspecialchars($messageType) ?>">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <?php if (empty($_SESSION['user_id'])): ?>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input
                type="text"
                id="username"
                name="username"
                maxlength="50"
                autocomplete="username"
                required
            >

            <label for="password">Password:</label>
            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
            >

            <button type="submit">Login</button>
        </form>
    <?php else: ?>
        <p>You are logged in as
            <?= htmlspecialchars($_SESSION['username']) ?>.
        </p>
    <?php endif; ?>
</main>

<?php include 'footer.inc'; ?>
