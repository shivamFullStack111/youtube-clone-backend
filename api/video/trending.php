<?php
header("Content-Type: application/json");
// Allow all origins
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$conn = new mysqli("localhost", "root", "", "video_app");
if ($conn->connect_error) {
    echo json_encode(["success"=>false,"message"=>"DB error"]);
    exit;
}

$sql = "SELECT * FROM videos ORDER BY totalViews DESC";
$result = $conn->query($sql);

$videos = [];
while ($row = $result->fetch_assoc()) {
    $row['uploadedBy']   = json_decode($row['uploadedBy']);
    $row['likesArray']   = json_decode($row['likesArray']);
    $row['dislikeArray'] = json_decode($row['dislikeArray']);
    $videos[] = $row;
}

echo json_encode(["success"=>true,"data"=>$videos]);
