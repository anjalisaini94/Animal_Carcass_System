<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.html");
  exit();
}

$loggedInUsername = $_SESSION['username'];

// Create a database connection
$conn = new mysqli("localhost", "root", "", "carcass");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: index.html");
  exit();
}

// Fetch complaints from the complaints table
$query = "SELECT token, informersName,informersPhoneNumber,informersEmail, animalType,animalCarcassLocation, complaintStatus FROM complaint";
$result = $conn->query($query);

// Display complaints with status and buttons to change status
?><!DOCTYPE html>
<html>
<head>
  <title>Animal Picker Dashboard</title>
  <!-- Add Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h2>Welcome, <?php echo $loggedInUsername; ?>!</h2>
    <a href="?logout=true" class="btn btn-danger">Logout</a>
    <h3>Complaints List</h3>
    <table class="table">
      <thead>
        <tr>
          <th>Token</th>
          <th>Informers Name</th>
          <th>Contact Number</th>
          <th>Email</th>
          <th>Animal Type</th>
          <th>Animal Location</th>
          <th>Complaint Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Loop through complaints and display them in rows
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["token"] . "</td>";
            echo "<td>" . $row["informersName"] . "</td>";
            echo "<td>" . $row["informersPhoneNumber"] . "</td>";
            echo "<td>" . $row["informersEmail"] . "</td>";
            echo "<td>" . $row["animalType"] . "</td>";
            echo "<td>" . $row["animalCarcassLocation"] . "</td>";
            echo "<td>" . $row["complaintStatus"] . "</td>";
            echo '<td>
                    <form action="change_status.php" method="post">
                      <input type="hidden" name="complaint_id" value="' . $row["token"] . '">
                      <select name="new_status">
                        <option value="Submitted">Submitted</option>
                        <option value="In Process">In Process</option>
                        <option value="Completed">Completed</option>
                      </select>
                      <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                  </td>';
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='5'>No complaints found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <!-- Add Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>