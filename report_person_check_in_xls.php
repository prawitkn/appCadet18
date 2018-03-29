<?php
include 'session.php';
include 'inc_helper.php'; 

require_once '../phpexcel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Prawit Khamnet")
        ->setTitle("WMS")
        ->setSubject("Sales Order Report")
        ->setDescription("Excel File")
        ->setKeywords("Sales Order")
        ->setCategory("Sales Order");
		
$dateFrom = (isset($_GET['dateFrom'])?$_GET['dateFrom']:'');
$dateTo = (isset($_GET['dateTo'])?$_GET['dateTo']:'');

$dateFromYmd=$dateToYmd="";
if($dateFrom<>""){ $dateFromYmd = to_mysql_date($_GET['dateFrom']);	}
if($dateFrom<>""){ $dateToYmd = to_mysql_date($_GET['dateTo']);	}


							
$sql = "SELECT COUNT(*) as countTotal 
FROM cadet18_person a
WHERE 1 ";
if(isset($_GET['groupCode'])){
	$sql.="and a.groupCode = :groupCode ";
}
if(isset($_GET['search_word']) and isset($_GET['search_word'])){
	$sql.="and (a.id = :search_word OR a.fullname like :search_word2) ";
}

$stmt = $pdo->prepare($sql);
if(isset($_GET['groupCode']) AND $_GET['groupCode']<>""){
	$stmt->bindParam(':groupCode', $_GET['groupCode']);
}
if(isset($_GET['search_word']) and isset($_GET['search_word'])){
	$search_word='%'.$_GET['search_word'].'%';
	$stmt->bindParam(':search_word', $search_word);
	$stmt->bindParam(':search_word2', $search_word);
}

$stmt->execute();	

$row=$stmt->fetch();
$countTotal = $row['countTotal'];

if($countTotal>0){
	// Add Header
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'รหัสประเภท')
		->setCellValue('B1', 'ประเภท')
		->setCellValue('C1', 'รหัสกลุ่ม')
		->setCellValue('D1', 'กลุ่ม')
		->setCellValue('E1', 'ลำดับ')
		->setCellValue('F1', 'รหัส')
		->setCellValue('G1', 'คำนำหน้า')
		->setCellValue('H1', 'ชื่อ')
		->setCellValue('I1', 'นามสกุล')
		->setCellValue('J1', 'ชื่อเล่น')
		;
		
		$sql = "SELECT `id`, `orderNo`, `title`, `name`, `surname`, `fullname`, `photo`, `nickname`, `position`
		, `groupCode`, `groupName`, `group2code`, `group2Name`
		, `isInvite`, `isCount`, `statusCode`				
		, IF(left(name,1) IN ('เ','แ','ไ','ใ','โ'),right(name,CHAR_LENGTH(name)-1),name) as nameForOrder 
		FROM cadet18_person a
		WHERE 1 ";
		if(isset($_GET['groupCode'])){
			$sql.="and a.groupCode = :groupCode ";
		}
		if(isset($_GET['search_word']) and isset($_GET['search_word'])){
			$sql.="and (a.id = :search_word OR a.fullname like :search_word2) ";
		}
		if(isset($_GET['orderBy'])){
			switch($_GET['orderBy']){
				case 1 : 
					$sql .="ORDER BY CAST(a.groupCode AS UNSIGNED), CAST(a.group2Code AS DECIMAL(10,2)), orderNo "; 
					break;
				case 2 : 
					$sql .="ORDER BY CAST(a.groupCode AS UNSIGNED), CAST(a.group2Code AS DECIMAL(10,2)), nameForOrder "; 
					break;
				case 3 : 
					$sql .="ORDER BY CAST(a.groupCode AS UNSIGNED), nameForOrder "; 
					break;
				default : 
					$sql .="ORDER BY CAST(a.groupCode AS UNSIGNED), CAST(a.group2Code AS DECIMAL(10,2)), a.id "; 		
			}
		}

		$stmt = $pdo->prepare($sql);
		if(isset($_GET['groupCode']) AND $_GET['groupCode']<>""){
			$stmt->bindParam(':groupCode', $_GET['groupCode']);
		}
		if(isset($_GET['search_word']) and isset($_GET['search_word'])){
			$search_word='%'.$_GET['search_word'].'%';
			$stmt->bindParam(':search_word', $search_word);
			$stmt->bindParam(':search_word2', $search_word);
		}

		$stmt->execute();	
	
	$iRow=2; while($row = $stmt->fetch()){
	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)		
		->setCellValue('A'.$iRow, $row['groupCode'])
		->setCellValue('B'.$iRow, $row['groupName'])
		->setCellValue('C'.$iRow, $row['group2code'])
		->setCellValue('D'.$iRow, $row['group2Name'])
		->setCellValue('E'.$iRow, $row['orderNo'])
		->setCellValue('F'.$iRow, $row['id'])
		->setCellValue('G'.$iRow, $row['title'])
		->setCellValue('H'.$iRow, $row['name'])
		->setCellValue('I'.$iRow, $row['surname'])
		->setCellValue('J'.$iRow, $row['nickname'])
		;
		
		$iRow+=1;
	}
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Data');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="check_in.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_clean();
$objWriter->save('php://output');
exit;