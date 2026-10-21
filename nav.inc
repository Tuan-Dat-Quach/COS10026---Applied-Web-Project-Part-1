
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
                <a href="?confirm_logout=1">
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
