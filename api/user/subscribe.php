<?php
// CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "video_app");
if ($conn->connect_error) {
    echo json_encode(["success"=>false,"message"=>"DB error"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

// Channel owner ID (jisko subscribe karna hai)
$channelUserId = $data['channelUserId'];

// Subscriber FULL USER DATA
$subscriber = $data['subscriber']; // {id,name,email,channelName}

if (!$channelUserId || !$subscriber) {
    echo json_encode(["success"=>false,"message"=>"Invalid data"]);
    exit;
}

// Fetch channel user
$res = $conn->query("SELECT subscribers, totalSubscriber FROM users WHERE id='$channelUserId'");
if ($res->num_rows === 0) {
    echo json_encode(["success"=>false,"message"=>"User not found"]);
    exit;
}

$row = $res->fetch_assoc();
$subscribers = json_decode($row['subscribers'], true);
if (!$subscribers) $subscribers = [];

// Check already subscribed?
$found = false;
foreach ($subscribers as $key => $sub) {
    if ($sub['id'] == $subscriber['id']) {
        // UNSUBSCRIBE
        unset($subscribers[$key]);
        $found = true;
        break;
    }
}

if (!$found) {
    // SUBSCRIBE
    $subscribers[] = $subscriber;
}

$subscribers = array_values($subscribers);
$totalSubscriber = count($subscribers);

// Update DB
$conn->query("UPDATE users SET 
    subscribers='".json_encode($subscribers)."',
    totalSubscriber='$totalSubscriber'
    WHERE id='$channelUserId'");

// Response
echo json_encode([
    "success" => true,
    "action"  => $found ? "unsubscribed" : "subscribed",
    "totalSubscriber" => $totalSubscriber
]);
