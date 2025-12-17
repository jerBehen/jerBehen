<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login.html');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Protected Page</title>
  <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<header>
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
  <p>This page is only visible to logged-in users.</p>
 </header>
<!-- New nav bar-->
<nav>
    <a href="index.html" class="button">Home</a>
    <a href="registration.html" class="button">Register</a>
    <a href="logout.php" class="button">Logout</a>
</nav>
</body>
</html>
