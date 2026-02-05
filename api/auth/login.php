<?php
// Allow all origins
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


include("../../config/db.php");

$data = json_decode(file_get_contents("php://input"), true);

$email    = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (!$email || !$password) {
    echo json_encode([
        "success" => false,
        "message" => "Email and Password are required"
    ]);
    exit;
}

$query = "SELECT id, name, email, channelName, channelDescription, joinedOn 
          FROM users 
          WHERE email='$email' AND password='$password'";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);

    echo json_encode([
        "success" => true,
        "message" => "Login successful",
        "user" => $user
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password"
    ]);
}
