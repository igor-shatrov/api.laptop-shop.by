<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Version, Authorization, Content-Type');
header("Content-Type: application/json; charset=UTF-8");
require_once('function.php');
$data=(array)json_decode(file_get_contents('php://input'));
$conn=connect();
$sql="SELECT id, date, totalPrice, status, quantity FROM orders WHERE userId='".$data['id']."'";
$query=mysqli_query($conn, $sql);
if(mysqli_num_rows($query)>0){
	while ($row = mysqli_fetch_assoc($query)) {
		$arr=explode(',', substr($row[quantity],0,-1));
		$names=[];
		foreach ($arr as  $value) {
			$sql="SELECT name FROM laptops WHERE gCode='".substr($value, 0, 6)."'";
			$queryName=mysqli_query($conn, $sql);
			$names[substr($value, 0, 6)]=mysqli_fetch_assoc($queryName)[name];
		}
    $rows[$row[id]]=$row;
    $rows[$row[id]][names]=$names;
   		}
	echo json_encode($rows);
}else{
	echo json_encode("not order");
}
close($conn);