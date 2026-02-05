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

$videoId = $_GET['id'];

$sql = "SELECT * FROM videos WHERE id='$videoId'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo json_encode(["success"=>false,"message"=>"Video not found"]);
    exit;
}

$row = $result->fetch_assoc();
$row['uploadedBy']   = json_decode($row['uploadedBy']);
$row['likesArray']   = json_decode($row['likesArray']);
$row['dislikeArray'] = json_decode($row['dislikeArray']);

echo json_encode(["success"=>true,"data"=>$row]);
