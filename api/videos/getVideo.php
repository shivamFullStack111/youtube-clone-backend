<?php

// Allow all origins
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


header("Content-Type: application/json");
include __DIR__ . '/../../config/db.php';

$videoId = $_GET['id'] ?? null;

if (!$videoId) {
    echo json_encode(["success" => false, "message" => "Video ID is required"]);
    exit;
}

// Fetch video by ID
$stmt = $conn->prepare("SELECT * FROM videos WHERE id = ?");
$stmt->bind_param("i", $videoId);
$stmt->execute();
$result = $stmt->get_result();

if ($video = $result->fetch_assoc()) {
    echo json_encode(["success" => true, "video" => $video]);
} else {
    echo json_encode(["success" => false, "message" => "Video not found"]);
}

$stmt->close();
$conn->close();
?>
