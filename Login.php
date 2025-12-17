<?php
session_start();
<!--Jerry Behen-->

// Get login form data safely
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Connect to SQLite database
$db = new SQLite3('users.db');

// Look up user by username
$stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$result = $stmt->execute();
$user = $result->fetchArray(SQLITE3_ASSOC);

if ($user) {
  // Check the hashed password
  if (password_verify($password, $user['password'])) {
    //  Password is correct — set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    //  Redirect to your protected page (must be .php!)
    header('Location: protected.php');
    exit;
  } else {
    echo "<h3>Invalid password.</h3>";
    echo "<a href='login.html'>Try again</a>";
  }
} else {
  echo "<h3>User not found.</h3>";
  echo "<a href='login.html'>Try again</a>";
}

$db->close();
?>
