<?php
    include 'session.php';	
	
function to_thai_date($eng_date){
	if(strlen($eng_date) != 10){
		return null;
	}else{
		$new_date = explode('-', $eng_date);

		$new_y = (int) $new_date[0] + 543;
		$new_m = $new_date[1];
		$new_d = $new_date[2];

		$thai_date = $new_d . '/' . $new_m . '/' . $new_y;

		return $thai_date;
	}
}
function to_thai_datetime_fdt($eng_date){
	//if(strlen($eng_date) != 10){
	//    return null;
	//}else{
		$new_datetime = explode(' ', $eng_date);
		$new_date = explode('-', $new_datetime[0]);

		$new_y = (int) $new_date[0] + 543;
		$new_m = $new_date[1];
		$new_d = $new_date[2];

		$thai_date = $new_d . '/' . $new_m . '/' . $new_y . ' ' . substr($new_datetime[1],0,5);

		return $thai_date;
	//}
}
function to_mysql_date($thai_date){
	if(strlen($thai_date) != 10){
		return null;
	}else{
		$new_date = explode('/', $thai_date);

		$new_y = (int)$new_date[2] - 543;
		$new_m = $new_date[1];
		$new_d = $new_date[0];

		$mysql_date = $new_y . '-' . $new_m . '-' . $new_d;

		return $mysql_date;
	}
}
	
	$tb='cadet18_person';
	
	if(!isset($_POST['action'])){		
		header('Content-Type: application/json');
		echo json_encode(array('success' => false, 'message' => 'No action.'));
	}else{
		switch($_POST['action']){
			case 'add' :				
				$title = $_POST['title'];
				$name = $_POST['name'];
				$surname = $_POST['surname'];
				$fullname = $title.' '.$name.'  '.$surname;
				$nickname = $_POST['nickname'];
				$origin = $_POST['origin'];
				$genNo = $_POST['genNo'];
				$subService = $_POST['subService'];
				$position = $_POST['position'];
				$workPlace = $_POST['workPlace'];
				$dateOfBirth = $_POST['dateOfBirth'];
				$mobileNo = $_POST['mobileNo'];
				$tel = $_POST['tel'];
				$email = $_POST['email'];
				$address = $_POST['address'];
				$groupCode = $_POST['groupCode'];
				$group2code = $_POST['group2code'];
				$group2Name = $_POST['group2Name'];
				$retireYear = $_POST['retireYear'];
								
				// Check duplication?
				$sql = "SELECT id FROM cadet18_person WHERE name='$name' AND surname='$surname' ";
				$result = mysqli_query($link, $sql);
				$rowCount = mysqli_num_rows($result);
				if ($rowCount >= 1){
				  header('Content-Type: application/json');
				  $errors = "Error on Data Insertion. Duplicate data, Please try new username. " . mysqli_error($link);
				  echo json_encode(array('success' => false, 'message' => $errors));  
				  exit;    
				}   
	
				$photo="";
				 // Upload Picture
				if (is_uploaded_file($_FILES['inputFile']['tmp_name'])){
					$photo = 'person_'.uniqid().".".pathinfo(basename($_FILES['inputFile']['name']), PATHINFO_EXTENSION);
					$path_upload = "dist/img/person/".$photo;
					move_uploaded_file($_FILES['inputFile']['tmp_name'], $path_upload);        
				}

				$sql = "INSERT INTO `cadet18_person` (`title`, `name`, `surname`, `fullname`, `photo`, `nickname`
				, `origin`, `genNo`, `subService`, `position`, `workPlace`, `dateOfBirth`, `mobileNo`, `tel`, `email`
				, `address`, `groupCode`, `group2code`, `group2Name`, `statusCode`, `retireYear`)
				 VALUES ('$title', '$name', '$surname', '$fullname', '$photo', '$nickname'
				 , '$origin', '$genNo', '$subService', '$position', '$workPlace', '$dateOfBirth', '$mobileNo', '$tel', '$email'
				 , '$address', '$groupCode', '$group2code', '$group2Name', 'A', '$retireYear')";

				$result = mysqli_query($link, $sql);
				if ($result) {
					header('Content-Type: application/json');
					echo json_encode(array('success' => true, 'message' => 'Data Inserted Complete.'));
				} else {
					header('Content-Type: application/json');
					$errors = "Error on Data Insertion. Please try new username. " . mysqli_error($link);
					echo json_encode(array('success' => false, 'message' => $errors));
				}				
				break;
				exit();
			case 'edit' :
				$id = $_POST['id'];
				$title = $_POST['title'];
				$name = $_POST['name'];
				$surname = $_POST['surname'];
				$fullname = $title.' '.$name.'  '.$surname;
				$nickname = $_POST['nickname'];
				$origin = $_POST['origin'];
				$genNo = $_POST['genNo'];
				$subService = $_POST['subService'];
				$position = $_POST['position'];
				$workPlace = $_POST['workPlace'];
				$dateOfBirth = $_POST['dateOfBirth'];
				$mobileNo = $_POST['mobileNo'];
				$tel = $_POST['tel'];
				$email = $_POST['email'];
				$address = $_POST['address'];
				$groupCode = $_POST['groupCode'];
				$group2code = $_POST['group2code'];
				$group2Name = $_POST['group2Name'];
				$retireYear = $_POST['retireYear'];
				$curPhoto = $_POST['curPhoto'];				
				$photo="";
				// Check user name duplication?
				$sql = "SELECT id FROM cadet18_person WHERE id=:id LIMIT 1 ";
				$stmt = $pdo->prepare($sql);	
				$stmt->bindParam(':id', $id);
				$stmt->execute();	
				if ($stmt->rowCount() <> 1){
				  header('Content-Type: application/json');
				  $errors = "Error on Data Update. Please try new username. " . $pdo->errorInfo();
				  echo json_encode(array('success' => false, 'message' => $errors));  
				  exit;    
				} 			
			  
				//inputFile
				if (is_uploaded_file($_FILES['inputFile']['tmp_name'])){
					// If the old picture already exists, delete it
					if (file_exists('dist/img/person/'.$curPhoto)) unlink('dist/img/person/'.$curPhoto);
				
					$photo = 'person_'.uniqid().".".pathinfo(basename($_FILES['inputFile']['name']), PATHINFO_EXTENSION);
					$path_upload = "dist/img/person/".$photo;
					move_uploaded_file($_FILES['inputFile']['tmp_name'], $path_upload);        
				}
				//Sql
				$dateOfBirth=to_mysql_date($dateOfBirth);
				$sql = "UPDATE `cadet18_person` SET `title`=:title 
				, `name`=:name
				, `surname`=:surname
				, `fullname`=:fullname 
				, `nickname`=:nickname
				, `origin`=:origin
				, `genNo`=:genNo
				, `subService`=:subService
				, `position`=:position 
				, `workPlace`=:workPlace 
				, `dateOfBirth`=:dateOfBirth 
				, `mobileNo`=:mobileNo 
				, `tel`=:tel 
				, `email`=:email 
				, `address`=:address 
				, `groupCode`=:groupCode 
				, `group2code`=:group2code 
				, `group2Name`=:group2Name 
				, `retireYear`=:retireYear 
				, `photo`=:photo 
				WHERE id=:id 
				";	
				$stmt = $pdo->prepare($sql);	
				$stmt->bindParam(':title', $title);
				$stmt->bindParam(':name', $name);
				$stmt->bindParam(':surname', $surname);
				$fullname=$title.' '.$name.'  '.$surname;
				$stmt->bindParam(':fullname', $fullname);
				$stmt->bindParam(':nickname', $nickname);
				$stmt->bindParam(':origin', $origin);
				$stmt->bindParam(':genNo', $genNo);
				$stmt->bindParam(':subService', $subService);
				$stmt->bindParam(':position', $position);
				$stmt->bindParam(':workPlace', $workPlace);
				$stmt->bindParam(':dateOfBirth', $dateOfBirth);
				$stmt->bindParam(':mobileNo', $mobileNo);
				$stmt->bindParam(':tel', $tel);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':address', $address);
				$stmt->bindParam(':groupCode', $groupCode);
				$stmt->bindParam(':group2code', $group2code);
				$stmt->bindParam(':group2Name', $group2Name);
				$stmt->bindParam(':retireYear', $retireYear);
				$stmt->bindParam(':photo', $photo);
				$stmt->bindParam(':id', $id);
				if ($stmt->execute()) {
					  header('Content-Type: application/json');
					  echo json_encode(array('success' => true, 'message' => 'Data Updated Complete.'));
				   } else {
					  header('Content-Type: application/json');
					  $errors = "Error on Data Update. Please try new data. " . $pdo->errorInfo();
					  echo json_encode(array('success' => false, 'message' => $errors));
				}	
				break;
			case 'setStatus' :
				break;
			case 'delete' :
				break;
			default : 
				header('Content-Type: application/json');
				echo json_encode(array('success' => false, 'message' => 'Unknow action.'));				
		}
	}