<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Version, Authorization, Content-Type');
header("Content-Type: application/json; charset=UTF-8");
require_once('function.php');
$conn=connect();
$sql="SELECT id, name, shortInfo, gCode, price, firstImage FROM laptops ORDER BY popularity LIMIT 4";
$query=mysqli_query($conn, $sql);
while($row=mysqli_fetch_assoc($query)){
	$rows[$row[id]]=$row;
}
echo json_encode($rows);
close($conn);