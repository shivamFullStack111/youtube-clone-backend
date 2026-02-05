<?php
header("Content-Type: application/json");
// Allow all origins
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$conn = new mysqli("localhost", "root", "", "video_app");
if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit;
}

if (!isset($_GET['q']) || empty($_GET['q'])) {
    echo json_encode([
        "success" => false,
        "message" => "Search query missing"
    ]);
    exit;
}

$search = $_GET['q'];

// SQL search
$sql = "SELECT * FROM videos 
        WHERE title LIKE '%$search%' 
        OR tags LIKE '%$search%' 
        OR category LIKE '%$search%'
        ORDER BY totalViews DESC";

$result = $conn->query($sql);

$videos = [];
while ($row = $result->fetch_assoc()) {
    $row['uploadedBy']   = json_decode($row['uploadedBy']);
    $row['likesArray']   = json_decode($row['likesArray']);
    $row['dislikeArray'] = json_decode($row['dislikeArray']);
    $videos[] = $row;
}

echo json_encode([
    "success" => true,
    "totalResults" => count($videos),
    "data" => $videos
]);
