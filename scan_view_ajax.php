<?php
include 'session.php';

try{
	//$tb="cadet18_person";
	
	$sql = "SELECT a.groupCode
	,(SELECT SUM(b.isInvite) as inviteTotal
		FROM cadet18_person b WHERE b.groupCode=a.groupCode) as inviteTotal
	,(SELECT SUM(c.isCount) as countTotal 
		FROM cadet18_person c  WHERE c.groupCode=a.groupCode) as countTotal
	FROM cadet18_person a
	GROUP BY a.groupCode ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
		
	//We start our transaction.
	//$pdo->beginTransaction();
	
	//We've got this far without an exception, so commit the changes.
    //$pdo->commit();
	
	//return JSON
	$rowCount=$stmt->rowCount();

	$jsonData = array();
	while ($array = $stmt->fetch()) {
		$jsonData[] = $array;
	}
 	
	header('Content-Type: application/json');				   
	echo json_encode(array('success' => true, 'message' => 'Data updated', 'rowCount' => $rowCount, 'data' => json_encode($jsonData)));
	
    
	//header('Content-Type: application/json');
	//echo json_encode(array('success' => true, 'message' => 'Data updated', 'itm' => $itm));	
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

