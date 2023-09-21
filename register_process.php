<?php
// Create a database connection
$conn = new mysqli("localhost", "root", "", "carcass");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve and sanitize form data
  $name = $_POST['name'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $qualification = $_POST['qualification'];
  $username = $_POST['username'];
  $password = $_POST['password'];  // Note: No need to hash the password yet
  
  // Encrypt password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Insert data into the animal_picker table
  $query = "INSERT INTO animal_picker (name, address, email, qualification, username, password) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ssssss", $name, $address, $email, $qualification, $username, $hashedPassword);
  
  if ($stmt->execute()) {
    // Registration successful, redirect to login page
    header("Location: pickup.html");
    exit();
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
}

// Close the database connection
$conn->close();
?>
