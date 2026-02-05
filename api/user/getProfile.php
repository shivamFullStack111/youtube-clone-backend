<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "video_app");
if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit;
}

// userId required
if (!isset($_GET['userId'])) {
    echo json_encode([
        "success" => false,
        "message" => "userId is required"
    ]);
    exit;
}

$userId = $_GET['userId'];

$sql = "SELECT id, name, email, channelName, channelDescription, 
               totalSubscriber, subscribers, joinedOn 
        FROM users 
        WHERE id='$userId'";

$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "User not found"
    ]);
    exit;
}

$user = $result->fetch_assoc();

// Decode subscribers JSON
$user['subscribers'] = json_decode($user['subscribers']);

echo json_encode([
    "success" => true,
    "data" => $user
]);
