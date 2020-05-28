<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Version, Authorization, Content-Type');
header("Content-Type: application/json; charset=UTF-8");
require_once('function.php');
$data=(array)json_decode(file_get_contents('php://input'));
switch ($data['function']) {
	case 'list':
		$conn=connect();
		$sql="SELECT * FROM users";
		$query=mysqli_query($conn, $sql);
		$result=mysqli_fetch_all($query,MYSQLI_ASSOC);
		close($conn);
		echo json_encode($result);
		break;
	case 'password reset':
		$conn=connect();
		$newPassword=generatePassword(6);
		$sql="UPDATE users SET password='".md5($newPassword)."' WHERE users.id='".$data['id']."'";
		$query=mysqli_query($conn, $sql);
		$sql="SELECT email FROM users WHERE id='".$data['id']."' AND password='".md5($newPassword)."'";
		$query=mysqli_query($conn, $sql);
		if(mysqli_num_rows($query)>0){
			echo json_encode('success');
		}else{
			echo json_encode('error');
		}
		close($conn);
		break;
	case 'delete':
		$conn=connect();
		$sql="DELETE FROM users WHERE id='".$data['id']."'";
		$query=mysqli_query($conn, $sql);
		$sql="SELECT email FROM users WHERE id='".$data['id']."'";
		$query=mysqli_query($conn, $sql);
		if(mysqli_num_rows($query)>0){
			echo json_encode('error');
		}else{
			echo json_encode('success');
		}
		close($conn);
		break;
	case 'make admin':
		$conn=connect();
		$sql="UPDATE users SET privileges='admin' WHERE users.id='".$data['id']."'";
		$query=mysqli_query($conn, $sql);
		$sql="SELECT * FROM users WHERE users.id='".$data['id']."' AND privileges='admin'";
		$query=mysqli_query($conn, $sql);
		if(mysqli_num_rows($query)>0){
			echo json_encode('succes');
		}else{
			echo json_encode('error');
		}
		close($conn);
		break;
	case 'make user':
		$conn=connect();
		$sql="UPDATE users SET privileges='user' WHERE users.id='".$data['id']."'";
		$query=mysqli_query($conn, $sql);
		$sql="SELECT * FROM users WHERE users.id='".$data['id']."' AND privileges='user'";
		$query=mysqli_query($conn, $sql);
		if(mysqli_num_rows($query)>0){
			echo json_encode('succes');
		}else{
			echo json_encode('error');
		}
		close($conn);
		break;
	default:
		echo json_encode('wrong input');
		break;
}

function generatePassword($length=5){
	$symbol='qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM123456789';
	$code='';
	for($i=0; $i<=$length;$i++){
		$code.=$symbol[rand(0, strlen($symbol)-1)];
	}
	return $code;
}