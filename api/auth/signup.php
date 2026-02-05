<?php


// Allow all origins
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");



include('../../config/db.php');

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if(!$name || !$email || !$password){
    echo json_encode(["success"=>false, "message"=>"All fields required"]);
    exit;
}

// Check if email exists
$check = $conn->query("SELECT * FROM users WHERE email='$email'");
if($check->num_rows > 0){
    echo json_encode(["success"=>false, "message"=>"Email already exists"]);
    exit;
}

// Insert user
$conn->query("INSERT INTO users (name,email,password) VALUES ('$name','$email','$password')");
echo json_encode(["success"=>true, "message"=>"Signup successful"]);
?>
