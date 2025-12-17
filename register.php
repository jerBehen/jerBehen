<?php
// Start session if you want to redirect later (optional)
session_start();

// Get form data safely
$first_name = $_POST['first_name'] ?? '';
$last_name  = $_POST['last_name'] ?? '';
$email      = $_POST['email'] ?? '';
$username   = $_POST['username'] ?? '';
$password   = $_POST['password'] ?? '';

//  Hash the password safely with built-in function
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

//  Connect to SQLite database
$db = new SQLite3('users.db');

//  Create users table if it doesn't exist
$db->exec("
  CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    first_name TEXT,
    last_name TEXT,
    email TEXT,
    username TEXT UNIQUE,
    password TEXT
  )
");

//  Insert user using prepared statement
$stmt = $db->prepare("
  INSERT INTO users (first_name, last_name, email, username, password)
  VALUES (:first_name, :last_name, :email, :username, :password)
");

$stmt->bindValue(':first_name', $first_name, SQLITE3_TEXT);
$stmt->bindValue(':last_name',  $last_name,  SQLITE3_TEXT);
$stmt->bindValue(':email',      $email,      SQLITE3_TEXT);
$stmt->bindValue(':username',   $username,   SQLITE3_TEXT);
$stmt->bindValue(':password',   $hashed_password, SQLITE3_TEXT);

$result = $stmt->execute();

if ($result) {
  echo "Registration successful!<br>";
  echo "<a href='login.html'>Click here to login</a>";
} else {
  echo "Error: Could not register. That username might already exist.<br>";
  echo "<a href='registration.html'>Try again</a>";
}

$db->close();
?>
