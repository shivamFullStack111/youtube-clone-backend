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
$user    = $data['user']; // full user object

// get current video
$res = $conn->query("SELECT likesArray, dislikeArray, totalLikes, totalDislike FROM videos WHERE id='$videoId'");
if ($res->num_rows == 0) { echo json_encode(["success"=>false,"message"=>"Video not found"]); exit; }

$row = $res->fetch_assoc();
$likes    = json_decode($row['likesArray'], true);
$dislikes = json_decode($row['dislikeArray'], true);

// remove from dislike if exists
$dislikes = array_values(array_filter($dislikes, fn($u)=>$u['id']!=$user['id']));

// add to like if not exists
$exists = false;
foreach ($likes as $u) if ($u['id']==$user['id']) $exists=true;
if (!$exists) $likes[] = $user;

$likesJson    = json_encode($likes);
$dislikesJson = json_encode($dislikes);

$conn->query("UPDATE videos SET 
    likesArray='$likesJson',
    dislikeArray='$dislikesJson',
    totalLikes=".count($likes).",
    totalDislike=".count($dislikes)."
    WHERE id='$videoId'");

echo json_encode(["success"=>true,"message"=>"Liked"]);
