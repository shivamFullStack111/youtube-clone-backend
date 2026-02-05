<?php
header("Content-Type: application/json");// Allow all origins
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

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

// Video fields
$title       = $data['title'];
$description = $data['description'];
$videoUrl    = $data['videoUrl'];
$tags        = $data['tags'];
$category    = $data['category'];

// User data (FULL OBJECT)
$uploadedBy = json_encode($data['uploadedBy']);

// Default values
$likesArray   = json_encode([]);
$dislikeArray = json_encode([]);
$totalLikes   = 0;
$totalDislike = 0;
$totalViews   = 0;

// Insert query
$sql = "INSERT INTO videos
(title, description, videoUrl, tags, category, totalLikes, likesArray, totalDislike, dislikeArray, totalViews, uploadedBy)
VALUES
('$title', '$description', '$videoUrl', '$tags', '$category', '$totalLikes', '$likesArray', '$totalDislike', '$dislikeArray', '$totalViews', '$uploadedBy')";

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
