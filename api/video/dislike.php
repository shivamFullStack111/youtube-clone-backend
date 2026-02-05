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
$user    = $data['user'];

$res = $conn->query("SELECT likesArray, dislikeArray FROM videos WHERE id='$videoId'");
if ($res->num_rows == 0) { echo json_encode(["success"=>false]); exit; }

$row = $res->fetch_assoc();
$likes    = json_decode($row['likesArray'], true);
$dislikes = json_decode($row['dislikeArray'], true);

// remove from likes
$likes = array_values(array_filter($likes, fn($u)=>$u['id']!=$user['id']));

// add to dislike if not exists
$exists = false;
foreach ($dislikes as $u) if ($u['id']==$user['id']) $exists=true;
if (!$exists) $dislikes[] = $user;

$conn->query("UPDATE videos SET 
    likesArray='".json_encode($likes)."',
    dislikeArray='".json_encode($dislikes)."',
    totalLikes=".count($likes).",
    totalDislike=".count($dislikes)."
    WHERE id='$videoId'");

echo json_encode(["success"=>true,"message"=>"Disliked"]);
