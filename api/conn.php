<?php
$servername = "131.196.198.114";
$username = "woods";
$password = "!57gPG6C1Ov3";
$db = "inter2024";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>