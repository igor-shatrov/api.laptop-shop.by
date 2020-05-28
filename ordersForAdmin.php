<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Version, Authorization, Content-Type');
header("Content-Type: application/json; charset=UTF-8");
require_once('function.php');
$data=(array)json_decode(file_get_contents('php://input'));
$conn=connect();
$sql="SELECT * FROM orders ORDER BY date DESC";
$query=mysqli_query($conn, $sql);
while($row=mysqli_fetch_assoc($query)){
	$rows[$row[id]]=$row;
}
echo json_encode($rows);