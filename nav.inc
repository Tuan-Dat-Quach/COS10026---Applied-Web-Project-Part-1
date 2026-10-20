
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav aria-label="Main navigation">
    <ul id="menu">
        <li>
            <a href="index.php">
                <span aria-hidden="true">🪴</span> Home
            </a>
        </li>

        <li>
            <a href="jobs.php">
                <span aria-hidden="true">📝</span> Jobs
            </a>
        </li>

        <li>
            <a href="apply.php">
                <span aria-hidden="true">📄</span> Apply
            </a>
        </li>

        <li>
            <a href="about.php">
                <span aria-hidden="true">👥</span> About
            </a>
        </li>

        <?php if (!empty($_SESSION['user_id'])): ?>

            <?php if (($_SESSION['role'] ?? '') === 'manager'): ?>
                <li>
                    <a href="manager.php">Manager</a>
                </li>
            <?php else: ?>
                <li>
                    <a href="user.php">User</a>
                </li>
            <?php endif; ?>

            <li>
                <a href="logout.php">Logout</a>
            </li>

        <?php else: ?>

            <li>
                <a href="login.php">Login</a>
            </li>

            <li>
                <a href="signup.php">Sign Up</a>
            </li>

        <?php endif; ?>
    </ul>
</nav>
