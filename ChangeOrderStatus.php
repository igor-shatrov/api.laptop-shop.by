<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Version, Authorization, Content-Type');
header("Content-Type: application/json; charset=UTF-8");
require_once('function.php');
$data=(array)json_decode(file_get_contents('php://input'));
$conn=connect();
$sql="UPDATE orders SET status='".$data['action']."' WHERE id='".$data['id']."'";
$query=mysqli_query($conn, $sql);
$sql="SELECT * FROM orders WHERE status='".$data['action']."' AND id='".$data['id']."'";
$query=mysqli_query($conn, $sql);
if (mysqli_num_rows($query)>0) {
	echo json_encode('success');
}else{
	echo json_encode('error');
}