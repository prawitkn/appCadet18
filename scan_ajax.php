<?php
include 'session.php';

try{
	$tb="cadet18_person";
	
	$barcode = $_POST['barcode'];
	$id=(int)$barcode;	
	
	$sql = "SELECT `id`, `coupon`, `title`, `name`, `surname`, `fullname`, `photo`, `nickname`
	, `position`, `workPlace`, `workPlace2`, `mobileNo`
	, `groupCode`, `groupName`, `group2code`, `group2Name`, `isCount`
	, `statusCode`
	FROM `".$tb."` WHERE id=:id ";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id);
	$stmt->execute();
	
	$itm="";
	$errors="";
	switch($stmt->rowCount()){
		case 1 : $itm = json_encode($stmt->fetch()); break;
		case 0 : $errors="Data not found."; 
			header('Content-Type: application/json');
			echo json_encode(array('success' => false, 'message' => $errors));
			break;
		default : $errors="Duplicate result."; 
			header('Content-Type: application/json');
			echo json_encode(array('success' => false, 'message' => $errors));			
	}
	
	//We start our transaction.
	//$pdo->beginTransaction();
	
	/*$sql = "UPDATE `".$tb."` SET isCount=1 WHERE id=:id ";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id);
	$stmt->execute();*/
	
	//We've got this far without an exception, so commit the changes.
    //$pdo->commit();
	
    //return JSON
	header('Content-Type: application/json');
	echo json_encode(array('success' => true, 'message' => 'Data updated', 'itm' => $itm));	
} 
//Our catch block will handle any exceptions that are thrown.
catch(Exception $e){
	//Rollback the transaction.
    //$pdo->rollBack();
	//return JSON
	header('Content-Type: application/json');
	$errors = "Error on Data Update. Please try again. " . $e->getMessage();
	echo json_encode(array('success' => false, 'message' => $errors));
}	
?>

