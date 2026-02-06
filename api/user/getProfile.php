<?php
// ================= CORS HEADERS =================
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// ================= DB CONNECTION =================
$conn = new mysqli("localhost", "root", "", "video_app");

if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit;
}

// ================= VALIDATION =================
if (!isset($_GET['userId'])) {
    echo json_encode([
        "success" => false,
        "message" => "userId is required"
    ]);
    exit;
}

$userId = $conn->real_escape_string($_GET['userId']);

// ================= QUERY =================
$sql = "SELECT 
            id,
            name,
            email,
            channelName,
            channelDescription,
            totalSubscriber,
            subscribers,
            joinedOn
        FROM users
        WHERE id = '$userId'";

$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "message" => "User not found"
    ]);
    exit;
}

$user = $result->fetch_assoc();

// Decode JSON fields safely
$user['subscribers'] = $user['subscribers']
    ? json_decode($user['subscribers'], true)
    : [];

echo json_encode([
    "success" => true,
    "data" => $user
]);
