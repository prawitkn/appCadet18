<?php
    session_start();
    if (!isset($_SESSION['s_userId'])){
        header("Location: login.php");
    }
	
	//database connection string.
	$is_local = true;
	if($is_local){
		include 'db/database_localhost.php';
	}else{
		include 'db/database.php';
	}
		
	$tb="cadet18_user"; 
	$sql = "SELECT u.`userId`, u.`userFullname`, u.`userGroupCode`, u.`smId`, u.`userEmail`, u.`userTel`, u.`userPicture`, u.`statusCode` 
	FROM ".$tb." u WHERE u.userId=:s_userId LIMIT 1";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':s_userId', $_SESSION['s_userId']);	
    if ($stmt->execute()) {
        $row_user = $stmt->fetch(); // mysqli_fetch_array($result_user,MYSQLI_ASSOC);
		$s_userId = $row_user['userId'];
        $s_userFullname = $row_user['userFullname'];
        //$s_userPicture = $row_user['userPicture'];
		//$s_username = $row_user['userName'];
		$s_userGroupCode = $row_user['userGroupCode'];
		//$s_smCode = $row_user['smCode'];
		//$s_smId = $row_user['smId'];
		
        
        //$s_admin = $row_user['userName'];
        
        //mysqli_free_result($result_user);  
		$stmt->closeCursor();
    }