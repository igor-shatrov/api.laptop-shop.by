<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Version, Authorization, Content-Type');
header("Content-Type: application/json; charset=UTF-8");
require_once('function.php');
$data=(array)json_decode(file_get_contents('php://input'));
$conn=connect();
$sql="SELECT privileges, id FROM users WHERE email='".$data['login']."' AND password='".md5($data['password'])."'";
$query=mysqli_query($conn, $sql);

if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $hash=generateHash(10);
        $sql="UPDATE users SET hash='".$hash."' WHERE id='".$row['id']."'";
        mysqli_query($conn, $sql);
        $row['hash']=$hash;
        echo  json_encode($row);
    }else{
    	echo json_encode('not found');
    }

close($conn);

function generateHash($length=5){
	$symbol='qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
	$code='';
	for($i=0; $i<=$length;$i++){
		$code.=$symbol[rand(0, strlen($symbol)-1)];
	}
	return $code;
}


