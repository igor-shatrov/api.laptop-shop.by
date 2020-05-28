<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Version, Authorization, Content-Type');
header("Content-Type: application/json; charset=UTF-8");
require_once('function.php');
$data=(array)json_decode(file_get_contents('php://input'));
$minPrice=0;
$maxPrice=100000;
if($data['minPrice']){
	$minPrice=$data['minPrice'];
}
if ($data['maxPrice']) {
	$maxPrice = $data['maxPrice'];
}
if(count($data['producer'])>0){
	$conn=connect();
	$allRows=[];
	for($i=0; count($data['producer'])>$i; $i++){
		$sql="SELECT id, name, shortInfo, gCode, price, firstImage FROM laptops WHERE price>'".$minPrice."' AND price<'".$maxPrice."' AND producerName='".$data['producer'][$i]."'";
		$query=mysqli_query($conn, $sql);
		$rows=[];
		if (mysqli_num_rows($query) > 0) {
			while ($row = mysqli_fetch_assoc($query)) {
       			$rows[$row[id]]=$row;
   		}
   		}
   		$allRows=$allRows+$rows;
	}
	echo json_encode($allRows);
	close($conn);
} else {
	$conn=connect();
	$sql="SELECT id, name, shortInfo, gCode, price, firstImage FROM laptops WHERE price>'".$minPrice."' AND price<'".$maxPrice."'";
	$query=mysqli_query($conn, $sql);
	if (mysqli_num_rows($query) > 0) {
		while ($row = mysqli_fetch_assoc($query)) {
       		$rows[$row[id]]=$row;
   		}
	echo json_encode($rows);
	close($conn);
	}
}
// switch ($_GET['category']) {
// 	case 'all':
// 		
// 		}
// 		break;
// 	case 'filter':
// 		$conn=connect();
// 		$sql="SELECT id, name, shortInfo, gCode, price, firstImage FROM laptops WHERE producerName=";
// 		break;
// 	default:
// 		echo json_encode('not found');
// 		break;
// }
