<?php
session_start();

// Create a database connection
$conn = new mysqli("localhost", "root", "", "carcass");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $complaintId = $_POST['complaint_id'];
  $newStatus = $_POST['new_status'];
  $loggedInUsername = $_SESSION['username'];

  // Update the complaints table with the new status and timestamps
  $updateQuery = "UPDATE complaint SET complaintStatus = ?, inProcessTimestamp = NOW() WHERE id = ?";
  $stmt = $conn->prepare($updateQuery);

  if (!$stmt) {
    die("Error: " . $conn->error);
  }

  $stmt->bind_param("si", $newStatus, $complaintId);
  
  if ($stmt->execute()) {
    header("Location: dashboard.php");
    exit();
  } else {
    echo "Error updating status: " . $stmt->error;
  }

  $stmt->close();
}

// Close the database connection
$conn->close();
?>
