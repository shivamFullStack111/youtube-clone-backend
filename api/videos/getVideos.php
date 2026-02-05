<?php

// Allow all origins
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


header("Content-Type: application/json");
include __DIR__ . '/../../config/db.php';

$result = $conn->query("SELECT * FROM videos ORDER BY upload_date DESC");

$videos = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $videos[] = $row;
    }
}

echo json_encode($videos);

$conn->close();
?>
