<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Version, Authorization, Content-Type');
header("Content-Type: application/json; charset=UTF-8");
require_once('function.php');
$data=(array)json_decode(file_get_contents('php://input'));
switch ($data['action']) {
	case 'show':
		$conn=connect();
		$sql="SELECT producerName FROM laptops";
		$query=mysqli_query($conn, $sql);
		$result=mysqli_fetch_all($query);
		foreach ($result as &$value) {
			$value=implode($value);
		}
		$producer=array_unique($result);
		$sql="SELECT MIN(price) AS smallestPrice FROM laptops";
		$query=mysqli_query($conn, $sql);
		$smallestPrice=mysqli_fetch_assoc($query)['smallestPrice'];
		$sql="SELECT MAX(price) AS largestPrice FROM laptops";
		$query=mysqli_query($conn, $sql);
		$largestPrice=mysqli_fetch_assoc($query)['largestPrice'];
		close($conn);
		$dataOut=array(producer=>$producer, smallestPrice=>$smallestPrice, largestPrice=>$largestPrice);
		echo json_encode($dataOut);
		break;
	default:
		# code...
		break;
}

