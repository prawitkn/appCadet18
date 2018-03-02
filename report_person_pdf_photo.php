<?php
ini_set('memory_limit', '1024M');
include('session.php');
//include('prints_function.php');
//include('inc_helper.php');

// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');

function to_thai_short_date($eng_date){
	if(strlen($eng_date) != 10){
		return null;
	}else{
		$new_date = explode('-', $eng_date);

		$new_y = (int) $new_date[0] + 543;
		$new_m = $new_date[1];
		$new_d = $new_date[2];

		//$new_d = to_thai_number((int)$new_d); // 01 -> ๑
	
		$thai_date = $new_d . '/' . $new_m . '/' . substr($new_y, 2, 2);
		//replace thai month
		$thai_short_date = '';
		switch($new_m){
			case '01' : $thai_short_date = str_replace("/01/"," ม.ค.",$thai_date); break;
			case '02' : $thai_short_date = str_replace("/02/"," ก.พ.",$thai_date); break;
			case '03' : $thai_short_date = str_replace("/03/"," มี.ค.",$thai_date); break;
			case '04' : $thai_short_date = str_replace("/04/"," เม.ย.",$thai_date); break;
			case '05' : $thai_short_date = str_replace("/05/"," พ.ค.",$thai_date); break;
			case '06' : $thai_short_date = str_replace("/06/"," มิ.ย.",$thai_date); break;
			case '07' : $thai_short_date = str_replace("/07/"," ก.ค.",$thai_date); break;
			case '08' : $thai_short_date = str_replace("/08/"," ส.ค.",$thai_date); break;
			case '09' : $thai_short_date = str_replace("/09/"," ก.ย.",$thai_date); break;
			case '10' : $thai_short_date = str_replace("/10/"," ต.ค.",$thai_date); break;
			case '11' : $thai_short_date = str_replace("/11/"," พ.ย.",$thai_date); break;
			case '12' : $thai_short_date = str_replace("/12/"," ธ.ค.",$thai_date); break;
		}
		
		//$thai_short_date = to_thai_number($thai_short_date);
		
		return $thai_short_date;
	}
}


// Extend the TCPDF class to create custom Header and Footer

class MYPDF extends TCPDF {
	//Page header
    public function Header() {
		// Set font
		$this->SetFont('THSarabun', '', 16, '', true);
		// Title
        
		//$this->SetY(11);			
		//if($this->page != 1){
			//Page No. top right n/N
			//$this->Cell(0, 5, $this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
			
			//$this->Cell(0, 5, '- '.$this->getAliasNumPage().' -', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		//}
		 // Logo
        //$image_file = '../asset/img/logo-asia-kangnam.jpg';
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		$this->SetY(11);	
		$this->Cell(0, 5, 'ตท. 18', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		//$this->Ln(5);
        //$this->Cell(0, 5, 'xxx', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        ///$this->SetY(-15);
        // Set font
        $this->SetFont('THSarabun', '', 14, '', true);
        // Page number
		$tmp = date('Y-m-d H:i:s');
		//$tmp = to_thai_short_date_fdt($tmp);
		$this->Cell(0, 10,'Print : '. $tmp, 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}



// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$title="Cadet18";
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Prawit Khamnet');
$pdf->SetTitle($title);
$pdf->SetSubject($title);
$pdf->SetKeywords($title);



// set default header data

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);



// set header and footer fonts

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));



// remove default header/footer

$pdf->setPrintHeader();

$pdf->setPrintFooter(false);



// set default monospaced font

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



//set margins

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);



//set auto page breaks

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



//set image scale factor

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



//set some language-dependent strings

//$pdf->setLanguageArray($l);



// ---------------------------------------------------------



// set font

//$pdf->SetFont('THSarabun', '', 16);
$pdf->SetFont('THSarabun', '', 14);


$sql = "SELECT  `id`, `mid`, `fullname`, `photo`, `nickname`, `origin`, `genNo`, `subService`,`position`, `workPlace`, `workPlace2`
, `dateOfBirth`, `mobileNo`, `tel`, `email`, `address`,`address2`,`groupCode`, `groupName`, `group2code`, `group2Name`, `statusCode`, `retireYear` 
FROM cadet18_person a
WHERE 1 ";
if(isset($_GET['groupCode'])){
	$sql.="and a.groupCode = :groupCode ";
}
if(isset($_GET['search_word']) and isset($_GET['search_word'])){
	$sql.="and (a.id = :search_word OR a.fullname like :search_word2) ";
}
$sql .="				
ORDER BY CAST(a.groupCode AS UNSIGNED), CAST(a.group2Code AS UNSIGNED), a.name    
"; 

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



//$dbquery = mysql_query($sql);



$i = 1;
$iperson_type1 = 0;
$iperson_type2 = 0;
$iperson_type3 = 0;
$iperpage = 0;
$ititle = "";
$ititle2 = "";

while ($result = $stmt->fetch()) {
	
	/*switch ($result['person_type']) {
		case "1":
			$iperson_type1 += 1;
			break;
		case "2":
			 $iperson_type2 += 1;
			break;
		case "3":
			 $iperson_type3 += 1;
			break;
	}*/
	if($iperpage == 0){
		if($ititle<>$result['groupName']){
			$pdf->AddPage();	
			$ititle = $result['groupName'];		
			$pdf->Cell(0, 0,'ทำเนียบ '. $ititle, 0, 0, 'C', 0, '', 0, false, 'T', 'B');
			$pdf->Ln(6);
		}else{
			$pdf->AddPage();
		}
		 $ititle2 = $result['group2Name'];		 
		 $pdf->Cell(50, 0, $ititle2, 0, 0, 'L', 0, '', 0, false, 'T', 'B');
		 $pdf->Ln(6);		
	}
	
	if($ititle2 != $result['group2Name']){
		if($iperpage != 0){	 
			//$pdf->writeHTML($html, true, false, true, false, '');
		}
		$pdf->AddPage();	
		$ititle2 =  $result['group2Name'];;
		$pdf->Cell(50, 0, $ititle2, 0, 0, 'L', 0, '', 0, false, 'T', 'B');
		$pdf->Ln(6);
		$iperpage = 0;
	}
	//$html .= '<tr>';
	if (file_exists('images/person/'.$result['photo'])) {
		if(trim($result['photo'])<>""){
			//$html .= '<td width="25%" style="border-bottom: 1px solid black;"><div align="center"><img src="images/'.$result['photo'].'" height="160"></div></td>';
			$img='images/person/'.$result['photo'];
			//$pdf->Image($img);
			//image width=150px;
			//$pdf->Image('@' . $img,xFromTop, yFromTop,'JPG');
			switch($iperpage){
				case 0 : $pdf->Image($img,15,35,25,'JPG');
					break;
				case 1 : $pdf->Image($img,15,75,25,'JPG');
					break;
				case 2 : $pdf->Image($img,15,115,25,'JPG');
					break;
				case 3 : $pdf->Image($img,15,155,25,'JPG');
					break;
				default :
			}
			
		}
		//$html .= '<td width="25%" style="border-bottom: 1px solid black;"><div align="center"><img src="images/no_pic.jpg" height="160"></div></td>';
	}else{
		//$html .= '<td width="25%" style="border-bottom: 1px solid black;"><div align="center"><img src="images/no_pic.jpg" height="160"></div></td>';
		$img='images/no_pic.jpg';
			//$pdf->Image($img);
			//image width=150px;
			//$pdf->Image('@' . $img,xFromTop, yFromTop,'JPG');
			switch($iperpage){
				case 0 : $pdf->Image($img,15,35,25,'JPG');
					break;
				case 1 : $pdf->Image($img,15,80,25,'JPG');
					break;
				case 2 : $pdf->Image($img,15,115,25,'JPG');
					break;
				case 3 : $pdf->Image($img,15,155,25,'JPG');
					break;
				default :
			}
	}
	$pdf->Cell(30, 0, '', 0, 0, 'L', 0, '', 0, false, 'T', 'B');	
	$pdf->Cell(25, 0, 'ยศ ชื่อ นามสกุล : ', 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(50, 0, $result['fullname'], 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	//$pdf->Cell(10, 0, ' : ', 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(25, 0, ': '.$result['nickname'], 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Ln(6);
	
	/*$pdf->Cell(50, 0, '', 0, 0, 'L', 0, '', 0, false, 'T', 'B');	
	$pdf->Cell(25, 0, 'กำเนิด : ', 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(10, 0, $result['origin'], 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(25, 0, 'รุ่น : ', 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(10, 0, $result['genNo'], 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(20, 0, 'เหล่า/พรรค : ', 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(10, 0, $result['subService'], 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Ln(6);*/
	
	$pdf->Cell(30, 0, '', 0, 0, 'L', 0, '', 0, false, 'T', 'B');	
	$pdf->Cell(25, 0, 'ตำแหน่ง : ', 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(200, 0, $result['position'], 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Ln(6);
	
	$pdf->Cell(30, 0, '', 0, 0, 'L', 0, '', 0, false, 'T', 'B');	
	$pdf->Cell(25, 0, 'สถานที่ทำงาน : ', 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(200, 0, $result['workPlace'], 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Ln(6);
	
	$pdf->Cell(30, 0, '', 0, 0, 'L', 0, '', 0, false, 'T', 'B');	
	$pdf->Cell(25, 0, '', 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(200, 0, ($result['workPlace2']<>""?$result['workPlace2']:"-"), 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Ln(6);
	
	/*$pdf->Cell(50, 0, '', 0, 0, 'L', 0, '', 0, false, 'T', 'B');	
	$pdf->Cell(25, 0, 'สถานที่ทำงาน : ', 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(200, 0, $result['workPlace'], 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Ln(6);
	
	$pdf->Cell(50, 0, '', 0, 0, 'L', 0, '', 0, false, 'T', 'B');	
	$pdf->Cell(25, 0, 'เกิดเมื่อ : ', 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(25, 0, to_thai_short_date($result['dateOfBirth']), 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Ln(6);*/	
	
	$pdf->Cell(30, 0, '', 0, 0, 'L', 0, '', 0, false, 'T', 'B');	
	$pdf->Cell(25, 0, 'ที่อยู่ : ', 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(100, 0, $result['address'], 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Ln(6);
	
	$pdf->Cell(30, 0, '', 0, 0, 'L', 0, '', 0, false, 'T', 'B');	
	$pdf->Cell(25, 0, '', 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(100, 0, ($result['address2']<>""?$result['address2']:"-"), 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Ln(6);
	
	$pdf->Cell(30, 0, '', 0, 0, 'L', 0, '', 0, false, 'T', 'B');	
	$pdf->Cell(25, 0, 'โทร : ', 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Cell(100, 0, $result['mobileNo'].' '.($result['tel']<>""?', '.$result['tel']:''), 0, 0, 'L', 0, '', 0, false, 'T', 'B');
	$pdf->Ln(6);
	
	/*$html .= '
	<td width="75%" style="border-bottom: 1px solid black;"><div align="left">
		<b>ยศ ชื่อ นามสกุล : </b> '.$result['fullname'].' 
		<b>ชื่อเล่น : </b>'.(trim($result['nickname'])==""?"..........":$result['nickname']).'<br/>
		
		
		<b>กำเนิด : </b>'.($result['origin']==""?"..........":$result['origin']).' 
		<b>รุ่น : </b>'.($result['genNo']==""?"..........":$result['genNo']).' 
		<b>พรรค/เหล่า : </b>'.(trim($result['subService'])==""?"..........":$result['subService']).'<br/>
		
		<b>ตำแหน่ง : </b>'.($result['position']==""?"....................":$result['position']).'<br/>
		
		<b>สถานที่ทำงาน : </b>'.($result['workPlace']==""?"....................":$result['workPlace']).'<br/>
		
		<b>เกิดเมื่อ : </b>'.($result['dateOfBirth']==""?"....................":to_thai_short_date($result['dateOfBirth'])).'<br/>
		
		<b>โทร,มือถือ : </b>'.($result['mobileNo']==""?"....................":$result['mobileNo']).'<br/>
	</div></td>

  </tr>';*/
  
  $i++;
  $iperpage += 1;
	
  if($iperpage == 5){
	  //$pdf->writeHTML($html, true, false, true, false, '');
	  
	   
	  
	//$html = '';
	$iperpage = 0;
  }	  

}



// output the HTML content
// $html .= '</table>';
//$pdf->writeHTML($html, true, false, true, false, '');



// reset pointer to the last page

$pdf->lastPage();



// ---------------------------------------------------------



//Change To Avoid the PDF Error 

ob_end_clean();

  

//Close and output PDF document

$pdf->Output($title.'.pdf', 'I');



//============================================================+

// END OF FILE                                                

//============================================================+