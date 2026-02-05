<?php

header("Content-Type: application/json");

// Allow all origins
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include("../../config/db.php"); // DB connection

$data = json_decode(file_get_contents("php://input"), true);

$name        = $data['name'] ?? '';
$email       = $data['email'] ?? '';
$password    = $data['password'] ?? '';
$channelName = $data['channelName'] ?? '';
$description = $data['description'] ?? '';

if (!$name || !$email || !$password) {
    echo json_encode([
        "success" => false,
        "message" => "Name, Email and Password are required"
    ]);
    exit;
}

// check email already exists
$check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
if (mysqli_num_rows($check) > 0) {
    echo json_encode([
        "success" => false,
        "message" => "Email already registered"
    ]);
    exit;
}

// insert user
$query = "INSERT INTO users 
(name, email, password, channelName, channelDescription, subscribers, joinedOn)
VALUES 
('$name', '$email', '$password', '$channelName', '$description', '[]', NOW())";

if (mysqli_query($conn, $query)) {

    $userId = mysqli_insert_id($conn);

    // fetch inserted user
    $userQuery = mysqli_query($conn, "SELECT 
        id, name, email, channelName, channelDescription, subscribers, joinedOn 
        FROM users WHERE id='$userId'");

    $user = mysqli_fetch_assoc($userQuery);

    echo json_encode([
        "success" => true,
        "message" => "Signup successful",
        "user" => $user
    ]);

} else {
    echo json_encode([
        "success" => false,
        "message" => "Signup failed"
    ]);
}
