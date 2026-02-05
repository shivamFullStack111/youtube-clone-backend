<?php


// Allow all origins
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");



include('../../config/db.php');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if(!$email || !$password){
    echo json_encode(["success"=>false, "message"=>"Email & Password required"]);
    exit;
}

$result = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");
if($result->num_rows > 0){
    $user = $result->fetch_assoc();
    echo json_encode(["success"=>true, "message"=>"Login successful", "user"=>$user]);
} else {
    echo json_encode(["success"=>false, "message"=>"Invalid email or password"]);
}
?>
