<?php

// Allow all origins
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");



header("Content-Type: application/json");
include __DIR__ . '/../../config/db.php'; // DB connection

$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$videoUrl = $_POST['videoUrl'] ?? '';
$thumbnail = $_POST['thumbnail'] ?? '';
$category = $_POST['category'] ?? '';
$tags = $_POST['tags'] ?? '';
$channel_name = 'PlayZone Creator'; // For now, hardcoded

// Validation
if (!$title || !$videoUrl) {
    echo json_encode(["success" => false, "message" => "Title and Video URL are required"]);
    exit;
}

// Insert into DB
$stmt = $conn->prepare("INSERT INTO videos (title, description, video_url, thumbnail_url, views, category, tags, channel_name) VALUES (?, ?, ?, ?, 0, ?, ?, ?)");
$stmt->bind_param("sssssss", $title, $description, $videoUrl, $thumbnail, $category, $tags, $channel_name);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Video uploaded successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Upload failed"]);
}

$stmt->close();
$conn->close();
?>
