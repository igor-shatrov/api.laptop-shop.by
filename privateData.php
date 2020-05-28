<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Version, Authorization, Content-Type');
header("Content-Type: application/json; charset=UTF-8");
require_once('function.php');
$data=(array)json_decode(file_get_contents('php://input'));
$conn=connect();
switch ($data['action']) {
	case 'show':
		$sql="SELECT firstName, lastName, email, city, street, house, phone FROM users WHERE id='".$data['id']."'";
		$query=mysqli_query($conn, $sql);
		if (mysqli_num_rows($query) < 0) {
			echo json_encode('user not found');
		}else{
			echo json_encode(mysqli_fetch_assoc($query));
		}
		break;
	case 'change':
		$sql="UPDATE users SET ".$data['property']."='".$data['value']."' WHERE id='".$data['id']."'";
		$query=mysqli_query($conn, $sql);
		$sql="SELECT * FROM users WHERE id=".$data['id']." AND '".$data['property']."'='".$data['value']."'";
		$query=mysqli_query($conn, $sql);
		if (mysqli_num_rows($query) > 0) {
			echo json_encode('success');
		}else{
			echo json_encode('error');
		}
		break;
	case 'changePassword':
		$sql="UPDATE users SET password='".md5($data['newPassword'])."' WHERE id='".$data['id']."'";
		$query=mysqli_query($conn, $sql);
		$sql="SELECT * FROM users WHERE id='".$data['id']."' AND password='".md5($data['newPassword'])."'";
		$query=mysqli_query($conn, $sql);
		if (mysqli_num_rows($query) > 0) {
			echo json_encode('success');
		}else{
			echo json_encode('error');
		}
		break;
	default:
		echo json_encode("wrong action");
		break;
}



close($conn);
