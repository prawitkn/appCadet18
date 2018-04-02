<?php
include 'session.php';

try{
	$tb="cadet18_person";
	
	$barcode = $_POST['barcode'];
	$id=(int)$barcode;	
	
	//We start our transaction.
	//$pdo->beginTransaction();
	
	$sql = "UPDATE `".$tb."` SET isCount=1 WHERE id=:id ";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id);
	$stmt->execute();
	
	//We've got this far without an exception, so commit the changes.
    //$pdo->commit();
	
    //return JSON
	header('Content-Type: application/json');
	echo json_encode(array('success' => true, 'message' => 'Data updated'));	
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

