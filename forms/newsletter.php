<?php

// Database connection details (replace with your own)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "guardianbytes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection  

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values  

$name = $email = $subject = $message = "";

// Processing form data after submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = test_input($_POST["email"]);
  


  // Prepare and secure data for insertion (prevents SQL injection)
  $stmt = $conn->prepare("INSERT INTO newsletter (email) VALUES (?)");
  $stmt->bind_param("s",$email);  


  if ($stmt->execute()) {
    $success_message = "Your subscription request has been sent. Thank you";
    echo "<script>openPopup();</script>";
    header('Location: ../#hero/?success=' . urldecode($success_message));
    exit;
  } else {
    $error_message = "Error sending message: " . $conn->error;
  }

  $stmt->close();
}

$conn->close();

// Function to prevent XSS attacks
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
