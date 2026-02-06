<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Preflight request stop here
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// DB connection
$conn = new mysqli("localhost", "root", "", "video_app");

if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "DB connection failed"
    ]);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid JSON"
    ]);
    exit;
}

// Fields
$title       = $conn->real_escape_string($data['title']);
$description = $conn->real_escape_string($data['description']);
$videoUrl    = $conn->real_escape_string($data['videoUrl']);
$tags        = $conn->real_escape_string($data['tags']);
$category    = $conn->real_escape_string($data['category']);
$uploadedBy  = json_encode($data['uploadedBy']);

$likesArray   = json_encode([]);
$dislikeArray = json_encode([]);
$totalLikes   = 0;
$totalDislike = 0;
$totalViews   = 0;

// Insert query
$sql = "INSERT INTO videos 
(title, description, videoUrl, tags, category, totalLikes, likesArray, totalDislike, dislikeArray, totalViews, uploadedBy)
VALUES 
('$title', '$description', '$videoUrl', '$tags', '$category', $totalLikes, '$likesArray', $totalDislike, '$dislikeArray', $totalViews, '$uploadedBy')";

if ($conn->query($sql)) {
    echo json_encode([
        "success" => true,
        "message" => "Video uploaded successfully"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Upload failed",
        "error" => $conn->error
    ]);
}
