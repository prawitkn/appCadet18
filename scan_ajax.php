<?php
	include 'session.php'; /*$s_userFullname = $row_user['userFullname'];
        $s_userPicture = $row_user['userPicture'];
		$s_username = $row_user['userName'];
		$s_userGroupCode = $row_user['userGroupCode'];
		$s_userDept = $row_user['userDept'];*/

	$barcode = $_POST['barcode'];
	$id=(int)$barcode;
	$sql = "SELECT `id`, `title`, `name`, `surname`, `fullname`, `photo`, `nickname`
	, `position`, `workPlace`, `workPlace2`, `mobileNo`
	, `groupCode`, `groupName`, `group2code`, `group2Name`
	, `statusCode`
	FROM `cadet18_person` WHERE id=:id ";
	//$result = mysqli_query($link, $sql);
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id);
	$stmt->execute();
	
	//$jsonData = array();
	//while ($array = $stmt->fetch()) {
	//	$jsonData[] = $array;
	//}
	if ($stmt->execute()) {
		header('Content-Type: application/json');
		echo json_encode(array('success' => true, 'message' => 'Data Updated Complete.', 'itm' => json_encode($stmt->fetch())));
	} else {
		header('Content-Type: application/json');
		$errors = "Error on Data Update. Please try new username. " . $pdo->errorInfo();
		echo json_encode(array('success' => false, 'message' => $errors));
	}
 					   
	//echo json_encode($jsonData);
	
?>


