<?php
session_start();

// Create a database connection
$conn = new mysqli("localhost", "root", "", "carcass");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve and sanitize form data
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Fetch user from the animal_picker table
  $query = "SELECT id, username, password FROM animal_picker WHERE username = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows == 1) {
    $stmt->bind_result($id, $username, $hashedPassword);
    $stmt->fetch();

    // Verify password and set session if successful
    if (password_verify($password, $hashedPassword)) {
      $_SESSION['username'] = $username;
      header("Location: dashboard.php");
      exit();
    } else {
      echo "Incorrect password";
    }
  } else {
    echo "User not found";
  }

  $stmt->close();
}

// Close the database connection
$conn->close();
?>
