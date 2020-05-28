<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Version, Authorization, Content-Type');
header("Content-Type: application/json; charset=UTF-8");
require_once('function.php');
$data=(array)json_decode(file_get_contents('php://input'));
$conn=connect();
$sql="SELECT privileges FROM users WHERE id='".$data['id']."' AND hash='".$data['hash']."'";
$query=mysqli_query($conn, $sql);

if (mysqli_num_rows($query) > 0) {
	$row = mysqli_fetch_assoc($query);
	echo json_encode($row);
}else{
	echo json_encode('not found');
}

close($conn);