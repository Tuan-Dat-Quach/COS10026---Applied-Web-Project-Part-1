
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Use basename function to get filename from the specified path
$current_page = basename($_SERVER['PHP_SELF']);

// Store the parameters when users choose the logout button and see the confirmation
$current_parameters = $_GET;
$current_parameters['confirm_logout'] = '1';
$logout_url = $current_page . '?' . http_build_query($current_parameters);

$saved_url = htmlspecialchars($logout_url, ENT_QUOTES, 'UTF-8');
?>

<nav aria-label="Main navigation">
    <ul id="menu">
        <li>
            <a href="index.php">
                <span aria-hidden="true"> 🪴 </span> Home
            </a>
        </li>

        <li>
            <a href="jobs.php">
                <span aria-hidden="true"> 📝 </span> Jobs
            </a>
        </li>

        <li>
            <a href="apply.php">
                <span aria-hidden="true"> 📄 </span> Apply
            </a>
        </li>

        <li>
            <a href="about.php">
                <span aria-hidden="true"> 👥 </span> About
            </a>
        </li>

        <?php if (!empty($_SESSION['user_id'])): ?>

            <?php if (($_SESSION['role'] ?? '') === 'Manager'): ?>
                <li>
                    <a href="manager.php"> 
                        <span aria-hidden="true"> 📊 </span> Manager
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <a href="user.php">
                        <span aria-hidden="true"> 👤 </span> User
                    </a>
                </li>
            <?php endif; ?>

            <li>
                <a href="<?php echo $saved_url; ?>">
                    <span aria-hidden="true"> 🚪 </span> Logout
                </a>
            </li>

        <?php else: ?>

            <li>
                <a href="login.php">
                    <span aria-hidden="true"> 🔑 </span> Login
                </a>
            </li>

            <li>
                <a href="signup.php">
                    <span aria-hidden="true"> ✍️ </span> Sign Up
                </a>
            </li>

        <?php endif; ?>
    </ul>
</nav>
