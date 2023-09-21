<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'carcass';


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
  $token = $_POST['token'];
  $phoneNumber = $_POST['phoneNumber'];

  
  $stmt = $conn->prepare("SELECT complaintStatus FROM complaint WHERE token = ? AND informersPhoneNumber = ?");
  $stmt->bind_param("ss", $token, $phoneNumber);
  $stmt->execute();
  $stmt->bind_result($complaintStatus);
  $stmt->fetch();
  $stmt->close();


  if ($complaintStatus) {
  
    echo $complaintStatus;
  } else {
   
    echo "Not Found";
  }
}


$conn->close();
?>
