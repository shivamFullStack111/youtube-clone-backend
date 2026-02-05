<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "video_app"; // ya jo DB name hai

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Test
// echo "DB connected successfully";
?>
