<?php
  if (session_status() === PHP_SESSION_NONE) {
  session_start();
  }
  require_once 'settings.php';

  // Logged-in users do not need to sign up
  if (isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
  }

  $error = '';
  $success_signup = false;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($username === '' || $password === '' || $confirm === '') {
      $error = '⚠️ Username and Password cannot be empty. Please enter again.';
    } elseif (strlen($username) > 50) {
      $error = '⚠️ Username is too long. It must be 50 characters or fewer.';
    } elseif (strlen($password) < 6) {
      $error = '⚠️ Password is too short. Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
      $error = '⚠️ Your confirmed password does not match with the previous.';
    } else {
      // Check whether the username is already taken
      $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $result = $stmt->get_result();

      if (mysqli_num_rows($result) > 0) {
        $error = 'This username is already taken.';
        $stmt->close();
      } else {
        $stmt->close();
        // Hash the password before saving it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'User')");
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        $stmt->close();
        $success_signup = true;
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

<body class="signup-page">

<?php include 'header.inc'; ?>

    <main>
        <h1> Sign Up </h1>

        <?php
        if ($success_signup) {
          echo "<div class='signup-row success-row'>";
          echo "<p class='signup-message success'>";
          echo "<span aria-hidden='true'> ✅ </span> Signed up successfully. <a href='login.php'> Go back to login </a>";
          echo "</p>";
          echo "</div>";
        } else {
          echo "<form action='signup.php' method='POST' novalidate>";
            if ($error !== '') {
              echo "<div class='signup-row'>";
              echo "<span class='label-space'></span>";
              echo "<p class='signup-message error'>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</p>";
              echo "</div>";
            }
          // Username
          echo "<div class='signup-row'>";
          echo "<label for='username'> Username: </label>";
          // Use value to keep the entered username in case there is error
          echo "<input type='text' id='username' name='username' value='" . htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8') . "'>";
          echo "</div>";
          // Password
          echo "<div class='signup-row'>";
          echo "<label for='password'> Password: </label>";
          echo "<input type='password' id='password' name='password'>";
          echo "</div>";
          // Confirm password
          echo "<div class='signup-row'>";
          echo "<label for='confirm'> Confirm Password: </label>";
          echo "<input type='password' id='confirm' name='confirm' required>";
          echo "</div>";
          // Sign up button
          echo "<button type='submit'> Sign Up </button>";
          echo "</form>";
        }
        ?>
    </main>

<?php include 'footer.inc'; ?>

</body>
</html>