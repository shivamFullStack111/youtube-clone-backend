<?php
// CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

$conn = new mysqli("localhost","root","","video_app");
if ($conn->connect_error) { echo json_encode(["success"=>false]); exit; }

$data = json_decode(file_get_contents("php://input"), true);
$videoId = $data['videoId'];

$conn->query("UPDATE videos SET totalViews = totalViews + 1 WHERE id='$videoId'");

echo json_encode(["success"=>true,"message"=>"View added"]);
