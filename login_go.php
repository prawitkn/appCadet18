<?php
include_once 'session.php';

$tb = "cadet18_user";

//$userName = mysqli_real_escape_string($link,$_POST['userName']);
//$userPassword = mysqli_real_escape_string($link,$_POST['userPassword']);
$userName = $_POST['userName'];
$userPassword = $_POST['userPassword'];

// Encript Password
//$salt = "asdadasgfd";
$salt = "13ig130y#cadet18";
$hash_login_password = hash_hmac('sha256', $userPassword, $salt);

$sql = "SELECT userId FROM ".$tb." WHERE (userName=:userName AND userPassword=:hash_login_password) LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userName', $userName);
$stmt->bindParam(':hash_login_password', $hash_login_password);
$stmt->execute();

if($stmt->rowCount()>=1){
	session_start();
	$row_user=$stmt->fetch();
	$_SESSION['s_userId']=$row_user['userId'];
	
	header('Content-Type: application/json');
	echo json_encode(array('status' => 'success'));      
} else {
	header('Content-Type: application/json');
	$errors = "Username or Password incorrect."; 
	echo json_encode(array('status' => 'danger', 'message' => $errors));
}
