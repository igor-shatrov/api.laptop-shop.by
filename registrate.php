<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Version, Authorization, Content-Type');
header("Content-Type: application/json; charset=UTF-8");
require_once('function.php');
$data=(array)json_decode(file_get_contents('php://input'));
$conn=connect();
$sql="SELECT * FROM users WHERE email='".$data['email']."'";
$query=mysqli_query($conn, $sql);
if (mysqli_num_rows($query) > 0) {
	echo json_encode('this email exist');
}else{
$sql="INSERT INTO users(firstName, lastName, email, password) VALUES ('".$data['firstName']."', '".$data['lastName']."', '".$data['email']."', '".md5($data['password'])."')";
$query=mysqli_query($conn, $sql);
$sql="SELECT * FROM users WHERE email='".$data['email']."' AND password='".md5($data['password'])."'";
$query=mysqli_query($conn, $sql);
if (mysqli_num_rows($query) > 0) {
	echo json_encode('success');
}else{
	echo json_encode('error');
}}

close($conn);
