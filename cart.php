<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Version, Authorization, Content-Type');
header("Content-Type: application/json; charset=UTF-8");
require_once('function.php');
$data=(array)json_decode(file_get_contents('php://input'));
$conn=connect();
$info=[];
foreach ($data['gCode'] as $elem) {
	$sql="SELECT id, name, firstImage, price, gCode FROM laptops WHERE gCode='".$elem."'";
	$query=mysqli_query($conn, $sql);
	if(mysqli_num_rows($query)>0){
		$info[$elem] = mysqli_fetch_assoc($query);
	}
}
if($info){
	echo json_encode($info);
}else{
	echo json_encode('not exist');
}

close($conn);