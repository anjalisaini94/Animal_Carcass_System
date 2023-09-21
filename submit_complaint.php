<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'carcass';


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}


$informersName = $_POST['informersName'];
$informersAddress = $_POST['informersAddress'];
$informersPhoneNumber = $_POST['informersPhoneNumber'];
$informersEmail = $_POST['informersEmail'];
$animalType = $_POST['animalType'];
$animalCarcassLocation = $_POST['animalCarcassLocation'];
$date = $_POST['date'];
$description = $_POST['description'];
$token = $_POST['token'];
$submissionTime = date('Y-m-d H:i:s'); 


$sql = "INSERT INTO complaint (informersName, informersAddress, informersPhoneNumber, informersEmail, animalType, animalCarcassLocation, date, description, token, submissionTime)
        VALUES ('$informersName', '$informersAddress', '$informersPhoneNumber', '$informersEmail', '$animalType', '$animalCarcassLocation', '$date', '$description', '$token', '$submissionTime')";

if ($conn->query($sql) === TRUE) {
  echo 'success';
} else {
  echo 'Error: ' . $sql . '<br>' . $conn->error;
}


$conn->close();
?>
