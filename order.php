<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Version, Authorization, Content-Type');
header("Content-Type: application/json; charset=UTF-8");
require_once('function.php');
$data=(array)json_decode(file_get_contents('php://input'));
if($data['quantity']!=""){
$quantity='';
foreach ($data['quantity'] as $key => $value) {
	$quantity.="{$key}:{$value},";
}
$city=$data['city'];
$street=$data['street'];
$house=$data['house'];
$phone=$data['phone'];
$totalPrice=$data['totalPrice'];
$userId=$data['userId'];
$conn=connect();

$sql="INSERT INTO orders (quantity, city, street, house, phone, totalPrice, userId) VALUES ('".$quantity."', '".$city."', '".$street."', '".$house."', '".$phone."', '".$totalPrice."', '".$userId."')";
$query=mysqli_query($conn, $sql);
$sql="SELECT * FROM orders WHERE quantity='".$quantity."' AND city='".$city."' AND street='".$street."' AND house='".$house."' AND phone='".$phone."'";
$query=mysqli_query($conn, $sql);
if(mysqli_num_rows($query)>0){
	echo json_encode('succes');
}else{
	echo json_encode('error');
}

close($conn);
}